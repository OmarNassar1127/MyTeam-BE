<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Game extends Model
{
    use HasFactory, SoftDeletes;

    public function users()
    {
        return $this->belongsToMany(User::class, 'game_users')
                    ->withPivot('is_manager')
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
}
