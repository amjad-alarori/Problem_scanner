<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Questions;
use App\Models\Results;
use App\Models\Scan;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;

class PDFController extends Controller
{
    public function createPDFsingleScan(Results $result)
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

//    public function createPDFbyQuestion()
//    {
//        $data = [];
//
//        $tempdata = json_decode($result->results);
//        foreach ($tempdata as $json) {
//            $categories = Categories::where('scan_id', '=', '')
//
//        }

// scan ophalen en children benaderen via eloquent relatie
//    }

    public function createPDFbyCategory()
    {

    }
}
