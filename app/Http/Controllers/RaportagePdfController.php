<?php

namespace App\Http\Controllers;

use App\Models\Results;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;

class RaportagePdfController extends Controller
{

    public function createPDFsingleScan(Request $request, Results $result)
    {
        $pdf = PDF::loadView('export.raportages.timespan');
//        0, 0, 595.28, 841.89
//        841.89
        $pdf->setPaper('a4', 'landscape');
        if ($request->get('a')) {
            return view('export.raportages.timespan');
        }
        return $pdf->stream();
    }

    public function createPDFbyCategory()
    {

    }

}
