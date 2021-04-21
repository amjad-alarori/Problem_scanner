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

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::with('roles')->paginate(10);
        $roles = Role::all();
        $companies = User::with('roles')->paginate(10);
        //$companyRole = DB::table('roles')->where("slug", "=", "company")->first();
        return view('admin.company.index',compact('users','roles','companies'));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $user = new User();
        $user->name= $request->name;
        $user->email = $request->email;
        $user->email_verified_at = now();
        $user->password = bcrypt("password");
        $user->save();

        DB::table('role_user')->insert([
            "role_id"=>$request->role, "user_id"=>$user->id
        ]);
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id)->get();
        return view('admin.company.show',compact('user'));
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
     * @param \Illuminate\Http\Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        if($user->id != Auth::id()){
            $user->roles()->sync([$request->input('role')]);
//            $user->roles()->attach($request->role);

            return redirect()->back()->with('success','changed user');
        }
        return redirect()->back()->withErrors('You can not change yourself');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        User::destroy($user->id);
        return redirect()->back()->with('success','gebruiker verwijderd');
    }
    public function trashed(){
        $users = User::onlyTrashed()->paginate(15);
        return view('admin.company.trashed',compact('users'));
    }
    public function updateTrashed($id){
        $user=User::withTrashed()->find($id);
        $user->deleted_at = null;
        $user->save();
        return back()->with('success','gebruiker teruggezet!');
    }
}
