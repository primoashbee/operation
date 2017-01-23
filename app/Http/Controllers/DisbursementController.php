<?php

namespace App\Http\Controllers;

use App\Disbursement_Information;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
class DisbursementController extends Controller
{
    public function preDisbursement($id){
        $members = new \App\Cluster_Members;
        $loans = Disbursement_Information::orderBy('created_at','desc')->where('cluster_id','=',$id)->first();
        $clusters = new \App\Cluster_Information();
        $cluster = $clusters::find($id);
        //check if cluster has on going transaction;
        if($cluster->totalMembers($id)==0){
            return back()->with('status',['code'=>0,'msg'=>'This cluster ['.$cluster->code.'] has ZERO MEMBERS']);
        }
        if($loans==null){
        }else{
            if($loans->status =='on-going'){
                
                return back()->with('status',['code'=>0,'msg'=>'This cluster ['.$loans->clusterInfo->code.'] has ON GOING transaction']);
            }
        }

        $members = $members::where('cluster_id','=',$id)->paginate(20);
        $products = new \App\Products;
        $mpl = $products::first();
        return view('pages.cluster-disburse',['clients'=>$members,'cluster_id'=>$id,'weeks_to_pay'=>$mpl->weeks_to_pay]);
    }
    public function postDisbursement(Request $request, $id){
        $loans = new Disbursement_Information();
        $loans = $loans::where('cluster_id','=',$id)->orderBy('created_at','desc');
        $product = new \App\Products;
        $mpl = $product::first();
        if($loans->where('status','=','on-going')->exists()){
            return back()->with('status',['code'=>0,'msg'=>'This cluster has ON GOING transaction']);
        }
      
        $number_of_clients= count($request->loan_amount);
        //if clients did not reached minimum 10 clients
        if($number_of_clients<0){
            return back()->with('status',['code'=>0,'msg'=>'Loan Module should be atleast 10 minimum clients']);
        }
       
        //get current time for bulk insertion coz bulk model insertion is </3
        $now = Carbon::now()->toDateTimeString();
        
        $input = $request->except(['loan_amount']);
        $total_loan=0;
        //compute total loan amount
        foreach($request->loan_amount as $key => $value){
         //if id contains inside checked boxes on not to reloan/loan
            if(!array_has($request->reloan, $key)){
                $total_loan+=$value;
                

            }
        }
       
        //add associative arrays in input variable
        $input = array_add($input,'loan_amount',$total_loan);
        $input = array_add($input,'is_finished',false);
        $input = array_add($input,'status','on-going');
        $loans = new Disbursement_Information();
       
        //dd($input); 
        $disbursement_id=$loans->create($input);
    

        $client_loan = new \App\Loans;
        $loan_input=array();
        $process_fee = 0.015;
        $loan_summaries = new \App\Loans;

        foreach($request->loan_amount as $key => $value){
            //if id contains inside checked boxes on not to reloan/loan
            if(!array_has($request->reloan, $key)){
                $total_loan+=$value;
                $loan_input=array(
                    'disbursement_id'=>$disbursement_id->id,
                    'client_id'=>$key,
                    'loan_amount'=>$value,
                    'loan_term'=>$mpl->loan_term,
                    'cbu_new'=>0,
                    'cbu_reloan'=>0,
                    'processing_fee'=>$process_fee*$value,
                    'doc_stamp_tax'=>0,
                    'mi_premium'=>0,
                    'cli_premium'=>0,
                    'total_pre_deductions'=>0,
                    'total_loan_amount'=>0,
                    'status'=>'on-going',
                    'is_payed'=>false,
                    );
                    $loan_summaries->create($loan_input);
            
            }
        }
     
        return redirect('/Loans/Applied')->with('status',['code'=>1,'msg'=>'Disbursement Success']);
    
       
     
    }
    
}