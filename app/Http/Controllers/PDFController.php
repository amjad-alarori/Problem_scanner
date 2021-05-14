<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Questions;
use App\Models\Results;
use App\Models\Scan;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PDFController extends Controller
{
    public function createPDFsingleScan(Results $result, Request $request)
    {
        $data = [];

        $tempdata = json_decode($result->results);
        $chunkSize = 4;
        $index = 0;
        $curindex = 0;
        foreach ($tempdata as $json) {
            $question = Questions::find($json->question_id);
            $data[$index][] = [
                'answer' => (int)$json->answer,
                'question' => $question,
                'category' => $question->categories,
            ];
            $curindex++;
            if ($curindex === $chunkSize) {
                $index++;
                $curindex = 0;
            }
        }
        $date = date(" j-m-Y");

        $pdf = PDF::loadView('export.raportages.pdf', [
            'data' => $data,
            'scan' => Scan::find($result->scan_id),
            'date' => $date
        ]);

        $pdf->setPaper('a4', 'landscape');
//        ?a=true
        if ($request->get('a')) {
            return view('export.raportages.pdf', [
                'data' => $data,
                'scan' => Scan::find($result->scan_id),
                'date' => $date
            ]);
        }
        return $pdf->stream('pdf_file.pdf');
    }

    public function createPDFbyQuestion(Request $request, Results $result)
    {
        $data = [];
        $scan = Scan::find($result->scan_id);
        $results = Results::where([
            ['scan_id', '=', $scan->id],
            ['user_id', '=', $result->user->id]
        ])->get();

        foreach ($results as $result) {
            $result = json_decode($result->results);
            foreach ($result as $json) {
                $data[$json->question_id][] = $json->answer;
            }
        }

        $chunkSize = 2;
        $index = 0;
        $curindex = 0;
        $dataArray = [];
        foreach ($data as $question_id => $dataItem) {
            $dataArray[$index][$question_id][] = $dataItem;
            $curindex++;

            if ($curindex === $chunkSize) {
                $index++;
                $curindex = 0;
            }
        }

        $dataAArray = [];
        $indexx = 0;
        $curindexx = 0;
        $chunkSizee = 3;
        foreach ($dataArray as $item) {
            $dataAArray[$indexx][] = $item;
            $curindexx++;
            if ($curindexx == $chunkSizee) {
                $indexx++;
                $curindexx = 0;
            }
        }

        $date = date(" j-m-Y");

        $pdf = PDF::loadView('export.raportages.timespan', [
            'dataArray' => $dataAArray,
            'scan' => $scan,
            'date' => $date
        ]);

        $pdf->setPaper('a4', 'landscape');
//        ?a=true
        if ($request->get('a')) {
            return view('export.raportages.timespan', [
                'dataArray' => $dataAArray,
                'scan' => $scan,
                'date' => $date
            ]);
        }
        return $pdf->stream('pdf_file_timespan_question.pdf');


// scan ophalen en children benaderen via eloquent relatie
    }

    public function createPDFbyCategory(Request $request, Results $result)
    {

        $data = [];
        $scan = Scan::find($result->scan_id);
        $results = Results::where([
            ['scan_id', '=', $scan->id],
            ['user_id', '=', $result->user->id]
        ])->get();

        $dataByCategory = [];
        foreach ($results as $resultRow) {
            $result = json_decode($resultRow->results);
            $tempData = [];
            foreach ($result as $json) {
                $tempData[$json->category][] = $json->answer;
            }
            foreach ($tempData as $category => $answers) {
                $dataByCategory[$category][$resultRow->id] = (int)round(array_sum($answers) / count($answers));
            }
        }

        $chunkedArrayByCategory = array_chunk(
            array_chunk($dataByCategory, 2, true),
            2,
            true
        );

        $date = date(" j-m-Y");

        $pdf = PDF::loadView('export.raportages.timespanByCategory', [
            'chunkedArrayByCategory' => $chunkedArrayByCategory,
            'scan' => $scan,
            'date'=> $date
        ]);

        $pdf->setPaper('a4', 'landscape');
//        ?a=true
        if ($request->get('a')) {
            return view('export.raportages.timespanByCategory', [
                'chunkedArrayByCategory' => $chunkedArrayByCategory,
                'scan' => $scan,
                'date'=> $date
            ]);
        }
        return $pdf->stream('pdf_file_timespan_bycategory.pdf');
    }

}
