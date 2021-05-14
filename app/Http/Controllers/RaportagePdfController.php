<?php

namespace App\Http\Controllers;

use App\Models\Results;
use App\Models\Scan;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;

class RaportagePdfController extends Controller
{

    public function export(Request $request, Results $result)
    {
        switch ($request->post('exportType')) {
            case 'scan':
            {
                return $this->ScanPdf($result);
            }
            case 't_questions':
            {
                return $this->QuestionsPdf($result, $request->post('timespan_start'), $request->post('timespan_end'));
            }
            case 't_Category':
            {
                return $this->CategoriesPdf($result, $request->post('timespan_start'), $request->post('timespan_end'));
            }
        }
        return redirect('/');
    }

    private function ScanPdf(Results $result)
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

        return $pdf->download('scan_' . date('Y-m-d_H:i:s') . '.pdf');
    }

    private function QuestionsPdf(Results $result, $timespan_start, $timespan_end)
    {
        $data = [];
        $scan = Scan::find($result->scan_id);
        $results = Results::where([
            ['scan_id', '=', $scan->id],
            ['user_id', '=', $result->user->id]
        ])->where('created_at', '<=', $timespan_start)
        ->where('created_at', '>=', $timespan_end)->get();

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

        return $pdf->download('questions_' . date('Y-m-d_H:i:s') . '.pdf');
    }

    private function CategoriesPdf(Results $result, $timespan_start, $timespan_end)
    {

        $scan = Scan::find($result->scan_id);
        $results = Results::where([
            ['scan_id', '=', $scan->id],
            ['user_id', '=', $result->user->id]
        ])->where('created_at', '<=', $timespan_start)
            ->where('created_at', '>=', $timespan_end)->get();

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

        return $pdf->download('categories_' . date('Y-m-d_H:i:s') . '.pdf');
    }

}
