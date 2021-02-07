<?php

namespace App\Models;

use App\Http\Controllers\ResultsController;
use Database\Seeders\RolesTableSeeder;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use jeremykenedy\LaravelRoles\Models\Role;
use jeremykenedy\LaravelRoles\Traits\HasRoleAndPermission;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class User extends Authenticatable implements MustVerifyEmail,Searchable
{
    use HasFactory, Notifiable, HasRoleAndPermission, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function results(){
        return $this->hasMany(Results::class);
    }
    public function roles(){
        return $this->belongstoMany(Role::class);
    }
    public function getSearchResult(): SearchResult
    {
        $url = route('user.show', $this->id);
        return new SearchResult(
            $this,
            $this->name,
            $url
        );
    }
}
