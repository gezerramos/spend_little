<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Hamburger extends Model
{

  protected $fillable = ['breads_id', 
  'meats_id', 
  'users_id', 
  'status_orders_id'];

  protected $table = 'hamburger';

}
