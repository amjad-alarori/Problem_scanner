<?php

namespace App\Models;

use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Scan extends Model
{
    use Searchable, HasFactory, SoftDeletes, Translatable;

    protected $fillable = [
        'name'
    ];

    public array $translatedAttributes = ['name'];

    public function categories()
    {
        return $this->hasMany(Categories::class);
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
