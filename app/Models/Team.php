<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

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
        return $this->hasMany(Game::class);
    }

    public function sessions()
    {
        return $this->hasMany(Session::class);
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
            ->withSum('gameParticipations as total_goals', 'goals')
            ->orderByDesc('total_goals')
            ->first();
    }

    public function topAssister()
    {
        return $this->players()
            ->withSum('gameParticipations as total_assists', 'assists')
            ->orderByDesc('total_assists')
            ->first();
    }

    public function mostPresent()
    {
        return $this->players()
            ->withCount(['gameParticipations as present_count' => function ($query) {
                $query->where('status', 'present');
            }])
            ->orderByDesc('present_count')
            ->first();
    }

    public function mostAbsent()
    {
        return $this->players()
            ->withCount(['gameParticipations as absent_count' => function ($query) {
                $query->where('status', 'absent');
            }])
            ->orderByDesc('absent_count')
            ->first();
    }

    public function getUpcomingGameAttribute()
    {
        return $this->games()
                    ->where('date', '>', now())
                    ->latest()
                    ->first();
    }

    public function getUpcomingTrainingAttribute()
    {
        return $this->sessions()
                    ->where('date', '>', now())
                    ->latest()
                    ->first();
    }
}
