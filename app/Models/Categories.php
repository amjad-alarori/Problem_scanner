<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Categories extends Model implements Searchable
{
    use HasFactory; use SoftDeletes;

    public function questions(){
        return $this->hasMany(Questions::class);
    }
    public function getSearchResult(): SearchResult
    {
        $url = route('categories.index', $this->id);
        return new SearchResult(
            $this,
            $this->name,
            $url
        );
    }
}
