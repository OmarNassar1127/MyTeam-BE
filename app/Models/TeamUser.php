<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TeamUser extends Pivot
{
    use HasFactory, SoftDeletes;

    protected $table = 'team_users';

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
