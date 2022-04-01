<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meat extends Model
{
    use HasFactory;

    public static function Meat_Status($id)
    {
        $user = Meat::where('status', 1)
            ->where('id', '=', $id)
            ->get();
        return $user;
    }
}
