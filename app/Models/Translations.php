<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Translations extends Model
{
    use HasFactory;

    protected $fillable = [
        'language_id',
        'group',
        'key',
        'translation',
    ];
    /**
     * @var mixed
     */
    private $id;

    public function language()
    {
        return $this->belongsTo(Languages::class, 'language_id', 'id');
    }
}
