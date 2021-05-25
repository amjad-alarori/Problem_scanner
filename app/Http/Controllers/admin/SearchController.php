<?php

namespace App\Http\Controllers\admin;

use App\Models\Categories;
use App\Models\Questions;
use App\Models\Results;
use App\Models\Scan;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController
{

    public function autoComplete(Request $request)
    {
        $data = [];
        $query = strtolower($request->get('q'));
        User::search($query)->take(3)->get()->each(function ($item) use (&$data) {
            $data[] = ['text' => $item->name . ' - ' . $item->email, 'url' => route('user.show', ['user' => $item->id])];
        });
        Results::search($query)->take(3)->get()->each(function ($item) use (&$data) {
            $data[] = ['text' => $item->name, 'url' => route('export.show', ['export' => $item->id])];
        });
        Categories::search($query)->take(3)->get()->each(function ($item) use (&$data) {
            $data[] = ['text' => $item->name, 'url' => route('categories.edit', ['category' => $item->id])];
        });
        Questions::search($query)->take(3)->get()->each(function ($item) use (&$data) {
            $data[] = ['text' => $item->question, 'url' => route('questions.edit', ['question' => $item->id])];
        });
        Scan::search($query)->take(3)->get()->each(function ($item) use (&$data) {
            $data[] = ['text' => $item->name, 'url' => route('scan.show', ['scan' => $item->id])];
        });
        return response()->json($data);
    }

    public function searchFull(Request $request)
    {
        $query = strtolower($request->get('q'));
        $users = User::search($query)->get()->each(function ($item) {
            $item->route = route('user.show', ['user' => $item->id]);
        });
        $results = Results::search($query)->get()->each(function ($item) {
            $item->route = route('export.show', ['export' => $item->id]);
        });
        $categories = Categories::search($query)->get()->each(function ($item) {
            $item->route = route('categories.edit', ['category' => $item->id]);
        });
        $questions = Questions::search($query)->get()->each(function ($item) {
            $item->route = route('questions.edit', ['question' => $item->id]);
        });
        $scans = Scan::search($query)->get()->each(function ($item) {
            $item->route = route('scan.show', ['scan' => $item->id]);
        });
        return view('admin.search.index', compact('users', 'results', 'categories', 'questions', 'scans'));
    }

}
