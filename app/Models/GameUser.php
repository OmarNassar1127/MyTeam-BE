<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GameUser extends Pivot
{
    use HasFactory, SoftDeletes;

    protected $table = 'game_users';

    protected $guarded = [];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($pivot) {
            $user = User::with('roles')->find($pivot->user_id);
            $pivot->is_manager = $user->roles->contains('name', 'manager');
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}
