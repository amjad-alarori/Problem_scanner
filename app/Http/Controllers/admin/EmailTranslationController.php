<?php

namespace App\Http\Controllers\admin;

use App\Helpers\EmailHelper;
use App\Helpers\LanguageHelper;
use App\Models\EmailTranslation;
use Illuminate\Http\Request;

class EmailTranslationController
{

    public function index()
    {
        $emailTranslations = [];
        foreach (EmailTranslation::all() as $e) {
            $emailTranslations[$e->type][] = $e;
        }

        return view('admin.email.translations.index', compact("emailTranslations"));
    }

    public function store(Request $request)
    {
        $exists = EmailTranslation::where([
            ['type', '=', $request->post('type')],
            ['language', '=', $request->post('language')],
        ])->first();
        if ($exists || !in_array($request->post('type'), EmailHelper::GetAllPossibleEmailTranslations())) {
            return redirect(route('emailtranslation.edit', ['emailtranslation' => $exists]) . "?exists=true");
        }
        EmailTranslation::create([
            'type' => $request->post('type'),
            'language' => $request->post('language'),
            'subject' => '',
            'body' => '',
        ]);
        return back();
    }

    public function update(Request $request, EmailTranslation $emailtranslation)
    {
        $result = $request->validate([
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
        ]);
        $emailtranslation->update($result);
        return redirect(route('emailtranslation.index'));
    }

    public function edit(EmailTranslation $emailtranslation)
    {
        $class = "App\Mail\Mails\\" . $emailtranslation->type;
        $variables = $class::$variableDocumentation;
        return view('admin.email.translations.edit', compact('emailtranslation', 'variables'));
    }

    public function preview(EmailTranslation $emailtranslation)
    {
        return view('admin.email.translations.preview', compact('emailtranslation'));
    }

    public function previewFrame(EmailTranslation $emailtranslation)
    {
        $body = $emailtranslation->body;
        return view('mails.mail', compact('body'));
    }

    public function destroy(EmailTranslation $emailtranslation)
    {
        if ($emailtranslation->language === LanguageHelper::$DEFAULT_LANGUAGE) {
            return redirect(route('emailtranslation.index') . "?delete=false");
        }
        $emailtranslation->delete();
        return redirect(route('emailtranslation.index'));
    }

}
