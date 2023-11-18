<?php

namespace App\Models;

use App\Models\Game;
use App\Models\Session;
use App\Models\PlayerProfile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PerformanceAnalysis extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'game_id',
        'session_id',
        'player_profile_id',
        'metrics', 
    ];

    protected $casts = [
        'metrics' => 'array',
    ];


    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function session()
    {
        return $this->belongsTo(Session::class);
    }

    public function playerProfile()
    {
        return $this->belongsTo(PlayerProfile::class);
    }
}
