<?php

namespace App\Http\Controllers;


use App\Models\Categories;
use App\Models\ConsulentClients;
use App\Models\Questions;
use App\Models\Results;
use App\Models\Scan;
use App\Models\User;
use \Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Response;


class ExportController extends Controller
{
    private $id;

    public function show($result)
    {

        $result_id = $result;
        $name = Results::find($result)->only('user_id');
        $name = $name['user_id'];
        if ($name != Auth::id()) {
            if (Auth::user()->level() == 2) {
                $clients = ConsulentClients::where('consulent_id', Auth::id())->where('client_id', $name)->where('verified', 1)->get();
                if (!count($clients) > 0) {
                    return redirect('/404');
                }
            } else {
                return redirect('/404');
            }
        }
        $allquestions = $this->getAllQuestions($name, false);
        $firstResult = Results::where('user_id', $name)->oldest()->first();

        $firstquestions = $this->getFirstQuestions($firstResult);
        $categories = $this->getCategories($firstResult);
        $questionsForCategories = $this->getAllQuestions($name, true);
        $categoryResults = $this->getBarData($questionsForCategories);
        foreach ($categoryResults as $index => $category) {
            $categoryImage = Categories::where('name', $category['label'])->get();
            $categoryResults[$index] = ['label' => $category['label'], 'image' => $categoryImage[0]['image'], 'data' => $category['data']];
        }
        $results = Results::where('user_id', $name)->orderBy('created_at', 'ASC')->get();
        $questions = $this->getQuestionsResults($results);
        $categoryLabels = $this->getDates($results);
        $AuthUser = Auth::user();
        return view('export.index', compact('firstResult', 'questions', 'firstquestions', 'categoryLabels', 'result_id', 'categories', 'categoryResults', 'allquestions', 'AuthUser'));
    }

    public function getQuestionsResults($results)
    {
        $allresults = [];
        $questions = Questions::all();
        foreach ($results as $result) {
            $results = json_decode($result->results, true);
            foreach ($results as $item) {
                $this->id = $item['question_id'];
                $question = $questions->filter(function ($item) {
                    return $item->id == $this->id;
                })->first();
                if (array_key_exists($item['question_id'], $allresults)) {
                    array_push($allresults[$item['question_id']]['answers'], $item['answer']);
                } else {
                    $allresults[$item['question_id']] = ['answers' => [$item['answer']], 'image' => $question['image'], 'question' => $question['question']];
                }
            }
        }
        return $allresults;
    }

    public function getAllQuestions($name, $simplyfied)
    {
        $allquestions = [];
        $scans = Results::where('user_id', $name)->orderByDesc('created_at')->get();
        foreach ($scans as $result) {
            $results = json_decode($result->results);
            $questions = [];
            foreach ($results as $item) {
                if (array_key_exists($item->category, $questions)) {
                    $questions[$item->category] = ['id' => (int)$item->category, 'value' => (int)$item->answer + $questions[$item->category]['value']];
                } else {
                    $questions[$item->category] = ['id' => (int)$item->category, 'value' => (int)$item->answer];
                }
            }
//            dd($questions);
            foreach ($questions as $question) {
                $category = Categories::find($question['id']);
                if ($simplyfied) {
                    $questions[$question['id']] = ['id' => (int)$question['id'], 'value' => (int)round((int)$question['value'] / Questions::where('categories_id', $question['id'])->count()), 'category' => $category->name, 'color' => $category->color];
                } else {
                    $questions[$question['id']] = ['id' => (int)$question['id'], 'value' => (int)$question['value'], 'questionCount' => Questions::where('categories_id', $question['id'])->count(), 'category' => $category->name, 'color' => $category->color];
                }
            }
            $allquestions[$result->id] = $questions;
        }
        return $allquestions;
    }

    public function getAllQuestionsJSON($name, $simplyfied)
    {
        $allquestions = [];
        $scans = Results::where('user_id', $name)->get();
        foreach ($scans as $result) {
            $results = json_decode($result->results);
            $questions = [];
            foreach ($results as $item) {
                if (array_key_exists($item->category, $questions)) {
                    $questions[$item->category] = ['id' => (int)$item->category, 'value' => (int)$item->answer + $questions[$item->category]['value']];
                } else {
                    $questions[$item->category] = ['id' => (int)$item->category, 'value' => (int)$item->answer];
                }
            }
            foreach ($questions as $question) {
                $category = Categories::find($question['id']);
                if ($simplyfied) {
                    $questions[$question['id']] = ['id' => (int)$question['id'], 'value' => (int)round((int)$question['value'] / Questions::where('categories_id', $question['id'])->count()), 'category' => $category->name, 'color' => $category->color];
                } else {
                    $questions[$question['id']] = ['id' => (int)$question['id'], 'value' => (int)$question['value'], 'questionCount' => Questions::where('categories_id', $question['id'])->count(), 'category' => $category->name, 'color' => $category->color];
                }
            }
            $allquestions[$result->id] = $questions;
        }
        return $allquestions;
    }

