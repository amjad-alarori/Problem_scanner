<?php

namespace App\Helpers;

use App\Models\AppConfig;

class AppConfigHelper
{

    public static function GetConfig(string $key): string
    {
        return AppConfig::where('key', $key)->first()->value ?? AppConfig::$DEFAULT_CONFIGS[$key]['Value'];
    }

    public static function SetConfig($key, $value): AppConfig
    {
        return AppConfig::updateOrCreate([
            'key' => $key
        ], [
           'value' => $value ?? ''
        ]);
    }

}

