<?php

namespace App\Helpers;

use App\Models\EmailTranslation;
use DirectoryIterator;

class EmailHelper
{

    public static function GetAllPossibleEmailTranslations($includeLanguages = false)
    {
        $result = [];
        $dir_path = app_path() . '/Mail/Mails';
        $dir = new DirectoryIterator($dir_path);
        foreach ($dir as $fileinfo) {
            if (!$fileinfo->isDot()) {
                $name = explode('.', $fileinfo->getFilename())[0];
                if ($name != "Mailable") {
                    if ($includeLanguages) {
                        foreach (LanguageHelper::$allLanguageIsos as $country => $iso) {
                            $result[] = $name . '_' . $iso;
                        }
                    } else {
                        $result[] = $name;
                    }
                }
            }
        }
        return $result;
    }

    public static function GetEmailTranslation(string $calledClass, string $language)
    {
        $firstTry = EmailTranslation::where([
            ['type', '=', $calledClass],
            ['language', '=', $language],
        ])->first();
        if(!$firstTry) {
            return EmailTranslation::where([
                ['type', '=', $calledClass],
                ['language', '=', LanguageHelper::$DEFAULT_LANGUAGE],
            ])->first();
        }
        return $firstTry;
    }

    public static function GetEmailDescription(string $name)
    {
        $class = "App\Mail\Mails\\" . $name;
        return $class::$description;
    }

}
