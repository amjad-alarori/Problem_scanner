<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\ConsulentClients;
use App\Models\Results;
use App\Models\Scan;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class ScanController extends Controller
{

    public function index()
    {
        $scans = Scan::all();
        return view('scan.index', compact('scans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required'
        ]);
        $scan = Scan::create($validated);
        $scan->AddOrUpdateTranslations($request->input('language'));
        return redirect()->back();
    }

    public function show(Scan $scan)
    {
        $users = Results::where('user_id', Auth::id())->pluck('name')->unique();
        $categories = Scan::find($scan->id)->categories;
        if (count($categories) < 0) {
            return redirect()->route('categories.index');
        }
        foreach ($categories as $category) {
            $category->questions = Categories::find($category->id)->questions;
        }
        $counter = 1;
        $Consultent_clients = ConsulentClients::where('consulent_id', \Illuminate\Support\Facades\Auth::id())->get();
        $users = User::all();
        $clients = [];
        foreach ($Consultent_clients as $consultent => $client) {
            $this->_client_id = $client->client_id;
            $user = $users->first(function ($item) {
                return $item->id == $this->_client_id;
            });
            if (!empty($clients[$client->verified])) {
                array_push($clients[$client->verified], $user);
            } else {
                $clients[$client->verified] = [$user];
            }
        }
        $users = $clients;
        return view('scan.show', compact('categories', 'scan', 'counter', 'users'));
    }

}
