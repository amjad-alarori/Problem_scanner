<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Scan;
use App\Models\User;
use Illuminate\Http\Request;
use Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use jeremykenedy\LaravelRoles\Models\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::query();

        if($request->get('role') && $request->get('role') != 'all') {
            $users->whereHas('roles', function ($query) use ($request) {
                return $query->where('name', '=', $request->get('role'));
            });
        }
        if ($request->get('verified') && $request->get('verified') != 'all') {
            if($request->get('verified') == 'verified') {
                $users->whereNotNull('email_verified_at');
            } else {
                $users->whereNull('email_verified_at');
            }
        }
        if ($request->get('language') && $request->get('language') != 'all') {
            $users->where('language', $request->get('language'));
        }

        $users = $users->paginate(10);

        $roles = Role::all();
        return view('admin.user.index', compact('users', 'roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->email_verified_at = now();
        $user->password = bcrypt("password");
        $user->save();


        $roleId = \App\Models\Role::where('slug', $request->role)->first()->id;


        DB::table('role_user')->insert([
            "role_id" => $roleId, "user_id" => $user->id
        ]);

        if ($request->role == "user" && $request->link != null) {
            DB::table('consulent_clients')->insert([
                "consulent_id" => $request->link,
                "client_id" => $user->id,
                "verified" => 1
            ]);
        }
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show($id)
    {
        $users = User::with('roles')->get();
        $user = User::with('roles')->where('id', '=', $id)->first();
        $roles = Role::all();
        $linkedUsers = [];
        if ($user->roles[0]->level == 2 || $user->roles[0]->level == 3) {
            $linkedUsersIds = DB::table('consulent_clients')->where('consulent_id', '=', $id)->get();
            foreach ($linkedUsersIds as $linkedUserId) {
                //$linkedUser = DB::table('users')->where('id', '=', $linkedUserId->client_id)->first();
                //array_push($linkedUsers, $linkedUser);
                foreach ($users as $key => $x) {
                    if ($linkedUserId->client_id == $x->id) {
                        array_push($linkedUsers, $x);
                        unset($users[$key]);
                    }
                }
            }
        } else {
            $linkedUsersIds = DB::table('consulent_clients')->where('client_id', '=', $id)->get();
            foreach ($linkedUsersIds as $linkedUserId) {
                //$linkedUser = DB::table('users')->where('id', '=', $linkedUserId->consulent_id)->first();
                //array_push($linkedUsers, $linkedUser);
                foreach ($users as $key => $x) {
                    if ($linkedUserId->consulent_id == $x->id) {
                        array_push($linkedUsers, $x);
                        unset($users[$key]);
                    }
                }
            }
        }

        return view('admin.user.show', compact('users', 'user', 'roles', 'linkedUsers'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        if ($user->id != Auth::id()) {
            if (($user->roles[0]->level == 2 && $request->powerEmployee == "on") || ($user->roles[0]->level == 3 && $request->powerEmployee == null)) {
                if ($user->roles[0]->level == 2) {
                    $roleId = DB::table('roles')->select('id')->where('slug', '=', "poweremployee")->first()->id;
                } else {
                    $roleId = DB::table('roles')->select('id')->where('slug', '=', "employee")->first()->id;
                }
                DB::table('role_user')->where("user_id", "=", $user->id)->update(["role_id" => $roleId]);
            }
            DB::table('users')->where('id', '=', $user->id)->update([
                "name" => $request->name,
                "email" => $request->email,
            ]);
            if ($request->password != "") {
                DB::table('users')->where('id', '=', $user->id)->update([
                    "password" => bcrypt($request->password)
                ]);
            }
//            if($user->email_verified_at == $request->verifyEmail) {
//                if($request->verifyEmail == null) {
//                    DB::table('users')->where('id', '=', $user->id)->update(["email_verified_at" => now()]);
//                }
//                 else {
//                     DB::table('users')->where('id', '=', $user->id)->update(["email_verified_at" => null]);
//                 }
//            }
            return redirect()->back()->with('success', 'changed user');

        }
        return redirect()->back()->withErrors('You can not change yourself');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        User::destroy($user->id);
        return redirect()->back()->with('success', 'gebruiker verwijderd');
    }

    public function trashed()
    {
        $users = User::onlyTrashed()->paginate(15);
        return view('admin.user.trashed', compact('users'));
    }

    public function updateTrashed($id)
    {
        $user = User::withTrashed()->find($id);
        $user->deleted_at = null;
        $user->save();
        return back()->with('success', 'gebruiker teruggezet!');
    }

    public function link(Request $request)
    {
        $request->validate([
            'employeeId' => 'required',
            'clientId' => 'required',
        ]);
        DB::table('consulent_clients')->insert([
            "consulent_id" => $request->employeeId,
            "client_id" => $request->clientId,
            "verified" => 1
        ]);
        return redirect()->back()->with('success', 'linked user');
    }

    public function linkDestroy(User $user, Request $request)
    {
        if ($user->roles[0]->level == 2 || $user->roles[0]->level == 3) {
            DB::table('consulent_clients')->where('consulent_id', '=', $user->id)->where('client_id', '=', $request->otherUser)->delete();
        } else {
            DB::table('consulent_clients')->where('client_id', '=', $user->id)->where('consulent_id', '=', $request->otherUser)->delete();
        }

        return redirect()->back()->with('success', 'link verwijderd');
    }

    public function hardDelete()
    {
        $id = \request('id');

        //v1 van de hard delete doet ook deleten als de user scans heeft
        //DB::table('results')->where('user_id',$id )->delete();
        //DB::table('role_user')->where('user_id' , $id)->delete();
        //DB::table('permission_user')->where('user_id', $id)->delete();
        //DB::table('consulent_clients')->where('consulent_id', $id)->orWhere('client_id', $id)->delete();
        //DB::table('users')->where('id', $id)->delete();
        //return redirect()->back()->with('success','gebruiker verwijderd');

        if (!count(DB::table('results')->where('user_id', $id)->get())) {
            DB::table('role_user')->where('user_id', $id)->delete();
            DB::table('permission_user')->where('user_id', $id)->delete();
            DB::table('consulent_clients')->where('consulent_id', $id)->orWhere('client_id', $id)->delete();
            DB::table('users')->where('id', $id)->delete();
            return redirect()->back()->with('success', 'gebruiker verwijderd');
        } else {
            return redirect()->back()->with('failed', 'gebruiker heeft all tests afgenomen');
        }


    }
}
