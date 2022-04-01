<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bread extends Model
{
    //protected $table = 'Breads';
    use HasFactory;
    public static function Bread_Status($id)
    {
        $user = Bread::where('status', 1)
            ->where('id', '=', $id)
            ->get();
        return $user;
    }
}
