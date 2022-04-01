<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Optionals_Burger extends Model
{

    protected $fillable = [
        'optionals_id',
        'hamburger_id'
    ];

    protected $table = 'optionalsburger';
}
