<?php
namespace App\Http\Controllers;

use App\Models\Questions;
use App\Models\Results;
use App\Models\Scan;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Auth;
use Redirect;


class ResultsController extends Controller
{
    public function index()
    {
        $results = User::find(Auth::id())->results->unique('name');
        return view('results.index', compact('results'));
    }

    public function show(Results $result)
    {
        $results = json_decode($result->results);
        $questions = [];
        foreach ($results as $key => $value) {
            $questions[$key] = [Questions::find($key)->question => $value];
        }
        return view('results.show', compact('result', 'questions'));
    }

    public function store(Request $request)
    {
        $scan = new Results();
        if (!empty($request->name)) {
                $scan->name = $request->name;
        } else {
            $scan->name = $request->selected_user;
        }
        $scan->scan_id = $request->scan_id;
        $scan->scan = $request->scan;
        $scan->user_id = Auth::id();
        $answers = [];
        foreach (Questions::all() as $question) {
            if (!empty($request['selectedvalue' . $question->id])) {
                $answers[$question->id] = ['answer' => $request['selectedvalue' . $question->id], 'question_id' => $question->id, 'category' => $request['category' . $question->id]];
            } else {
                $answers[$question->id] = ['answer' => 0, 'question_id' => $question->id, 'category' => $request['category' . $question->id]];
            }
        }
//        dd($answers);
        $scan->results = json_encode($answers);
        $scan->save();
        return redirect()->route('results.index');
    }
}
