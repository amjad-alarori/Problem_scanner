<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Results extends Model
{
    use HasFactory, Searchable, SoftDeletes;

    public function questions()
    {
        return $this->belongsToMany(Questions::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scan()
    {
        return $this->hasOne(Scan::class);
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'scan' => $this->scan,
            'name' => $this->name,
        ];
    }
}
