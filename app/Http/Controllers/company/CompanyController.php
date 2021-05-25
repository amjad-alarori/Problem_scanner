<?php

namespace App\Http\Controllers\company;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use jeremykenedy\LaravelRoles\Models\Role;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
//    public function index()
//    {
//        $users = DB::table('users')
//            ->join('role_user', 'users.id', '=', 'role_user.user_id')
//            ->join('roles', 'role_user.role_id', '=', 'roles.id')
//            ->join('consulent_clients', 'users.id', '=', 'consulent_clients.client_id')
//            ->select('users.id', 'users.name', 'users.email', 'roles.name as roleName', 'roles.slug', 'roles.level')
//            ->where([['roles.level', '=', '2'], ['consulent_clients.consulent_id', '=', Auth::user()->id], ['users.deleted_at', '=', NULL]])
//            ->orWhere([['roles.level', '=', '3'], ['consulent_clients.consulent_id', '=', Auth::user()->id], ['users.deleted_at', '=', NULL]])
//            ->orderBy('roles.level', 'DESC')->paginate(10);
//
//        $roles = Role::
//        where([['level', '<', '4'],['level', '>', '1']])
//        ->orderBy('level', 'DESC')->get();
//
//        $allUsers = User::with('roles')->get();
//
//        return view('company.index', compact(
//            'users',
//            'roles',
//            'allUsers'
//        ));
//    }
//
//    /**
//     * Display a listing of the resource.
//     *
//     * @return \Illuminate\Http\Response
//     */
//    public function customers()
//    {
//        $users = DB::table('users')
//        ->join('role_user', 'users.id', '=', 'role_user.user_id')
//        ->join('roles', 'role_user.role_id', '=', 'roles.id')
//        ->select('users.id', 'users.name', 'users.email', 'roles.name as roleName', 'roles.slug', 'roles.level')
//        ->where([['roles.level', '=', '1'], ['users.deleted_at', '=', NULL]])
//        ->orderBy('roles.level', 'DESC')->paginate(10);
//
//        $roles = Role::where('level', '=', '1')->get();
//
//        $allUsers = User::with('roles')->get();
//
//        return view('company.customers', compact(
//            'users',
//            'roles',
//            'allUsers'
//        ));
//    }
//
//    /**
//     * Show the form for creating a new resource.
//     *
//     * @return \Illuminate\Http\Response
//     */
//    public function create()
//    {
//        //
//    }
//
//    /**
//     * Store a newly created resource in storage.
//     *
//     * @param  \Illuminate\Http\Request  $request
//     * @return \Illuminate\Http\Response
//     */
//    public function store(Request $request)
//    {
//        $user = new User();
//        $user->name = $request->name;
//        $user->email = $request->email;
//        $user->email_verified_at = now();
//        $user->password = bcrypt("password");
//        $user->save();
//
//        $roleExplode = explode('|', $request->role);
//        $roleId = \App\Models\Role::where('slug', $roleExplode[0])->first()->id;
//
//        DB::table('role_user')->insert([
//            "role_id" => $roleId, "user_id" => $user->id
//        ]);
//
//        if ($roleExplode[1] == 1 && $request->link != null) {
//            DB::table('consulent_clients')->insert([
//                "consulent_id" => $request->link,
//                "client_id" => $user->id,
//                "verified" => 0
//            ]);
//        }
//
//        if ($roleExplode[1] == 2 || $roleExplode[1] == 3) {
//            DB::table('consulent_clients')->insert([
//                "consulent_id" => Auth::user()->id,
//                "client_id" => $user->id,
//                "verified" => 0
//            ]);
//        }
//        return back();
//    }
//
//    /**
//     * Display the specified resource.
//     *
//     * @param  int  $id
//     * @return \Illuminate\Http\Response
//     */
//    public function show($id)
//    {
//        $users = User::with('roles')->get();
//        $user = User::with('roles')->where('id', '=', $id)->first();
//        $roles = Role::all();
//        $linkedUsers = [];
//        if ($user->roles[0]->level > 3) {
//            return back();
//        }
//        if ($user->roles[0]->level == 2 || $user->roles[0]->level == 3) {
//            $linkedUsersIds = DB::table('consulent_clients')->where('consulent_id', '=', $id)->get();
//            foreach ($linkedUsersIds as $linkedUserId) {
//                //$linkedUser = DB::table('users')->where('id', '=', $linkedUserId->client_id)->first();
//                //array_push($linkedUsers, $linkedUser);
//                foreach ($users as $key => $x) {
//                    if ($linkedUserId->client_id == $x->id) {
//                        array_push($linkedUsers, $x);
//                        unset($users[$key]);
//                    }
//                }
//            }
//        } else {
//            $linkedUsersIds = DB::table('consulent_clients')->where('client_id', '=', $id)->get();
//            foreach ($linkedUsersIds as $linkedUserId) {
//                //$linkedUser = DB::table('users')->where('id', '=', $linkedUserId->consulent_id)->first();
//                //array_push($linkedUsers, $linkedUser);
//                foreach ($users as $key => $x) {
//                    if ($linkedUserId->consulent_id == $x->id) {
//                        array_push($linkedUsers, $x);
//                        unset($users[$key]);
//                    }
//                }
//            }
//        }
//        return view('company.show', compact('users', 'user', 'roles', 'linkedUsers'));
//    }
//
//    /**
//     * Show the form for editing the specified resource.
//     *
//     * @param  int  $id
//     * @return \Illuminate\Http\Response
//     */
//    public function edit($id)
//    {
//        //
//    }
//
//    /**
//     * Update the specified resource in storage.
//     *
//     * @param  \Illuminate\Http\Request  $request
//     * @param  User $user
//     * @return \Illuminate\Http\Response
//     */
//    public function update(Request $request, User $user)
//    {
//        // I got 1 error, I can't find out: Undefined offset: 0 or [0]
//        if ($user->id != Auth::id()) {
//
//            //die(var_dump($request->role));
//            if ($request->role != null) {
//                $roleId = DB::table('roles')->select('id')->where('slug', '=', $request->role)->first()->id;
//                DB::table('role_user')->where("user_id", "=", $request->id)->update(["role_id" => $roleId]);
//            }
//
//            DB::table('users')->where('id', '=', $request->id)->update([
//                "name" => $request->name,
//                "email" => $request->email,
//            ]);
//
//            if ($request->password != "") {
//                DB::table('users')->where('id', '=', $request->id)->update([
//                    "password" => bcrypt($request->password)
//                ]);
//            }
//            //            if($user->email_verified_at == $request->verifyEmail) {
//            //                if($request->verifyEmail == null) {
//            //                    DB::table('users')->where('id', '=', $user->id)->update(["email_verified_at" => now()]);
//            //                }
//            //                 else {
//            //                     DB::table('users')->where('id', '=', $user->id)->update(["email_verified_at" => null]);
//            //                 }
//            //            }
//            return redirect()->back()->with('success', 'changed user');
//        }
//        return redirect()->back()->withErrors('You can not change yourself');
//    }
//
//    public function link(Request $request)
//    {
//        $request->validate([
//            'employeeId' => 'required',
//            'clientId' => 'required',
//        ]);
//        DB::table('consulent_clients')->insert([
//            "consulent_id" => $request->employeeId,
//            "client_id" => $request->clientId,
//            "verified" => 1
//        ]);
//        return redirect()->back()->with('success', 'linked user');
//    }
//
//    public function linkDestroy(User $user, Request $request)
//    {
//        if ($user->roles[0]->level == 2 || $user->roles[0]->level == 3) {
//            DB::table('consulent_clients')->where('consulent_id', '=', $user->id)->where('client_id', '=', $request->otherUser)->delete();
//        } else {
//            DB::table('consulent_clients')->where('client_id', '=', $user->id)->where('consulent_id', '=', $request->otherUser)->delete();
//        }
//
//        return redirect()->back()->with('success', 'link verwijderd');
//    }
//
//    /**
//     * Remove the specified resource from storage.
//     *
//     * @param  int  $id
//     * @return \Illuminate\Http\Response
//     */
//    public function destroy($id)
//    {
//        //
//    }
}
