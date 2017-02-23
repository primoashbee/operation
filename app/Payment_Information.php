<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment_Information extends Model
{
    protected $table = 'payment_informations';

    protected $fillables = ['payment_summary_id','amort_id','amount_paid','principal_paid','p_balance_this_week','i_balance_this_week','payment_type'];
    protected $dates = ['created_at','updated_at'];

    public function paymentSummary(){

    }
    public function amortizationInfo(){
        $amort = new \App\Amortization;
        
        return $amort::find($this->amort_id);
        
        //return $this->belongsTo('App\Amortization','amort_id','amort_id');
    }
    public function lastWeekDue(){ 
        return $this->amortizationInfo()->pastDue();
        
    }
    public function weekDue(){
        $amort = new \App\Amortization;
        return $amort::find($this->amort_id);
    }
}
