<?php

namespace App\Http\Controllers;

use App\Mail\Mails\NewClient;
use App\Mail\Mails\VerifyEmail as CustomVerifyEmail;
use App\Models\ConsulentClients;
use App\Models\Results;
use App\Models\Role;
use App\Models\User;
use Aws\Result;
use http\Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ConsulentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $clients = ConsulentClients::join('users', 'users.id', '=', 'client_id')->where('consulent_id',Auth::id())->get();

        $groupedClients = [
            "unverified" => [],
            "verified" => [],
            "trashed" => [],
        ];

        foreach($clients as $client) {
            $status = "unverified";

            if ($client->verified === 1) {
                $status = "verified";
            }

            if ($client->deleted_at) {
                $status = "trashed";
            }

            array_push($groupedClients[$status], $client);
        }

        return view('consulent.index', ["clients" => $groupedClients]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        return view('consulent.userCreate',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->email && User::where('email', '=', $request->email)->exists()) {
            return back()->withErrors('client met deze e-mail bestaat al');
        }

        $user = new User();
        $user->name= $request->name;
        $user->email = $request->email ?? "";

        $validator = Validator::make(['email' => $user->email],[
            'email' => 'required|email'
        ]);

        $password = "password";

        if($validator->passes()){
            $password = str_random();
        }

        if ($request->email) {
            $user->email_verified_at = now();
        }

        $user->password = bcrypt($password);
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

        if($validator->passes()){
            Mail::to($user->email)->send(new NewClient($user, $password));
        }

        return redirect('consulent');
    }


    public function updatePassword(Request $request) {
        $user = User::find($request->userId);

        $user->password =  bcrypt($request->newPassword);

        $user->save();

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

        $validator = Validator::make(['email' => $user->email],[
            'email' => 'required|email'
        ]);

        $showPasswordUpdate = false;
        if (!$validator->passes()) {
            $showPasswordUpdate = true;
        }

        return view('consulent.show',compact('user','results', 'showPasswordUpdate'));
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
        $client = User::withTrashed()->find($request->client);
        $client->restore();
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
        // if (account with $email doesnt exist) {
        //     send email to invite client to make account
        // }
        // else {
        //     if (account is linked to current consulent) {
        //         return back()->withErrors('Je hoort al bij deze consulent');
        //     }
        //     else {
        //         link client to consulent
        //         return back()->with('success','je wordt toegevoegd aan je consulent zodra deze het verzoek heeft geaccepteerd');
        //     }
        // }

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
