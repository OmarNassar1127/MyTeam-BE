<?php

// App\Models\Game.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Game extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(User::class, 'game_users')
                    ->withPivot('is_manager', 'status', 'goals', 'assists', 'yellow_cards', 'red_cards')
                    ->withTimestamps();
    }
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function players()
    {
        return $this->belongsToMany(User::class, 'game_users')
                    ->wherePivot('is_manager', false)
                    ->withTimestamps();
    }

    public function managers()
    {
        return $this->belongsToMany(User::class, 'game_users')
                    ->wherePivot('is_manager', true)
                    ->withTimestamps();
    }

    public function getFormattedScoreAttribute()
    {
        $teamScore = $this->gameUsers()->sum('goals');
        $opponentScore = $this->opponent_score ?? 0;

        if ($this->home) {
            return "{$teamScore}-{$opponentScore}";
        } else {
            return "{$opponentScore}-{$teamScore}";
        }
    }

    public function gameUsers()
    {
        return $this->hasMany(GameUser::class, 'game_id');
    }
}
