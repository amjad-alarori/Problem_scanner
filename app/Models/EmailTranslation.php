<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailTranslation extends Model
{
    use HasFactory, SoftDeletes;

    protected static $rules = [
        'subject' => 'required|string|max:255',
        'body' => 'required|string',
        'language' => 'required|string|max:2'
    ];

    protected $fillable = [
        'type',
        'subject',
        'body',
        'language',
    ];

}
