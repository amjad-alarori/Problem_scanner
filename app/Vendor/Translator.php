<?php

namespace App\Vendor;

use App\Helpers\LanguageHelper;
use App\Models\Languages;
use App\Models\Translations;

class Translator extends \Illuminate\Translation\Translator
{
    public function get($key, array $replace = [], $locale = null, $fallback = true)
    {
        $locale = $locale ?: $this->locale;

        if ($d = $this->TryDb($key, $locale)) {
            return $d;
        }

        if ($dd = $this->TryDb($key, LanguageHelper::$DEFAULT_LANGUAGE)) {
            return $dd;
        }

        return $key;
    }

    public function TryDb($key, $iso)
    {
        $language = Languages::where('language', $iso)->first();

        if ($language) {
            $translation = Translations::where([
                ['key', '=', $key],
                ['language_id', '=', $language->id]
            ])->first();

            if ($translation) {
                return $translation->translation;
            }
        }
    }

}
