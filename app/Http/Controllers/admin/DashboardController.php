<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Results;
use App\Models\Scan;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $results = Results::orderBy('created_at','desc')->take(5)->get();
        return view('admin.dashboard', compact('results'));
    }
}
