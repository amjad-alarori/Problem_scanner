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

use Symfony\Component\Console\Question\Question;

class ScanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $scans = Scan::all();
        return view('scan.index', compact('scans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $scan = new Scan();
        $scan->name = $request->name;
        $scan->save();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Scan $scan
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
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
        return view('scan.show', compact('categories', 'scan', 'counter', 'users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Scan $scan
     * @return \Illuminate\Http\Response
     */
    public function edit(Scan $scan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Scan $scan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Scan $scan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Scan $scan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Scan $scan)
    {
        //
    }
}
