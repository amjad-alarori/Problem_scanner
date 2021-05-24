<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Languages extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'language',
    ];
    /**
     * @var mixed
     */
    private $id;

    public function translation()
    {
        return $this->hasMany(Translations::class, 'language_id', 'id');
    }
}
