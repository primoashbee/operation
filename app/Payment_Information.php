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
    public function clientInfo(){
        $amort = $this->amortizationInfo();
        $client_id = $amort->client_id;
        $clients = new \App\Client_Information;
        $clients = $clients::find($client_id);
        return $clients;
    }
    public function remainingBalance(){
        $amort = $this->amortizationInfo();
        $d_id = $amort->disbursement_id;
        $client_id = $amort->client_id;
        $ls = new \App\Loans;
        $ls = $ls::where('disbursement_id','=',$d_id)->where('client_id','=',$client_id)->first();
        $prods = new \App\Products;
        $prods = $prods->first();


        $total_paid;

        $interest = $ls->loan_amount*($prods->interest_rate * $prods->loan_term);
        return $interest;
    }
    public function getPaymentSummary(){
        $ps = new \App\Payment_Summary;
        $ps = $ps::find($this->payment_summary_id);
        return $ps;
    }
}
