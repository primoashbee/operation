<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CollectionController extends Controller
{
    public function index(){
        
        $clusters = new \App\Disbursement_Information;
        $clusters = $clusters->activeForCollection();
        $settings = new \App\MyClass\Settings;
        
        $today = $settings->date->toDateString();
        return view('pages.view-loans-for-collection',['clusters'=>$clusters,'today'=>$today]);
    }
    public function collectedIndex(){
        $summaries = new \App\Payment_Summary;
        $summaries = $summaries::orderBy('collection_date','desc')->get();
     
        return view('pages.view-collected-summaries',['summaries'=>$summaries]);
    }
    public function viewCollected($id){
        $collected = new \App\Payment_Information;
        $collected = $collected::where('payment_summary_id','=',$id)->get();
        if(!$collected->count()> 0){
            return 'INVALID';
        }
        foreach($collected as $key => $value ){
            dd(array_keys((array)$value));

            $key = array_keys((array)$value);
            echo $key[0].'<br>';
            //echo dd($value).'<br>';
        }
    }
    public function getCollectionValues($id,$date){
        
        $cluster = new \App\Disbursement_Information;
        if($cluster::find($id)==null){
            return redirect('/Loans/Collection');
        }
        $due = $cluster::find($id)->getCollectionThisDaySet($date);
        
        $due = new \App\Amortization;
        $due = $due->todayCollectionByIdAndDate($id,$date);
        
        $loans = new \App\Disbursement_Information;
        $loans = $loans::find($id);
        return view('pages.collect-from-cluster',['loans'=>$loans,'due'=>$due,'date'=>$date,'dibursement_id'=>$id]);
    }
    public function readCollectionValues($id,$date,Request $request){
        destroy_session('readFile');
        destroy_session('sheet_name');
        $cluster = new \App\Disbursement_Information;
      
        $due = $cluster::find($id)->getCollectionThisDaySet($date);
        $due = new \App\Amortization;
        $due = $due->todayCollectionByIdAndDate($id,$date);
        $collection = '';
       
        if(!env('dev_mode')){
            if($date != \Carbon\Carbon::now()->toDateString()){
                $validator = ['Invalid Date'];
                return redirect()->back()->withErrors($validator);
            }
        }
            $rules = ['fileUpload'=>'mimes:xlsx,xls | required'];
            $msg = ['fileUpload.mimes'=>'Invalid File Type(.xlxs only)','fileUpload.required'=>'File upload is required'];
           
            $validator = \Validator::make($request->all(),$rules,$msg);
            if($validator->fails()){
                
                foreach ($validator->errors()->all() as $error){
                     return redirect()->back()->withErrors($validator)->withInput();
                }
                 
                
            }else{
                $isError = false;
                $file = $request->fileUpload->getRealPath();
                $load =\Excel::load($file,function($reader){
                        $sheetName = $reader->getSheetNames(0)[0];
                        \Session::put('sheet_name',$reader->getSheetNames(0)[0]);          
                })->toObject();
                
                //dd($sheetName);
                $readFile = new \App\MyClass\Collection_Upload;
                //dd($load{0}->titles);
                $readFile->get($load{0},\Session::get('sheet_name')); //Load only Sheet 1
                
                //dd($readFile->errorBag);
                if($readFile->hasErrors){    
                    return \Redirect::back()
                    ->withInput($request->all())
                    ->with('data',$readFile->errorBag);
                }
               
                
            }
     
        \Session::put('readFile',$readFile);
        
        return view('pages.collect-from-cluster',['due'=>$due,'date'=>$date,'dibursement_id'=>$id,'readFile'=>$readFile,'passed'=>true]);
        //dd($request->all());
    }
    public function saveCollectionValues($id,$date){
        $isValid = true;

         if(session_exists('readFile')){
             //instant of collection_upload class
             $obj = \Session::get('readFile');
             
             $isDateValid = [];
             foreach($obj->collection as $key => $value){

             
                if($value->collection_date == $date){

                    $isDateValid[] = true;
                }else{
                    $isDateValid[] = false;
                }
            }
            
            if(in_array(false,$isDateValid)){
                echo 'Date Error. Please go back to upload of collections. Thank You. <br>';
                echo 'Click <a href="'.url()->previous().'">Here</a> ';
                $isValid=false;
            }
         }else{
                $isValid=false;
                //echo 'File Error. Please go back to uploading of collections. Thank You';
                \Session::flash('failmsg','File Error! Please go back to uploading of collections. Thank You');
                return back();
         }
         if($isValid){
            
             if($obj->save()){
                
                \Session::flash('goodmsg','Collection Updated!');
                 return back();
             }else{
                 \Session::flash('failmsg','Server Error!');
                return back();
             }
         }
    }
    public function createAmortScheduling($amt){
        $products = new \App\Products;
        $products = $products->first();
        $loan_amount =$amt;
        $term  = $products->loan_term;
        $rate = $products->interest_rate;
        $weeks_to_pay=$products->weeks_to_pay;
        $wcr=$products->weekly_compounding_rate;
        $data =  create_amortization($loan_amount,$rate,$term,$weeks_to_pay,$wcr,date('Y-m-d'));
        
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
    public function getCollectionThisDay($disbursement_id){
        
        $amortization = new \App\Amortization;
        $date = \Request::get('collection_date');

        $collection = $amortization::where('disbursement_id','=',$disbursement_id)->where('collection_date','=',$date)->get();
        
        $loans = new \App\Disbursement_Information;
        $loans = $loans::find($disbursement_id);
        $collections = $amortization->getProjectedPaid($disbursement_id,$date);
        $tp=0;
        $ti=0;
        $i_balance=0;
        $p_balance=0;
        
        foreach($collections as $x){
            $tp+=$x->principal_this_week;
            $ti+=$x->interest_this_week;
            $i_balance+=$x->interest_balance;
            $p_balance+=$x->principal_balance;
        }
        $projected = new \App\MyClass\Projected_Collection;
        
        $projected->set($tp,$ti,$p_balance,$i_balance,$loans->loan_amount);
        
        return view('pages.view-cluster-collection-per-day',['data'=>$collection,'loans'=>$loans,'projected'=>$projected,'disbursement_id'=>$disbursement_id]);
    }
    public function postCollectionValues(Request $request){
         $rules = ['fileUpload'=>'mimes:xlsx,xls | required'];
            $msg = ['fileUpload.mimes'=>'Invalid File Type(.xlxs only)','fileUpload.required'=>'File upload is required'];

            $validator = \Validator::make($request->all(),$rules,$msg);
            if($validator->fails()){
                  return redirect()->back()->withErrors($validator)->withInput();
            }
         
    }
    public function readCollection(Request $request){
            
            $rules = ['fileUpload'=>'mimes:xlsx,xls | required'];
            $msg = ['fileUpload.mimes'=>'Invalid File Type(.xlsx only)','fileUpload.required'=>'File upload is required'];
        
            $validator = \Validator::make($request->all(),$rules,$msg);


         
            if($validator->fails()){
                return response()->json($validator);
            }else{
                echo 'good';
                return response()->json(['code'=>'good']);
            }
    }
}
