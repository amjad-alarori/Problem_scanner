<?php

namespace App\Http\Controllers;

use App\Models\ConsulentClients;
use App\Models\Results;
use App\Models\User;
use Aws\Result;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ConsulentController extends Controller
{
    private $_client_id;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {

        $Consultent_clients = ConsulentClients::where('consulent_id',Auth::id())->get();
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
        return view('consulent.index',compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('consulent\userCreate',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (User::where('email', '=', $request->email)->exists()) {
            return back()->withErrors('client met deze e-mail bestaat al');
        }

        $random_password = str_random();

        $user = new User();
        $user->name= $request->name;
        $user->email = $request->email;
        $user->email_verified_at = now();
        $user->password = bcrypt($random_password);
        $user->save();

        $roleId = DB::table('roles')->select('id')->where('slug', '=', "user")->first()->id;

        DB::table('role_user')->insert([
            "role_id"=>$roleId, "user_id"=>$user->id
        ]);

        DB::table('consulent_clients')->insert([
            "consulent_id" => Auth::user()->id,
            "client_id" => $user->id,
            "verified" => 1
        ]);

        Mail::send('emails.newClientPassword', ['name' => $user->name, 'password' => $random_password], function ($m) use ($user) {
            $m->from('noreply@orangeeyes.com', 'Orange Eyes');

            $m->to($user->email, $user->name)->subject('Orange Eyes account created');
        });

        return redirect('consulent');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
      $results = Results::where('user_id',$user->id)->first();
      return view('consulent.show',compact('user','results'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        if (!$request->client) return back();

        DB::table('users')->where('id', '=', $request->client)->delete();

        return back();
    }


    public function accept(Request $request){

//        dd($request);
       $client =User::find($request->client);
//       dd($client);
        $client = ConsulentClients::where('client_id',$client->id)->where('consulent_id',Auth::id())->first();

        $client->verified =1;
        $client->save();
        return back();
     } public function remove(Request $request){

       $client =User::find($request->client);
        $client = ConsulentClients::where('client_id',$client->id)->where('consulent_id',Auth::id())->first();

        $client->verified =2;
        $client->save();
        return back();
     }
     public function add(Request $request){
        try{
            $consulent = User::where('email',$request->consulent)->with('roles')->first();
            if($consulent->roles[0]->level == 2){
                $active = ConsulentClients::where('consulent_id',$consulent->id)->where('client_id',Auth::id())->first();
                if(empty($active) == true){
                    $consulentClient = new ConsulentClients();
                    $consulentClient->consulent_id=$consulent->id;
                    $consulentClient->client_id=Auth::id();
                    $consulentClient->verified=0;
                    $consulentClient->save();
                    return back()->with('success','je wordt toegevoegd aan je consulent zodra deze het verzoek heeft geaccepteerd');
                }
                return back()->withErrors('Je hoort al bij deze consulent');
            }else{
                return back()->withErrors($request->consulent.' is geen consulent');
            }
        }catch (\ErrorException $e){
            return back()->withErrors('consulent bestaat niet');
        }

     }

}
