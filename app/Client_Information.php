<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client_Information extends Model
{
    protected $table='clients';
    public $fillable=['lastname','firstname','middlename','branch_id','suffix','nickname','mother_name','spouse_name','TIN','birthday','home_address','home_year','business_address','business_year','mobile_number','telephone_number','civil_status','sex','education','house_type'];    public function business(){
        return $this->hasOne('App\Client_Business','client_id');
    }
    public function marami(){
        return $this->hasMany('App\Client_Business','client_id');
    }
    public function income(){
        return $this->hasOne('App\Client_Income','client_id');
    }
    public function branch(){
        return $this->belongsTo('App\Branch_Information','branch_id');
    }
}
