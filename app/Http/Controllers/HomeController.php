<?php

namespace App\Http\Controllers;

use App\Mail\Mails\VerifyEmail;
use App\Models\Results;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $scansMade = Results::where('user_id', '=', Auth::id())->count();

        return view('home',compact('scansMade'));
    }
}
