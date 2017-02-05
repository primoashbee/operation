<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment_Information extends Model
{
    protected $table = 'payment_informations';

    protected $fillables = ['amort_id','amount_paid','principal_paid','p_balance_this_week','i_balance_this_week'];
    protected $dates = ['created_at','updated_at'];

    public function paymentSummary(){

    }
}
