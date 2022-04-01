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

    public static function innerjoinHamburgerOpMeInfo($hamburger_id)
    {
      $user = Optionals_Burger::where('optionalsburger.hamburger_id', $hamburger_id)
        ->join('optionals', 'optionalsburger.optionals_id', '=', 'optionals.id')
        ->select(
          'optionalsburger.id',
          'optionalsburger.optionals_id',
          'optionalsburger.hamburger_id',
          'optionals.name as optional',
          'optionals.price'
        )
        ->get();
      return $user;
    }
}