    public function getCategoryResults($questions)
    {
        $categories = [];
        $finalcat = [];
        foreach ($questions as $question => $value) {
            foreach ($value as $item) {
                if (array_key_exists($item['id'], $categories)) {
                    array_push($categories[$item['id']]['data'], $item['value']);
                } else {
                    $categories[$item['id']] = ['label' => $item['category'], 'backgroundColor' => $item['color'], 'data' => [$item['value']]];
                }
            }
        }
        foreach ($categories as $category) {
            array_push($finalcat, $category);
        }
        return $finalcat;
    }

    public function getFirstQuestions($firstResult)
    {
        $questions = Questions::all();



        $firstquestions = [];
        $firstresults = json_decode($firstResult->results);
        foreach ($firstresults as $item) {
            $this->id = $item->question_id;
            $question = $questions->filter(function ($item) {
                return $item->id == $this->id;
            })->first();

            if ($question){
                $firstquestions[$question->id] = ['id' => (int)$item->question_id, 'question' => $question->question, 'image' => $question->image, 'value' => (int)$item->answer];
            }
        }
        return $firstquestions;
    }

    public function getCategories($firstResult)
    {
        $firstquestions = [];
        $firstresults = json_decode($firstResult->results);
        foreach ($firstresults as $item) {
            if (array_key_exists($item->category, $firstquestions)) {
                $firstquestions[$item->category] = ['id' => (int)$item->category, 'value' => (int)$item->answer + $firstquestions[$item->category]['value']];
            } else {
                $firstquestions[$item->category] = ['id' => (int)$item->category, 'value' => (int)$item->answer];
            }
        }

        foreach ($firstquestions as $question) {
            $firstquestions[$question['id']] = ['id' => (int)$question['id'], 'value' => (int)$question['value'], 'questionCount' => Questions::where('categories_id', $question['id'])->count(), 'category' => Categories::find($question['id'])];
        }
        return $firstquestions;
    }

    public function downloadExport(Request $request)
    {
        $result = Results::find($request->result_id);
        $result = json_decode($result->results);
        $filename = "answers.csv";
        $handle = fopen($filename, 'w+');
        fputcsv($handle, array('question', 'answer', 'category'));
        foreach ($result as $row) {
            $question = Questions::find($row->question_id);
            $category = Categories::find($row->category);
            fputcsv($handle, array($question->question, $row->answer, $category->name));
        }
        fclose($handle);
        $headers = array(
            'Content-Type' => 'text/csv',
        );
        return Response::download($filename, 'answers.csv', $headers);
    }

    public function getDates($results)
    {
        $dates = [];
        foreach ($results as $result) {
            array_push($dates, date('d-m-Y', strtotime($result->created_at)));
        }
        return $dates;
    }

    public function getBarData($questions)
    {
        $categories = [];
        $finalcat = [];
        foreach ($questions as $question => $value) {
            foreach ($value as $item) {
                if (array_key_exists($item['id'], $categories)) {
                    array_push($categories[$item['id']]['data'], $item['value']);
                } else {
                    $categories[$item['id']] = ['label' => $item['category'], 'backgroundColor' => $item['color'], 'data' => [$item['value']]];
                }
            }
        }
        foreach ($categories as $category) {
            array_push($finalcat, $category);
        }
        return $finalcat;
    }

    public function json(Request $request)
    {
        $results = Results::where('user_id', $request->user_id)->orderBy('created_at', 'ASC')->get();
        $questions = $this->getAllQuestionsJSON($request->user_id, true);
        return response()->json(['dates' => $this->getDates($results), 'bardata' => $this->getBarData($questions)]);
    }


    public function createPDF(Results $result)
    {
        $data = [];

        $tempdata = json_decode($result->results);
        foreach ($tempdata as $json) {
            $question = Questions::find($json->question_id);
            $data[] = [
                'answer' => (int)$json->answer,
                'question' => $question,
                'category' => $question->categories,
            ];
        }

        $pdf = PDF::loadView('export.raportages.pdf', [
            'data' => $data,
            'scan' => Scan::find($result->scan_id)
        ]);

        $pdf->setPaper('a4', 'landscape');

        return $pdf->stream('pdf_file.pdf');
    }

}
