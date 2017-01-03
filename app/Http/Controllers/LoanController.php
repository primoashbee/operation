<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Loan_Applications;
class LoanController extends Controller
{
    public function index(){

        $all = new \App\client_Information;
        $clients = $all::paginate(15);
        $products = new \App\Products;
        $product = $products::all();

        return view('pages.apply-loan',['clients'=>$clients,'list'=>$clients,'products'=>$product]);
    }
    public function getAnalysisById(Request $request){
        $client_id = \Request('id'); 

        $info = \App\Loan_Applications::where('client_id','=', $client_id)->first();
        if($info==null){
            $info = array();
        }
        $la= new \App\Loan_Applications;
        $cycle = $la::where('client_id','=',$client_id)->count();
        
        return response()->json($info);
        
    }
    public function createLoan(Request $request,$id){
       
        $cfa = \App\Loan_Applications::where('client_id','=',$id)->get();
      
        $msg=array('MSG'=>'CLEAR');
        foreach($cfa as $x){
            if($x->status=="ON GOING"){
                echo $x->status.'<br>';
                $clients = new \App\Client_Information;
                $clients = $clients::find($id);
                $msg=array('MSG'=>$clients->lastname.', '.$clients->firstname.' has loan existing with status: ON GOING');
            }
        }
        if(str_contains($msg['MSG'],['ON GOING'])){
             //return back()->withErrors($msg);
        }else if(str_contains($msg['MSG'], ['CLEAR'])){
            $loan_application = new Loan_Applications();
            $rules = [
                //credit validation
                
                'business_net_disposable_income'=>'required | numeric |min:0',
                'household_income'=>'required | numeric |min:0',
                'household_expense'=>'required | numeric |min:0',
                'financial_risk_assessment'=>'required | numeric |min:0',
                'credit_limit'=>'required | numeric |min:0',

                //client validation
                //'client_id'=>'required | numeric | exists:clients,id | exists:cluster_members,client_id',
                'client_id'=>'required | numeric |  exists:cluster_members,client_id',
                'product_id'=>'required | numeric | exists:products,id',
                'purpose' => 'required',
                'loan_amount'=>'required | numeric',
                'loan_term'=>'required | numeric',
                'weeks_to_pay'=>'required | numeric',
                'loan_interest'=>'required | numeric',
                'loan_total'=>'required | numeric',
                'weekly_amortization'=>'required | numeric',
                'weekly_cbu'=>'required | numeric',
                'co_maker_inside_cluster_id'=>'required | numeric | exists:clients,id',
                'co_maker_outside_cluster_id'=>'required | numeric | exists:clients,id',
            ];
            $messages = [
                'business_net_disposable_income.required'=>'Business Net Disposable Income is required',
                'business_net_disposable_income.numeric'=>'Business Net Disposable Income should be numeric',
                'business_net_disposable_income.min'=>'Business Net Disposable Income cannot be 0',

                'household_income.required'=>'Household Income is required',
                'household_income.numeric'=>'Household Income should be numeric',
                'household_income.min'=>'Household Income cannot be 0',

                'financial_risk_assessment.required'=>'Financial Risk Assessment Income is required',
                'financial_risk_assessment.numeric'=>'Financial Risk Assessment should be numeric',
                'financial_risk_assessment.min'=>'Financial Risk Assessment cannot be 0',

                'credit_limit.required'=>'Credit Limit is required',
                'credit_limit.numeric'=>'Credit Limit  should be numeric',
                'credit_limit.min'=>'Credit Limit cannot be 0',

                'client_id.exists'=>'Cannot Apply Load when Client does not belong into a cluster',
                'product_id.exists'=>'Product should be existing'
            ];
            $validator  = \Validator::make($request->all(),$rules,$messages);
            if($validator->fails()){
        
             return back()->withErrors($validator);
            }
            $input = array_add($request->all(),'status','ON GOING');
            $loan_application->create($input);
            $status = array('code'=>1,'msg'=>'Loan Saved!');
            return back()->with('status',$status);
           
        }
        /*
        if(!$cfa){
            $cfa = new \App\Loan_Applications;
            $cfa->client_id=$id;
            $cfa->save();
           
        }else{
            $loan = new \App\Loan_Applications;
            $cfa = $loan::where('client_id','=',$id)->first();
        }
       
        dd($cfa); 
        
        $validator = \Validator::make($request->all(),$rules,$messages);
        if($validator->fails()){
            return back()->withErrors($validator);
        }
        $cfa->update($request->all());
        //$request->merge(['credit_limit'=>compute_credit_limit($request->business_net_disposable_income,$request->household_income,$request->household_expense)]);
        
        /*$clients = \App\Client_Information::paginate(15);
        //$input = array_merge($input,array('client_id'=>$id));
        $input = $request->except('_token');
        $bool = $cfa->update($input);
        dd($bool);
        //dd($cfa);
    
        if($bool){
            $client = $cfa->name->lastname.', '.$cfa->name->firstname;
            $msg = array('code'=>1,'msg'=>'Analysis UPDATED for '.$client);
        
        }else{
            $msg = array('code'=>0,'msg'=>'Something went Wrong');
        }
       
       // dd($request->all());
       $cfa->guard();
      
        return back()->with('status',$msg);
      */
    
    }
    public function checkCoMaker(Request $request){
        $members = new \App\Cluster_Members;
        $member = $members::where('client_id','=',$request->id)->get()   ;
        dd($member);
    }
    public function appliedLoans(){
        $list =  Loan_Applications::paginate(15);
    
         return view('pages.view-applied-loans',['list'=>$list]);
    }
    public function getLoanById($id){
        $loan = Loan_Applications::find($id);
        
        return response()->json($loan);
        
    }
}
