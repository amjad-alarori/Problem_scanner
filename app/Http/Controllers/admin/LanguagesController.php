<?php

namespace App\Http\Controllers\admin;

use App\Helpers\LanguageHelper;
use App\Http\Controllers\Controller;
use App\Models\Languages;
use App\Models\Translations;
use Illuminate\Http\Request;

class LanguagesController extends Controller
{

    public function index()
    {
        $languages = Languages::all();
        return view('admin.languages.index', ['languages' => $languages]);
    }

    public function store(Request $request)
    {
        $exists = Languages::where([
            ['language', '=', $request->post('language')]
        ])->first();
        if ($exists) {
            return redirect(route('translations.index', ['languages' => $exists->id]));
        }

        $createlanguage = new Languages();
        $createlanguage->fill([
            'name' => $request['name'],
            'language' => $request['language'],
        ]);

        $createlanguage->save();

        foreach (LanguageHelper::$DEFAULT_TRANSLATIONS as $group => $data) {
            foreach($data as $key => $value) {
                Translations::create([
                    'language_id' => $createlanguage->id,
                    'group' => $group,
                    'key' => $group . "." . $key,
                    'translation' => $value,
                ]);
            }
        }
        return redirect()->back();
    }

    public function update(Request $request, Languages $language)
    {
        $language->name = $request->get('name') ?? '';

        $language->update();
        return redirect()->back();
    }

    public function destroy(Languages $language)
    {
        $language->delete($language->id);
        return redirect()->back();
    }
}
