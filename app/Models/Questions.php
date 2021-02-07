<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Questions extends Model implements Searchable
{
    use HasFactory; use SoftDeletes;
    public function categories(){
        return $this->belongsTo(Categories::class);
    }
    public function getSearchResult(): SearchResult
    {
        $url = route('questions.index', $this->id);
        return new SearchResult(
            $this,
            $this->question,
            $url
        );
    }
}
