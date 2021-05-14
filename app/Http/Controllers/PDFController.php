<?php

namespace App\Http\Controllers;

use App\Models\Results;
use App\Models\Scan;
use Barryvdh\DomPDF\Facade as PDF;
use Dompdf\Options;
use Illuminate\Http\Request;

class PDFController extends Controller
{
    public function createPDFsingleScan(Results $result, Request $request)
    {
        $data = json_decode($result->results, true);
        $date = date(" j-m-Y");
        $pdf = PDF::loadView('export.raportages.singleScan', [
            'data' => array_chunk($data, 4, true),
            'scan' => Scan::find($result->scan_id),
            'date' => $date
            ]);

        $pdf->setPaper('a4', 'landscape');

        if ($request->get('a')) {
            return view('export.raportages.singleScan', [
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

        $dataByQuestionsDates = [];
        foreach ($results as $result) {
            $jsonResult = json_decode($result->results);
            $dataByQuestionsDates[] = $result->created_at;
             foreach ($jsonResult as $json) {
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
        $chunkSizee = 2;
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
            'date' => $date,
            'dataByQuestionsDates' =>$dataByQuestionsDates
        ]);

        $pdf->setPaper('a4', 'landscape');
//        ?a=true
        if ($request->get('a')) {
            return view('export.raportages.timespan', [
                'dataArray' => $dataAArray,
                'scan' => $scan,
                'date' => $date,
                'dataByQuestionsDates'=>$dataByQuestionsDates
            ]);
        }
        return $pdf->stream('pdf_file_timespan_question.pdf');


// scan ophalen en children benaderen via eloquent relatie
    }

    public function createPDFbyCategory(Request $request, Results $result)
    {


        $scan = Scan::find($result->scan_id);
        $results = Results::where([
            ['scan_id', '=', $scan->id],
            ['user_id', '=', $result->user->id]
        ])->get();

        $dataByCategory = [];
        $dataByCategoryDates=[];
        foreach ($results as $resultRow) {
            $result = json_decode($resultRow->results);
            $dataByCategoryDates[] = $resultRow->created_at;
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
            'date'=> $date,
            'dataByCategoryDates'=>$dataByCategoryDates
        ]);

        $pdf->setPaper('a4', 'landscape');
//        ?a=true
        if ($request->get('a')) {
            return view('export.raportages.timespanByCategory', [
                'chunkedArrayByCategory' => $chunkedArrayByCategory,
                'scan' => $scan,
                'date'=> $date,
                'dataByCategoryDates'=>$dataByCategoryDates
            ]);
        }
        return $pdf->stream('pdf_file_timespan_bycategory.pdf');
    }

}
