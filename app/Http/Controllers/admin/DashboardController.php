<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use App\Models\Questions;
use App\Models\Results;
use App\Models\Scan;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Searchable\Search;
class DashboardController extends Controller
{
    public function index(){
        $results = Results::all()->count();
        $scans= Scan::all()->count();
//        $admins = User::where(isAdmin())->count();
        $admins = 0;
        $users= User::all()->count();
        return view('admin.dashboard',compact('results','scans','admins','users'));
    }

    public function search(Request $request)
    {
        $searchResults = (new Search())
            ->registerModel(Scan::class, 'name')
            ->registerModel(Results::class, 'name')
            ->registerModel(Categories::class, 'name')
            ->registerModel(Questions::class, 'question')
            ->registerModel(User::class, 'name','email')
            ->perform($request->input('query'));
        return view('admin.search.index', compact('searchResults'));
    }
}
