<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Delegation extends Model
{
    protected $fillable = ['name','number','rat_id','type','status','work_content'];

    public function rat_info() {
        return $this->hasOne('App\Models\Ratification','id','rat_id');
    }


    public static function getAllDelegation () {
        $delegations =  Delegation::orderBy('number', 'asc')->paginate(10);
        return $delegations;
    }

    public static function countActiveDelegation () {
        $data = Delegation::where('status', 'active')->count();
        if($data) {
            return $data;
        }
        return 0;
    }

}
