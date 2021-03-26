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
        'FOOTER_TEXT' => "© 2021 - Orange Eyes"
    ];

}

