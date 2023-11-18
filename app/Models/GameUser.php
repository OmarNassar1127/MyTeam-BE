<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class GameUser extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'game_users';

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
}
