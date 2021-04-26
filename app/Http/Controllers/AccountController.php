<?php

namespace App\Http\Controllers;

use App\Helpers\LanguageHelper;
use App\Models\ConsulentClients;
use App\Models\Results;
use App\Models\User;
use Auth;
use Aws\Result;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $result = Results::where('user_id', $user->id)->first();
        return view('account.index', compact('user', 'result'));
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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

    public function update(Request $request, $id)
    {
        $request->validate([
            'language' => 'required|string|max:2|min:2'
        ]);
        $user = Auth()->user();
        $language = $request->post('language');
        if (in_array($language, LanguageHelper::$allLanguageIsos)) {
            $user->update([
                'language' => $language
            ]);
        }
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function DetachConsultant(User $user)
    {
        // Todo:: Improve with detach
        ConsulentClients::where([
            ['client_id', '=', Auth()->user()->id],
            ['consulent_id', '=', $user->id],
        ])->firstOrFail()->delete();
        return back();
    }

}
