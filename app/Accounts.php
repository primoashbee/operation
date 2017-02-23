<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
class Accounts extends Authenticatable
{
    protected $table = 'accounts';
    protected $fillable = [
        'username', 
        'password', 
        'branch_code', 
        'is_admin', 
        'remember_token'
    ];
    protected $dates = [
        'created_at',
        'deleted_at'
    ];
    public function login($request){
          
        if(\Auth::attempt($request)){
            return true;
        }else{
            return false;
        }
    }
}
