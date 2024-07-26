<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delegation extends Model
{
    protected $fillable = ['name','number','rat_id','type','status'];

    public function rat_info() {
        return $this->hasOne('App\Models\Ratification','id','rat_id');
    }

    public static function getAllDelegation () {
        return Delegation::orderBy('number', 'asc')->paginate(10);
    }

}