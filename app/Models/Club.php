<?php

namespace App\Models;

use Spatie\MediaLibrary\HasMedia;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Club extends Model implements HasMedia
{
    use SoftDeletes, InteractsWithMedia;

    protected $fillable = ['name', 'address', 'contact_info', 'email', 'president_user_id'];

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('thumb')
             ->width(150)
             ->height(150)
             ->sharpen(10)
             ->performOnCollections('club_logos'); 
    }

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
