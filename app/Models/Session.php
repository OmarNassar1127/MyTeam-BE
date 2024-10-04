<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Session extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(User::class, 'session_users')
                    ->withPivot( 'status')
                    ->withTimestamps();
    }
    
    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function players()
    {
        return $this->belongsToMany(User::class, 'session_users')
                    ->wherePivot('is_manager', false)
                    ->withTimestamps();
    }

    public function managers()
    {
        return $this->belongsToMany(User::class, 'session_users')
                    ->wherePivot('is_manager', true)
                    ->withTimestamps();
    }
}
