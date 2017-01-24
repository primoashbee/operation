<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CollectionController extends Controller
{
    public function index(){
        $clusters = new \App\Disbursement_Information;
        $clusters = $clusters->activeForCollection();
        
        
        return view('pages.view-loans-for-collection',['clusters'=>$clusters]);
    }
    public function getCollectionValues($id){
        return view('pages.collect-from-cluster');
    }
    public function createAmortScheduling($amt){
        $products = new \App\Products;
        $products = $products->first();
        $loan_amount =$amt;
        $term  = $products->loan_term;
        $rate = $products->interest_rate;
        $weeks_to_pay=$products->weeks_to_pay;
        $wcr=$products->weekly_compounding_rate;
        $data =  create_amortization($loan_amount,$rate,$term,$weeks_to_pay,$wcr);
        
        return view('pages.table',['data'=>$data]);
     
        
    }
    public function retreiveAmortByDisburseAndClientId($disbursement_id,$client_id){
       
       $amort = new \App\Amortization;
       $amort = $amort->where('disbursement_id','=',$disbursement_id)->where('client_id','=',$client_id)->get();
       
       $p_total = 0;
       $i_total = 0;
        foreach($amort as $x){
            $p_total+=$x->principal_this_week;
            $i_total+=$x->interest_this_week;
            echo $x->week. ' | '.$x->principal_this_week.' | '.$x->interest_this_week.' | '.$x->principal_balance.' | '.$x->interest_balance.' |<br>';
        }

        echo 'tP: '.pesos($p_total).'<br>';
        echo 'tI:     '.pesos($i_total).'<br>';
    }
}
