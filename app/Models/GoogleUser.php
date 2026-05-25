<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GoogleUser extends Model
{
    protected $table = 'google_users';

    protected $fillable = [
        'firebase_uid',
        'name',
        'email',
        'avatar',
        'provider',
    ];

    protected $hidden = [
        'remember_token',
    ];
}