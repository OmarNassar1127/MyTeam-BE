<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserRole extends Pivot
{
    use HasFactory, SoftDeletes;

    protected $table = 'user_roles';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
