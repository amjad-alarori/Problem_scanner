<?php

namespace App\Http\Controllers\admin;

use App\Helpers\EmailComponentHelper;
use App\Helpers\LanguageHelper;
use App\Models\EmailComponentTranslation;
use Illuminate\Http\Request;

class EmailComponentTranslationController
{

    public function index()
    {
        $emailComponentTranslations = [];
        foreach (EmailComponentTranslation::all() as $e) {
            $emailComponentTranslations[$e->type][] = $e;
        }

        return view('admin.email.componenttranslations.index', compact("emailComponentTranslations"));
    }

    public function store(Request $request)
    {
        $exists = EmailComponentTranslation::where([
            ['type', '=', $request->post('type')],
            ['language', '=', $request->post('language')],
        ])->first();
        if ($exists || !in_array($request->post('type'), EmailComponentHelper::GetAllPossibleEmailComponentTranslations())) {
            return redirect(route('emailcomponenttranslation.edit', ['emailcomponenttranslation' => $exists]) . "?exists=true");
        }
        EmailComponentTranslation::create([
            'type' => $request->post('type'),
            'language' => $request->post('language'),
            'text' => '',
        ]);
        return back();
    }

    public function update(Request $request, EmailComponentTranslation $emailcomponenttranslation)
    {
        $result = $request->validate([
            'text' => 'required|string|max:255',
        ]);
        $emailcomponenttranslation->update($result);
        return redirect(route('emailcomponenttranslation.index'));
    }

    public function edit(EmailComponentTranslation $emailcomponenttranslation)
    {
        return view('admin.email.componenttranslations.edit', compact('emailcomponenttranslation'));
    }

    public function destroy(EmailComponentTranslation $emailcomponenttranslation)
    {
        if ($emailcomponenttranslation->language === LanguageHelper::$DEFAULT_LANGUAGE) {
            return redirect(route('emailcomponenttranslation.index') . "?delete=false");
        }
        $emailcomponenttranslation->delete();
        return redirect(route('emailcomponenttranslation.index'));
    }

}
