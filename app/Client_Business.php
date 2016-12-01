<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client_Business extends Model
{
    protected $table='client_businesses';
    protected $fillable =['client_id','main_business','secondary_business','main_business_years','number_of_paid_employees','business_place_characteristic'];
    public function client(){
        return $this->belongsTo('App\Client_Information','client_id');
    }
}
