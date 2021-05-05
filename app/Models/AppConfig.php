<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppConfig extends Model
{

    protected $fillable = [
        'key',
        'value'
    ];

    public static array $DEFAULT_CONFIGS = [
        'FOOTER_TEXT' => ["Type" => "text", "Value" => "© 2021 - Orange Eyes"],
        'AUTH_BG_IMG' => ["Type" => "file", "Value" => ''],
        'LOGO_IMG' => ["Type" => "file", "Value" => '']
    ];

}

