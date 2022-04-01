<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status_Order extends Model
{
    protected $table = 'status_orders';
    protected $fillable = ['id','name'];
   
    use HasFactory;
}
