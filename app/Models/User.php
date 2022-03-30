<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{

  protected $fillable = ['name', 'email', 'password', 'level_id', 'status', 'image'];
  //protected $table = 'users';

  public static function innerjoinUserLevel($email)
  {
    $user = User::where('users.email', $email)
      ->join('levels', 'users.level_id', '=', 'levels.id')
      ->select(
        'users.id',
        'users.name',
        'users.email',
        'users.created_at',
        'users.level_id',
        'users.image',
        'levels.name as level'
      )
      ->get()[0];
    return $user;
  }

  public static function innerjoinAccountInfo($id)
  {
    $user = User::where('users.id', $id)
      ->join('levels', 'users.level_id', '=', 'levels.id')
      ->select(
        'users.id',
        'users.name',
        'users.email',
        'users.created_at',
        'users.level_id',
        'users.image',
        'levels.name as level'
      )
      ->get()[0];
    return $user;
  }
  public static function User_Email_Equals($id, $email)
  {
    $user = User::where('email', $email)
      ->where('id', '<>', $id)
      ->get();
    return $user;
  }

  public function getJWTIdentifier()
  {
    return $this->getKey();
  }

  public function getJWTCustomClaims()
  {

    return [];
  }
}
