<?php

namespace App\Models;

use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Questions extends Model
{
    use Searchable, HasFactory, SoftDeletes, Translatable;

    protected $fillable = [
        'question',
        'categories_id',
        'image'
    ];

    public array $translatedAttributes = [
        'question'
    ];

    public function categories()
    {
        return $this->belongsTo(Categories::class);
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'question' => $this->question,
        ];
    }
}
