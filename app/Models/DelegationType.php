<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DelegationType extends Model
{
    protected $fillable = ['name', 'status'];

    public static function getAllType() {
        return DelegationType::orderBy('id', 'desc')->paginate(10);
    }

    public static function getTypeName($types) {
        $typeIds = array_filter(explode(',', $types));
        $typeNames = DelegationType::whereIn('id', $typeIds)->pluck('name');
        return $typeNames->implode(', ');
    }
}
