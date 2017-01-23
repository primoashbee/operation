<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Credit_Limit;
class CreditController extends Controller{
    public function preCredit($id){
        if(Credit_Limit::where('client_id','=',$id)->exists()){
            $products = new \App\Products;
            $product = $products::all();
            $lists = new \App\Client_Information;
        
            $list = $lists::all();  
            $info = Credit_Limit::where('client_id','=',$id)->first();
           
        }else{
            $cl = new Credit_Limit();
            $cl->client_id = $id;
            $cl->save();
            
            $products = new \App\Products;
            $product = $products::all();
            $lists = new \App\Client_Information;
        
            $list = $lists::all();  
            $info = Credit_Limit::find($cl->id);

        }
            return view('pages.credit-limit',['products'=>$product,'list'=>$list,'cluster_id'=>$id,'info'=>$info]);
    }
    public function postCredit(Request $request, $id){
        $input = $request->all();
        $credit_limit = new Credit_Limit;
        $credit_id = $credit_limit->where('client_id','=',$id)->first()->id;
        $rules = [
            'co_maker_inside_cluster_id' => 'exists:clients,id|required',
            'co_maker_outside_cluster_id' => 'exists:clients,id|required',

            'business_net_disposable_income' => 'required|min:1',
            'household_income' =>'required|min:1', 
            'household_expense' =>'required|min:1', 
            'financial_risk_assessment' =>'required|min:1', 
           
        ];
        $msgs = [
            'co_maker_inside_cluster_id.required' => 'Select Co-Maker inside the cluster',
            'co_maker_inside_cluster_id.exists' => 'Co-Maker doest not exist',
            'co_maker_outside_cluster_id.required' => 'Select Co-Maker inside the cluster',
            'co_maker_outside_cluster_id.exists' => 'Co-Maker doest not exist',
            'business_net_disposable_income.required' => 'Provide Business Net Disposable Income',
            'business_net_disposable_income.min' => 'Business Net Disposable Income must be a positive number',
            'household_income.required' => 'Provide Household Income',
            'household_income.min' => ' Household must be a positive number',
            'household_income.required' => 'Provide Household Income',
            'household_income.min' => 'Household must be a positive number',
            'household_expense.required' => 'Provide Household Expense',
            'household_expense.min' => 'Household must be a positive number',
            'financial_risk_assessment.required' => 'Provide Financial Risk Assesment',
            'financial_risk_assessment.min' => 'Financial Risk must be a positive number',
         
        ];
        $validator = \Validator::make($input,$rules,$msgs);
        if($validator->fails()){
            dd($validator->errors());
            return back()->withErrors($validator);
        }else{
            
            $cre = Credit_Limit::find($credit_id)->update($input);
            return back()->with('status',['code'=>1,'msg'=>'Credit Limit Updated']);
            
        }
     
    }
    
}
