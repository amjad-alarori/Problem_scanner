<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Results extends Model implements Searchable
{
    use HasFactory, SoftDeletes;

    public function Questions()
    {
        $data = collect();
        foreach ($this->results as $item) {
            $question = Questions::find($item->question_id);
            if ($question) {
                $data->add($question);
            }
        }
        return $data;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scan()
    {
        return $this->hasOne(Scan::class);
    }

    public function getSearchResult(): SearchResult
    {
        $url = route('results.index', $this->id);
        return new SearchResult(
            $this,
            $this->name,
            $url
        );
    }
}
