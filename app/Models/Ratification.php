<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ratification extends Model
{

    protected $fillable = ['date', 'content', 'status'];

    public static function getAllRatification() {
        return Ratification::orderBy('date', 'desc')->paginate(10);
    }
}
