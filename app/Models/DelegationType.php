<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DelegationType extends Model
{
    protected $fillable = ['name', 'status'];

    public static function getAllType() {
        return DelegationType::orderBy('id', 'desc')->paginate(10);
    }
}
