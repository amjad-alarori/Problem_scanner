<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\ConsulentClients;
use App\Models\Questions;
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

    function dataVragen(Scan $scan)
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
        foreach($Consultent_clients as $consultent=> $client){
            $this->_client_id=$client->client_id;
            $user = $users->first(function($item) {
                return $item->id == $this->_client_id;
            });
            if(!empty($clients[$client->verified])){
                array_push($clients[$client->verified],$user);
            }else{
                $clients[$client->verified]=[$user];
            }
        }
        $users = $clients;
        $allData = array("catergories"=>$categories,"scan"=>$scan,"counter"=>$counter,"users"=>$users);
        return $allData;
    }

    public function show(Scan $scan)
    {
        session_start();
        if (!isset($_SESSION['radiobutton'])) {
            $_SESSION['radiobutton'] = 'triple';
        }
        if (isset($_POST['radiobutton'])) {
            $_SESSION['radiobutton'] = $_POST['radiobutton'];
            $number = 0;
            while (true) {
                $number++;
                if (isset($_SESSION['question' . $number]) && !isset($_POST['question' . $number])) {
                    // if there is a filled in answer but no new answer.
                    continue;
                } elseif (isset($_POST['question' . $number])) {
                    // if there is no filled in answer but there is a updated answer.
                    $_SESSION['question' . $number] = $_POST['question' . $number];
                } else {
                    // there are no answers left.
                    break;
                }
            }
        }

        if ($_SESSION['radiobutton'] == 'single') {
            $catoId = [];
            $datavragen = $this->dataVragen($scan);
            $categories = $datavragen['catergories'];
            foreach ($categories as $category) {
                array_push($catoId, $category->id);
            }
            $questions = Questions::wherein('categories_id', $catoId)->paginate(1);
            foreach ($questions as $question) {

            };
            $scan = $datavragen['scan'];
            $counter = $datavragen['counter'];
            $users = $datavragen['users'];
            return view('scan.tinderweergave.show', compact('categories', 'scan', 'counter', 'users', 'questions'));
        } elseif ($_SESSION['radiobutton'] == 'triple') {
            $datavragen = $this->dataVragen($scan);
            $categories = $datavragen['catergories'];
            $scan = $datavragen['scan'];
            $counter = $datavragen['counter'];
            $users = $datavragen['users'];
            return view('scan.show', compact('categories', 'scan', 'counter', 'users'));
        }
    }

    public function switchviews(Scan $scan)
    {

        $switchview = $_SESSION['radiobutton'];

        if ($switchview == 'single') {
            $catoId = [];
            $datavragen = $this->dataVragen($scan);
            $categories = $datavragen['catergories'];
            foreach ($categories as $category) {
                array_push($catoId, $category->id);
            }
            $questions = Questions::wherein('categories_id', $catoId)->paginate(1);
            $scan = $datavragen['scan'];
            $counter = $datavragen['counter'];
            $users = $datavragen['users'];
            return view('scan.tinderweergave.show', compact('categories', 'scan', 'counter', 'users', 'questions'));
        } elseif ($switchview == 'triple') {
            $datavragen = $this->dataVragen($scan);
            $categories = $datavragen['catergories'];
            $scan = $datavragen['scan'];
            $counter = $datavragen['counter'];
            $users = $datavragen['users'];
            return view('scan.show', compact('categories', 'scan', 'counter', 'users'));
        }
    }

}
