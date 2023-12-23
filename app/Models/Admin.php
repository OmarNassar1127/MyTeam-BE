<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @mixin IdeHelperAdmin
 */
class Admin extends Authenticatable
{
    use HasApiTokens;

    protected $guarded = [];

    protected $casts = [
        'notifications' => 'array',
    ];

    protected $hidden = [
        'password',
    ];

    protected static function booted()
    {
        static::addGlobalScope('type', function (Builder $builder) {
            $builder->where('type', 'admin');
        });
    }
}
