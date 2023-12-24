<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles')->withTimestamps();
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class, 'team_users');
    }

    /*
     * Scopes
    */

    public function scopeIsPresident($query)
    {
        return $query->whereHas('roles', function ($subQuery) {
            $subQuery->where('name', 'president');
        });
    }

    public function scopeIsManager($query)
    {
        return $query->whereHas('roles', function ($subQuery) {
            $subQuery->where('name', 'manager');
        });
    }

    public function scopeIsPlayer($query)
    {
        return $query->whereHas('roles', function ($subQuery) {
            $subQuery->where('name', 'player');
        });
    }
}
