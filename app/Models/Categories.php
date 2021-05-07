<?php

namespace App\Models;

use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Categories extends Model
{
    use Searchable, HasFactory, SoftDeletes, Translatable;

    public array $translatedAttributes = ['name'];

    protected $fillable = [
        'name',
        'scan_id',
        'color',
        'image'
    ];

    public function questions()
    {
        return $this->hasMany(Questions::class);
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
