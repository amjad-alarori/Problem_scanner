<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'translation',
        'model',
        'model_id',
        'attribute',
        'language'
    ];
}
