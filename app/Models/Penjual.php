<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Penjual extends Authenticatable
{
    protected $fillable = [
    'name', 'email', 'password', 'photo', 'ktp', 'npwp', 'is_online'
];


    protected $hidden = [
        'password',
    ];
}
