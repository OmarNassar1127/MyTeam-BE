<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['club_id', 'name', 'category'];

    public function club()
    {
        return $this->belongsTo(Club::class);
    }

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
        return $this->hasMany(Game::class, 'game_users')->withPivot('status');
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
        return $this->belongsToMany(Game::class, 'game_users')->withPivot('status');
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

    public function topScorer()
    {
        return $this->players()
                    ->with('profile') 
                    ->get()
                    ->sortByDesc(function ($player) {
                        return $player->profile ? $player->profile->goals : 0;
                    })->first();
    }

    public function topAssister()
    {
        return $this->players()
                    ->with('profile')
                    ->get()
                    ->sortByDesc(function ($player) {
                        return $player->profile ? $player->profile->assists : 0;
                    })->first();
    }

    public function mostPresent()
    {
        return $this->players()
                    ->withCount(['gameParticipations as present_games_count' => function($query) {
                        $query->where('status', 'present');
                    }, 'sessionParticipations as present_sessions_count' => function($query) {
                        $query->where('status', 'present');
                    }])
                    ->orderByDesc('present_games_count')
                    ->orderByDesc('present_sessions_count')
                    ->first();
    }

    public function mostAbsent()
    {
        return $this->players()
                    ->withCount(['gameParticipations as absent_games_count' => function($query) {
                        $query->where('status', 'absent');
                    }, 'sessionParticipations as absent_sessions_count' => function($query) {
                        $query->where('status', 'absent');
                    }])
                    ->orderByDesc('absent_games_count')
                    ->orderByDesc('absent_sessions_count')
                    ->first();
    }
}
