<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\ConsulentClients;
use App\Models\Questions;
use App\Models\Results;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Response;

class ExportController extends Controller
{

    public function show($result)
    {
        $result = Results::findOrFail($result);
        $questions = collect();
        foreach (json_decode($result->results) as $item) {
            $question = Questions::find($item->question_id);
            if ($question) {
                $question->value = $item->answer;
                $questions->add($question);
            } else {
                $questions->add(Questions::make([
                    'question' => 'Question has been removed',
                    'categories_id' => 0,
                ]));
            }
        }
        $chart1Labels = [];
        $results = Results::where([
            ['user_id', '=', $result->user_id],
            ['scan_id', '=', $result->scan_id],
        ])->orderBy('created_at', 'ASC')->get();

        foreach ($results as $result) {
            $chart1Labels[] = date('d-m-Y', strtotime($result->created_at));
        }

        return view("export.index", compact('result', 'questions', 'chart1Labels'));
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
            $firstquestions[$question->id] = ['id' => (int)$item->question_id, 'question' => $question->question, 'image' => $question->image, 'value' => (int)$item->answer];
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
        fputcsv($handle, ['question', 'answer', 'category']);
        foreach ($result as $row) {
            $question = Questions::find($row->question_id);
            $category = Categories::find($row->category);
            fputcsv($handle, [$question->question, $row->answer, $category->name]);
        }
        fclose($handle);
        $headers = [
            'Content-Type' => 'text/csv',
        ];
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

}
