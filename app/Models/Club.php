<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Club extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'address', 'contact_info', 'email', 'president_user_id'];

    public function teams()
    {
        return $this->hasMany(Team::class);
    }

    // public function president()
    // {
    //     return $this->belongsTo(User::class, 'president_user_id');
    // }

    public function presidents()
    {
        return $this->hasManyThrough(
            User::class,
            UserRole::class,
            'user_id',
            'id',
            'president_user_id',
            'user_id'
        )->whereHas('roles', function ($query) {
            $query->where('name', 'president');
        });
    }

    public function managers()
    {
        return $this->teams->flatMap->managers->unique('id');
    }

    public function players()
    {
        return $this->teams->flatMap->players->unique('id');
    }

}
