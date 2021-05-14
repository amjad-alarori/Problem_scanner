<?php

namespace App\Http\Controllers;

use App\Models\Results;
use App\Models\Scan;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;

class PDFController extends Controller
{
    public function createPDFsingleScan(Results $result, Request $request)
    {
        $data = json_decode($result->results, true);

        $pdf = PDF::loadView('export.raportages.singleScan', [
            'data' => array_chunk(array_chunk($data, 4, true), 2, true),
            'scan' => Scan::find($result->scan_id),
            'metadata' => [
                'created_at' => $result->created_at,
                'result_made_by' => $result->name,
                'result_made_for' => $result->user->name,
            ]
        ]);

        $pdf->setPaper('a4', 'landscape');

        if ($request->get('a')) {
            return view('export.raportages.singleScan', [
                'data' => array_chunk(array_chunk($data, 4, true), 2, true),
                'scan' => Scan::find($result->scan_id),
                'metadata' => [
                    'created_at' => $result->created_at,
                    'result_made_by' => $result->name,
                    'result_made_for' => $result->user->name,
                ]
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


        $pdf = PDF::loadView('export.raportages.timespan', [
            'dataArray' => $dataAArray,
            'scan' => $scan
        ]);

        $pdf->setPaper('a4', 'landscape');
//        ?a=true
        if ($request->get('a')) {
            return view('export.raportages.timespan', [
                'dataArray' => $dataAArray,
                'scan' => $scan
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

        $test = [];
        foreach ($results as $resultRow) {
            $result = json_decode($resultRow->results);
            $tempData = [];
            foreach ($result as $json) {
                $tempData[$json->category][] = $json->answer;
            }
            foreach ($tempData as $category => $answers) {
                $test[$category][$resultRow->id] = (int) round(array_sum($answers) / count($answers));
            }
        }
        dd($test);


//        foreach ($data as $dataItem){
//
//            $dataSummed = array_sum($dataItem);
//
//        }

        dd($dataSummed);

//        $chunkSize = 2;
//        $index = 0;
//        $curindex = 0;
//        $dataArray = [];
//        foreach ($data as $question_id => $dataItem) {
//            $dataArray[$index][$question_id][] = $dataItem;
//            $curindex++;
//
//            if ($curindex === $chunkSize) {
//                $index++;
//                $curindex = 0;
//            }
//        }
//
//        $dataAArray = [];
//        $indexx = 0;
//        $curindexx = 0;
//        $chunkSizee = 3;
//        foreach ($dataArray as $item) {
//            $dataAArray[$indexx][] = $item;
//            $curindexx++;
//            if ($curindexx == $chunkSizee) {
//                $indexx++;
//                $curindexx = 0;
//            }
//        }


        $pdf = PDF::loadView('export.raportages.timespanByCategory', [
            'dataArray' => $dataAArray,
            'scan' => $scan
        ]);

        $pdf->setPaper('a4', 'landscape');
//        ?a=true
        if ($request->get('a')) {
            return view('export.raportages.timespanByCategory', [
                'dataArray' => $dataAArray,
                'scan' => $scan
            ]);
        }
        return $pdf->stream('pdf_file_timespan_bycategory.pdf');
    }

}
