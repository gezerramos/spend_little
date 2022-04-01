<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Hamburger extends Model
{

  protected $fillable = [
    'breads_id',
    'meats_id',
    'users_id',
    'status_orders_id'
  ];

  protected $table = 'hamburger';


  public static function innerjoinHamburgerMeInfo($id)
  {
    $user = Hamburger::where('hamburger.users_id', $id)
      ->join('breads', 'hamburger.breads_id', '=', 'breads.id')
      ->join('meats', 'hamburger.meats_id', '=', 'meats.id')
      ->join('status_orders', 'hamburger.status_orders_id', '=', 'status_orders.id')
      ->select(
        'hamburger.id',
        'hamburger.users_id',
        'hamburger.breads_id',
        'breads.name as breads',
        'breads.price as breads_price',
        'hamburger.meats_id',
        'meats.name as meats',
        'meats.price as meats_price',
        'hamburger.status_orders_id',
        'status_orders.name as status_orders',
        'hamburger.created_at',
        'hamburger.updated_at',
      )
      ->get();
    return $user;
  }

 
}
