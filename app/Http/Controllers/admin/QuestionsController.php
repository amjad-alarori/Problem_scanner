<?php

namespace App\Http\Controllers\admin;

use App\Helpers\UploadHelper;
use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Questions;
use App\Models\Scan;
use Facade\FlareClient\Truncation\AbstractTruncationStrategy;
use Faker\Provider\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.questions', ['categories' => Categories::all()->pluck('name', 'id'), 'questions' => Questions::all()]);
    }

    public function create()
    {
        $categories = Categories::all()->pluck('name', 'id');
        return view('admin.questions.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'question' => 'required',
            'categories_id' => 'required',
            'image' => 'required|image'
        ]);
        $question = Questions::create($validated);
        $question->image = UploadHelper::UploadImage($request->file('image'))['url'];
        $question->AddOrUpdateTranslations($request->input('language'));
        return redirect(route('questions.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Questions $questions
     * @return \Illuminate\Http\Response
     */
    public function show(Questions $questions)
    {
        //
    }

    public function edit(Questions $question)
    {
        $categories = Categories::all()->pluck('name', 'id');
        return view('admin.questions.edit', compact('question', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Questions $questions
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $question = Questions::find($id);
        $question->question = $request->question;
        $question->categories_id = $request->category;
        if ($request->file('image') != null) {
            $path = $request->file('image')->store('images', 's3');
            Storage::disk('s3')->setVisibility($path, 'public');
            $question->image = Storage::disk('s3')->url($path);
        }
        $question->save();
        $question->AddOrUpdateTranslations($request->input('language'));
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Questions $questions
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        Questions::find($id)->delete();
        return redirect()->back();
    }

    public function trashed()
    {
        $questions = Questions::onlyTrashed()->paginate(15);
        return view('admin.questions.trashed', compact('questions'));
    }

    public function updateTrashed($id)
    {
        $question = Questions::withTrashed()->find($id);
        $question->deleted_at = null;
        $question->save();
        return back()->with('success', 'vraag teruggezet!');
    }
}
