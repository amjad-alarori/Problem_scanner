<?php

namespace App\Models;

use App\Traits\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Searchable\SearchResult;
use Spatie\Searchable\Searchable;

class Scan extends Model implements Searchable
{
    use HasFactory, SoftDeletes, Translatable;

    protected $fillable = [
        'name'
    ];

    public array $translatedAttributes = ['name'];

    public function categories()
    {
        return $this->hasMany(Categories::class);
    }

    public function getSearchResult(): SearchResult
    {
        $url = route('scan.index', $this->id);
        return new SearchResult(
            $this,
            $this->name,
            $url
        );
    }
}
