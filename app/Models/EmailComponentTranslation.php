<?php

namespace App\Models;

use App\Helpers\LanguageHelper;
use Illuminate\Database\Eloquent\Model;

class EmailComponentTranslation extends Model
{

    protected $fillable = [
        'type',
        'language',
        'text',
    ];

}
