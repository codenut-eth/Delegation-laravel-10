<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = ['name','dele_id','start_date','end_date','photo','status','work_results'];

    public function dele_info() {
        return $this->hasOne('App\Models\Delegation','id','dele_id');
    }

    public static function getAllMember() {
        return Member::orderBy('id','desc')->paginate(10);
    }
}
