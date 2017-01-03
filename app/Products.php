<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Products extends Model
{
    use SoftDeletes;
    protected $table='products';
    protected $fillabe = ['name','interest_rate','minimum','maximum','loan_term'];
    protected $dates =['created_at','updated_at','deleted_at'];
    public function getClients(){
        return $this->hasMany('App\Client_Information','client_id');
    }
}
