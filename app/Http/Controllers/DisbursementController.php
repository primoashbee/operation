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
        if($cluster->countMembers()==0){
            return redirect('/Loans/Application')->with('status',['code'=>0,'msg'=>'This cluster ['.$cluster->code.'] has ZERO MEMBERS']);
        }elseif($cluster->countMembers() < 10){
            return redirect('/Loans/Application')->with('status',['code'=>0,'msg'=>'This cluster ['.$cluster->code.'] has less than 10 members ( 10 - 20 members only )']);
        }elseif($cluster->countMembers() > 20){
            return redirect('/Loans/Application')->with('status',['code'=>0,'msg'=>'This cluster ['.$cluster->code.'] has more than 20 members ( 10 - 20 members only )']);
        }
        if($loans==null){
        }else{
            if($loans->status =='on-going'){
                
                return redirect('/Loans/Application')->with('status',['code'=>0,'msg'=>'This cluster ['.$loans->clusterInfo->code.'] has ON GOING transaction']);
            }
        }
        
        $members = $members::where('cluster_id','=',$id)->paginate(20);
       
        $products = new \App\Products;
        $mpl = $products::first();
        $insurance = new \App\InsuranceRates;
        $insurance = $insurance::all(); 
        
        return view('pages.cluster-disburse',['clients'=>$members,'cluster_id'=>$id,'weeks_to_pay'=>$mpl->weeks_to_pay,'insurance'=>$insurance]);
    }
    public function postDisbursement(Request $request, $id){
        //dd($request->mi_premium_cblic);
        $loans = new Disbursement_Information();
        $errorBag= array();
        foreach($request->loan_amount as $k => $v){
           
            if(!($v >= 2000 &&  $v<= 99000)){
                $errorBag[] =  array('Input should be less than 99,000 or greater than 2,000 ('.$v.')');    
            }elseif($v % 1000 != 0){
                $errorBag[] =  array($v.' is not divisible by 1000') ;
            }
        }
        if($loans::where('cv_number','=',$request->cv_number)->count() > 0){
             $errorBag[] =  array('Check Voucher Number Already Been Used ['.$request->cv_number.']'); 
        }elseif($loans::where('check_number','=',$request->check_number)->count() > 0){
             $errorBag[] =  array('Check Number Already Been Used ['.$request->check_number.']'); 
        }


        if(count($errorBag) > 0){
            return back()->withErrors($errorBag);
        }

     
      
        $loans = $loans::where('cluster_id','=',$id)->orderBy('created_at','desc');
        $product = new \App\Products;
        $mpl = $product::first();
        $first_collection_date = $request->first_collection_date;
       
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
       
        //dd($request->cli_premium_cblic[12]); 
        
        $disbursement_id=$loans->create($input);
        

        $client_loan = new \App\Loans;
        $loan_input=array();
        $process_fee = 0.015;
        $loan_summaries = new \App\Loans;

        $mi = new \App\InsuranceRates;
        
        foreach($request->loan_amount as $key => $value){
            //if id contains inside checked boxes on not to reloan/loan
            //dd($request->cli_premium_cblic[$key]);
            //dd($mi = $mi::find($key));  
            $mi_id = $request->mi[$key];
            $mi = $mi::find($mi_id);
            $insurance = new \App\LoanInsurance;
            $cli = $insurance->compute($value);
            
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
                    'mi_id'=>$mi_id,
                    'mi_premium_cblic'=>$mi->total,
                    'mi_premium_lmi'=>$mi->mi_fee,
                    'cli_premium_cblic'=>$cli['cblic_fee'],
                    'cli_premium_lmi'=>$cli['lmi_fee'],
                    'total_pre_deductions'=>0,
                    'total_loan_amount'=>0,
                    'status'=>'on-going',
                    'is_payed'=>false,
                    );
                    $loan_summaries->create($loan_input);

                    $product = new \App\Products;
                    $product = $product->first();
                    $table = create_amortization($value,$product->interest_rate,$product->loan_term,$product->weeks_to_pay,$product->weekly_compounding_rate,$first_collection_date);
                    $amort = [];
                    $amortizations = new \App\Amortization;
                    
                    foreach($table->table as $data){
                        $amort[] = array(
                            'disbursement_id' => $disbursement_id->id,
                            'client_id'=>$key,
                            'week'=>$data->week,
                            'principal_this_week'=>$data->principal,
                            'interest_this_week'=>$data->interest,
                            'principal_with_interest'=>$data->principal + $data->interest,
                            'principal_balance'=>$data->p_balance,
                            'interest_balance'=>$data->i_balance,
                            'collection_date'=>$data->collection_date
                        );

                    }
                  
                    $amortizations->insert($amort);

            
            }
        }
     
        return redirect('/Loans/Applied')->with('status',['code'=>1,'msg'=>'Disbursement Success']);
    
       
     
    }
    public function deleteDisbursement($id){
        $di = new Disbursement_Information();
        $di = $di::find($id);
        /*if(!$di==null){
        if($di->hasStartedCollecting()){
                return 'Nag collect na bes';
        }
        */
        $am = new \App\Amortization; //Amortizations
        $loans = new \App\Loans; //Loan Summaires
        $pi = new \App\Payment_Information;
        $ps = new \App\Payment_Summary;
        /*
        $dAm = $am::where('disbursement_id','=',$id)->delete();
        $dLoans = $loans::where('disbursement_id','=',$id)->delete();
        */


        //$amort_ids = $am::select('id')->where('disbursement_id','=',$id)->get()->toArray(); //Amortization ids
        return $am::where('disbursement_id','=',$id)->delete(); //Amortization ids
        
        dd($am::destroy($amort_ids));
        
        foreach($amort_ids as $x){
            dd($pi::where('amort_id','=',$x->id)->get()->first());
            $ps_ids[] = $pi::where('amort_id','=',$x->id)->first()->id;
        }
        dd($ps_ids);
        /*dd($pi::where('amort_id','=',$ps_ids)->get());
        $pi::find($ps_ids);
        $res = $pi->destroy();
        dd($res);
       return 'pwede bes';
        */
    /*   }else{
           return 'model error';
       }
       
       


     */  
    }
}
