<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InsuranceController extends Controller
{
    public function summaryPerDisbursementID($disbursement_id){
        $ls = new \App\Loans;
        $ls = $ls::where('disbursement_id','=',$disbursement_id);
        if($ls->count() == 0){
            echo 'Data Error';
            return;
        }
        $ls = $ls->get();
        $t_head_count = 0;
        foreach($ls as $x){
            $t_head_count = $t_head_count  + $x->insuranceInformation()->head_count;
        }
        return view('pages.view-insurance-per-disbursement-id',['clients'=>$ls,'head_count'=>$t_head_count,'dependents_only'=>$t_head_count-$ls->count()]);
    }
}
