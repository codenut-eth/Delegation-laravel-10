<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ratification extends Model
{

    protected $fillable = ['date', 'content', 'status'];

    public static function getAllRatification() {
        return Ratification::orderBy('date', 'desc')->paginate(10);
    }

    public static function countActiveRatification() {
        $data = Ratification::where('status', 'active')->count();
        if($data) {
            return $data;
        }
        return 0;
    }
}
