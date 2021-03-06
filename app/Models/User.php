<?php

namespace App\Models;

use App\Mail\Mails\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
use jeremykenedy\LaravelRoles\Models\Role;
use jeremykenedy\LaravelRoles\Traits\HasRoleAndPermission;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Auth\MustVerifyEmail as MustVerifyEmailAlias;
use Laravel\Scout\Searchable;

class User extends Authenticatable implements MustVerifyEmailContract
{
    use Searchable, HasFactory, Notifiable, HasRoleAndPermission, SoftDeletes, MustVerifyEmailAlias;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'language',
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

    public function results()
    {
        return $this->hasMany(Results::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function toSearchableArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
        ];
    }

    public function sendPasswordResetNotification($token)
    {
        Mail::to($this->email)->send(new ResetPassword($this, url('password/reset', $token) . "?email=" . $this->email));
    }

    public function Consultants(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'consulent_clients', 'client_id', 'consulent_id');
    }

    public function Verified(): bool
    {
        return $this->email_verified_at != null;
    }

}
