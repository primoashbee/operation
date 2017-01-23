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
    public function sample($amt){
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
}
