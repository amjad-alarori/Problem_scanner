<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Questions;
use App\Models\Scan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.categories', ['categories' => Categories::all(), 'scans' => Scan::pluck('name', 'id')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'scan_id' => 'required',
            'image' => 'required|image',
            'color' => 'required',
        ]);
        $category = new Categories();
        $category->name = $request->name;
        $category->scan_id = $request->scan;
        if ($request->file('image') != null) {
            $path = $request->file('image')->store('images', 's3');
            Storage::disk('s3')->setVisibility($path, 'public');
            $category->image = Storage::disk('s3')->url($path);
        }
        $category->color = $request->color;
        $saved = $category->save();
        if ($saved) {
            return redirect()->back();
        } else {
            App::abort(500, 'Error');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Categories $categories
     * @return \Illuminate\Http\Response
     */
    public function show(Categories $categories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Categories $categories
     * @return \Illuminate\Http\Response
     */
    public function edit(Categories $categories)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $categories = Categories::find($id);
        $categories->name = $request->category;
        if ($request->file('image') != null) {
            $path = $request->file('image')->store('images', 's3');
            Storage::disk('s3')->setVisibility($path, 'public');
            $categories->image = Storage::disk('s3')->url($path);
        }
        $categories->color = $request->color;
        $categories->save();
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Categories $categories
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($categories)
    {
        $questions = Questions::where('categories_id', '=', $categories);
        $questions->delete();
        $categories = Categories::find($categories);
        $categories->delete();
        return redirect()->back();
    }

    public function trashed()
    {
        $categories = Categories::onlyTrashed()->paginate(15);
        return view('admin.categories.trashed', compact('categories'));
    }

    public function updateTrashed($id)
    {
        $Categories = Categories::withTrashed()->find($id);
        $Categories->deleted_at = null;
        $Categories->save();
        return back()->with('success', 'categorie teruggezet!');
    }
}
