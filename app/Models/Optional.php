<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Optional extends Model
{
    protected $table = 'optionals';
    use HasFactory;

    public static function Optionals_Status($id)
    {
        $user = Optional::where('status', 1)
            ->where('id', '=', $id)
            ->get();
        return $user;
    }
}
