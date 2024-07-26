<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillables = ['name','dele_id','start_date','end_date','photo'];

    public function dele_info() {
        return $this->hasOne('delegations','id','dele_id');
    }

    public static function getAllMember() {
        return self::orderBy('id','desc')->paginate(10);
    }
}
