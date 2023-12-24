<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['club_id', 'name', 'category'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'team_users')
                    ->withPivot('is_manager')
                    ->withTimestamps();
    }

    public function managers()
    {
        return $this->belongsToMany(User::class, 'team_users')
                    ->wherePivot('is_manager', true)
                    ->withTimestamps();
    }

    public function players()
    {
        return $this->belongsToMany(User::class, 'team_users')
                    ->wherePivot('is_manager', false)
                    ->withTimestamps();
    }
    public function games()
    {
        return $this->hasMany(Game::class);
    }

    public function gameManagers()
    {
        return $this->belongsToMany(User::class, 'game_users')
                    ->withPivot('is_manager')
                    ->wherePivot('is_manager', true)
                    ->withTimestamps();
    }

    public function gamePlayers()
    {
        return $this->belongsToMany(User::class, 'game_users')
                    ->withPivot('is_manager')
                    ->wherePivot('is_manager', false)
                    ->withTimestamps();
    }

    public function sessions()
    {
        return $this->hasMany(Session::class);
    }

    public function sessionManagers()
    {
        return $this->belongsToMany(User::class, 'session_users')
                    ->withPivot('is_manager')
                    ->wherePivot('is_manager', true)
                    ->withTimestamps();
    }

    public function sessionPlayers()
    {
        return $this->belongsToMany(User::class, 'session_users')
                    ->withPivot('is_manager')
                    ->wherePivot('is_manager', false)
                    ->withTimestamps();
    }

}
