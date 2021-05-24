<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Languages;
use App\Models\Translations;
use Dotenv\Exception\ValidationException;
use Illuminate\Http\Request;
use function Aws\recursive_dir_iterator;

class TranslationsController extends Controller
{

    public function index(Languages $languages)
    {
        $translations = $languages->translation;
        return view('admin.translations.index', ['languages' => $languages, 'translations' => $translations]);
    }

    public function store(Request $request, Languages $languages)
    {
        $exists = Translations::where('key', $request->post('key'))->where('language_id',$languages->id)->first();

        if ($exists)
            return back()->with('showError','Key already exists');

        $translations = new Translations();
        $translations->group = $request->get('group');
        $translations->key = $request->get('key');
        $translations->translation = $request->get('translation');
        $translations->language_id = $languages->id;

        $translations->save();

        return redirect()->back();
    }

    public function update(Request $request, Languages $languages, Translations $translation)
    {
        $translation->group = $request->get('group')??'';
        $translation->translation = $request->get('translation')??'';

        $translation->update();
        return redirect()->back();
    }

    public function destroy(Languages $languages,Translations $translation)
    {
        $translation->delete($translation->id);
        return redirect()->back();
    }
}
