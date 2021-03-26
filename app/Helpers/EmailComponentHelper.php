<?php

namespace App\Helpers;

use App\Models\EmailComponentTranslation;
use DirectoryIterator;

class EmailComponentHelper
{

    public static function GetAllPossibleEmailComponentTranslations($includeLanguages = false)
    {
        $result = [];
        $dir_path = app_path() . '/Mail/Components';
        $dir = new DirectoryIterator($dir_path);
        foreach ($dir as $fileinfo) {
            if (!$fileinfo->isDot()) {
                $name = explode('.', $fileinfo->getFilename())[0];
                if ($includeLanguages) {
                    foreach (LanguageHelper::$allLanguageIsos as $country => $iso) {
                        $result[] = $name . '_' . $iso;
                    }
                } else {
                    $result[] = $name;
                }
            }
        }
        return $result;
    }

    public static function Button($url, $language = null)
    {
        $text = self::GetText('Button', $language);
        return view('mails.components.button', compact('url', 'text'))->render();
    }

    public static function GetEmailComponentDescription(string $name)
    {
        $class = "App\Mail\Components\\" . $name;
        return $class::$description;
    }

    public static function GetText(string $string, $language)
    {
        $firstTry = EmailComponentTranslation::where([
            ['type', '=', $string],
            ['language', '=', $language],
        ])->first();
        if(!$firstTry) {
            return EmailComponentTranslation::where([
                ['type', '=', $string],
                ['language', '=', LanguageHelper::$DEFAULT_LANGUAGE],
            ])->first()->text;
        }
        return $firstTry->text;
    }

}
