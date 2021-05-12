<?php

namespace App\Http\Controllers;

use App\Models\ConsulentClients;
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
        if (Auth::user()->roles[0]->level == 2 || Auth::user()->roles[0]->level == 3) {
            $clients_id = [Auth::id()];
            $clients = ConsulentClients::where('consulent_id', Auth::id())->where('verified', 1)->get();
            foreach ($clients as $client) {
                array_push($clients_id, $client->client_id);
            }
            $results = Results::whereIn('user_id', $clients_id)->get()->unique('user_id');
        } else {
            $results = User::find(Auth::id())->results;
        }
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

        if (in_array(Auth::user()->roles[0]->level, [2, 3]) && !empty($request->post('selected_user'))) {
            $scan->user_id = $request->post('selected_user');
            $scan->name = User::find($request->selected_user)->name;
        } else {
            $scan->user_id = Auth::id();
            $scan->name = Auth::user()->name;
        }

        $scan->scan_id = $request->post('scan_id');
        $scan->scan = Scan::findOrFail($request->post('scan_id'))->name;

        $answers = $request->post('answers');
        $db_answers = [];

        foreach($answers as $question_id => $answer) {
            $question = Questions::findOrFail($question_id);
            $db_answers[$question_id] = ['answer' => (int) $answer, 'question_id' => $question_id, 'category' => $question->categories->id];
        }

        $scan->results = json_encode($db_answers);
        $scan->save();
        return redirect()->route('results.index');
    }
}
