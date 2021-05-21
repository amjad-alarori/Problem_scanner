<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Scout\Searchable;

class Results extends Model
{
    use HasFactory, Searchable, SoftDeletes;

    public function Questions()
    {
        $data = collect();
        foreach (json_decode($this->results) as $item) {
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
        return $this->hasOne(Scan::class, 'id', 'scan_id');
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
