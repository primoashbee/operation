<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LoanInsurance extends Model
{
    public $mi_fee = 90;
    public $rate = 0.005; //5%
    public function compute($amt){
        $total = $amt * $this->rate;
        $cblic_fee = round(($amt /1000) * 2.70, 2); //2.70 6 month load rate
        $lmi_fee = round($total - $cblic_fee,2);
        return array('total'=>pesos($total),'cblic_fee'=>$cblic_fee,'lmi_fee'=>$lmi_fee);        
    }
}
