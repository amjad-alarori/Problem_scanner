<?php




namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Categories;
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
        $scans = Scan::paginate(15);
        return view('admin.scan.index', compact('scans'));
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
        $users = Results::where('user_id', Auth::id())->pluck('name')->unique();;
        $categories = Scan::find($scan->id)->categories;
        if (count($categories) < 0) {
            return redirect()->route('categories.index');
        }
        foreach ($categories as $category) {
            $category->questions = Categories::find($category->id)->questions;
        }
        $counter = 1;
        return view('admin.scan.show', compact('categories', 'scan', 'counter', 'users'));
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Scan $scan)
    {
        $scan->delete();
        return back()->with('success','scan verwijderd');
    }

    public function trashed(){
        $scans = Scan::onlyTrashed()->paginate(15);
        return view('admin.scan.trashed',compact('scans'));
    }
    public function updateTrashed($id){
        $scan=Scan::withTrashed()->find($id);
            $scan->deleted_at = null;
            $scan->save();
        return back()->with('success','scan teruggezet!');
    }
}
