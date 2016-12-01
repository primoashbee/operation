<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client_Income extends Model
{
    protected $table='client_incomes';
    protected $fillable =[
        'client_id',
        'member_lastname',
        'member_firstname',
        'member_middlename',
        'member_suffix',
        'member_age',
        'member_relationship',
        'member_occupation',
        'member_occupation_years',
        'member_monthly_income',
        'member_address'
    ];

    public function client(){
        return $this->belongsTo('App\Client_Information','client_id');
    }
}
