<?php
namespace App\MyClass{
    Class Collection_Upload {
        public $collection;
        public $cluster_code;
        public $collection_date;
        public $disbursement_id;
        public $amount_paid; //actual
        public $expected_amount; //projected
        public $interest_amount; //actual interset
        public $principal_amount; //actual principal
        public $principal_not_collected; //principal not collected
        public $interest_not_collected; //interest not collected
        public $uploader_id;
        public $required = [
            'amort_id',
            'amount_paid'
            ];
        public $errorBag = [];
        public $hasErrors=false;
        public $isFullyPaid=true;
        public $past_due_amount;
        public $cbuValues;

        public $interest_due;
        public $public_due;
        public $total_due;
        public function get($obj,$sheetname){
            
            //dd($obj{0}->getSheetName());
            $cbu = new \App\CBU;
           
            $cbu->get($obj);
            
            $this->cbuValues = $cbu->cbuValues();
            
            //dd($cbu->get($obj));
            $this->collection = $obj;
            
            $this->disbursement_id = $sheetname;
            $this->uploader_id = 1;
            
            $this->computeData($obj);
           
            $this->validateData($obj);
            
        }
        public function validateData($obj){
            $errorBag = $this->errorBag;
            $currentRow = 2; //because index row of excel is 1; so 1+1 =2 to get first row with record
           
            $collections = new \App\Payment_Summary;
            $settings = new \App\MyClass\Settings;
            $pfs = new \App\Payment_Information;
            foreach($obj as $row){
                
                if($row->amort_id == '' || $row->amort_id === null){
                    //ammortization id is missing
                    $errorBag[] = (object) array('msg'=> 'amort_id is missing for Client: '.$row->client_name.' (See Row: '.$currentRow.' | Redownload CCR and see Instructions (Sheet 2))' );
                }elseif(!is_numeric($row->amort_id)){
                    //amortization id is not a number
                    $errorBag[] = (object) array('msg'=> 'amort_id is invalid for Client: '.$row->client_name.' (See Row: '.$currentRow.' | Redownload CCR and see Instructions (Sheet 2))' );
                }elseif($row->amount_paid > $row->total_amount_due){
                 //amount paid > amount due
                    $errorBag[] = (object) array('msg'=> 'AMOUNT PAID ('.pesos($row->amount_paid).') greater than the amount_due ('.pesos($row->principal_with_interest).') for Client: '.$row->client_name.' (See Row: '.$currentRow.')');
                }elseif($row->amount_paid===null){
                    //amount paid is blank
                    $errorBag[] = (object) array('msg'=>'AMOUNT PAID should be provided for Client: '.$row->client_name.' (See Row: '.$currentRow.' If no payment encode "0")' );
                }elseif(!is_numeric($row->amount_paid)){
                    //amount paid is blank
                    if(!is_int($amt)){
                        $errorBag[] = (object) array('msg'=>'AMOUNT PAID should be numeric for Client: '.$row->client_name.' (See Row: '.$currentRow.' )');  
                    }   
                //}elseif(($row->cbu!==null && $row->cbu != 0 ) || $row->cbu < 50){
                }elseif(is_numeric($row->amount_paid)){
                    $amt  = (int) $row->amount_paid;
                    if($amt < 0){
                        
                        $errorBag[] = (object) array('msg'=>'AMOUNT PAID should positive for Client: '.$row->client_name.' (See Row: '.$currentRow.' )');  
                        
                    }
                 
                }elseif(($row->cbu!==null && $row->cbu!=0 && $row->cbu < 50)){
                    
                    //amount paid is blank
                    $errorBag[] = (object) array('msg'=>'CBU has a minimum of '.pesos(50).' for Client: '.$row->client_name.' (See Row: '.$currentRow.' )');
                }elseif($row->cbu===null){
                    //amount paid is blank
                    $errorBag[] = (object) array('msg'=>'If there no CBU for this week. Please encode "0" instead for Client: '.$row->client_name.' (See Row: '.$currentRow.' )');
               /* }elseif($row->collection_date != $settings->date->toDateString()){
                    $errorBag[] = (object) array('msg'=>'CCR Error to corresponding date. Collection for this cluster is :'.$row->collection_date.' vs today\'s  date is: '.$settings->date->toDateString());
                */
                }elseif($collections::where('disbursement_id','=',$this->disbursement_id)->where('collection_date','=',$row->collection_date)->count() > 0){
                    $errorBag[] = (object) array('msg'=>'Already uploaded collection for this day');
                }elseif($collections::where('disbursement_id','=',$this->disbursement_id)->count()==0){
                //no skip computePayments
                    $d_info = new \App\Disbursement_Information;
                    $f_date = $d_info::find($this->disbursement_id)->first_collection_date;
                    if($this->collection{0}->collection_date != $f_date){
                        $errorBag[] = (object) array('msg'=>'No skipping on CCR uploading. Collection for '.$f_date.' is missing');
                    }
                }elseif($collections::where('disbursement_id','=',$this->disbursement_id)->count()>0){
                //no skip computePayments
                    $ps = new \App\Disbursement_Information;
                    //$ps = $ps::where('disbursement_id','=',$this->disbursement_id)->first();
                    $nextCollection = $ps::find($this->disbursement_id)->nextCollection();
                    
                    if($this->collection{0}->collection_date != $nextCollection){
                        $errorBag[] = (object) array('msg'=>'No skipping on CCR uploading. Collection due date is '.$nextCollection);
                    }
                    
                }

                $currentRow++;
              
            }
            //dd($collections::first()->collection_date);
            $this->errorBag = $errorBag;
            if(count($this->errorBag)>0){
                $this->hasErrors =true;
            }
          
        }

        public function computeData($obj){
            $count = $obj->count();
            for($x=0; $x<=$count-1;$x++){
                $interest_percentage = (($obj{$x}->interest_this_week + $obj{$x}->past_due_interest)/ $obj{$x}->total_amount_due);
                $interest = round( $interest_percentage * $obj{$x}->amount_paid);
                $principal = 0;
                
                if(!$interest==0){
                    $principal = $obj{$x}->amount_paid - $interest;
                }       
                
                $this_week_balance =  $obj{$x}->total_amount_due - $obj{$x}->amount_paid;
                $week_interest_balance = round($interest_percentage * $this_week_balance);
                $week_principal_balance = $this_week_balance - $week_interest_balance;
                
                $obj{$x}= array_add($obj{$x},'principal_paid',$principal);
                $obj{$x}= array_add($obj{$x},'interest_paid',$interest);
                $obj{$x}= array_add($obj{$x},'this_week_balance',$this_week_balance);
                $obj{$x}= array_add($obj{$x},'week_interest_balance',$week_interest_balance);
                $obj{$x}= array_add($obj{$x},'week_principal_balance',$week_principal_balance);
                    
            }
            $this->collection = $obj;
            
        }
        public function save(){
             
            \DB::beginTransaction();
            try{
                    $di = new \App\Disbursement_Information;
                    $di = $di::find($this->disbursement_id);
                    if($di->collectionDates()->last()->collection_date==$this->collection{0}->collection_date){
                       
                        //Check if collection_date uploaded will match disbursement last collection date
                        $di->status = "finished";
                        $di->is_finished = true;
                        $di->save();

                        
                        $fi = new \App\Finished_Disbursement;
                        $fi->disbursement_id = $this->disbursement_id;
                        $fi->is_fully_paid = false;
                        $fi->finished = true;
                        $fi->comments= false;
                        $fi->save();    
                    }
            
                    $this->collection_date = $this->collection{0}->collection_date;
                  
                    $this->computePayments();
                    $past_due = new \App\Past_Due;
                    $past_due->get($this);
                    $payment_summary = new \App\Payment_Summary;
                   
                 
                    $payment_summary->disbursement_id = $this->disbursement_id;
                    
                    $payment_summary->collection_date = $this->collection_date;
                    $payment_summary->amount_paid = $this->amount_paid;
                    $payment_summary->uploader_id = \Auth::user()->id;
                    $payment_summary->principal_not_collected = $this->principal_not_collected;
                    $payment_summary->interest_not_collected = $this->interest_not_collected;
                    //$payment_summary->interest_amount_due = $this->interest_due;
                    //$payment_summary->principal_amount_due = $this->principal_due
                    //dd($this);
                    $payment_summary->this_week_due = $this->expected_amount;
                    $payment_summary->this_week_total_amount_due = $this->expected_amount + $past_due->total_due;
                    $payment_summary->last_week_past_due= $past_due->total_due;
                    
                    $payment_summary->isFullyPaid = $this->isFullyPaid; 
                  
                    $past_due->insert($past_due->insertValues);
                    $payment_summary->save();
                    $p_id = $payment_summary->id;                    
                    /*$ps_array = array('disbursement_id'=>1,
                                'collection_date'=>1,
                                'amount_paid'=>1,
                                'principal_not_collected'=>1,
                                'interest_not_collected'=>1,
                                'uploader_id'=>1,
                                'isFullyPaid'=>1
                                );
                    */
                   
                      
                    foreach($this->collection as $key => $value){
                        
                        $paymentSummaries[] = array(
                            'payment_summary_id' => $p_id, 
                            'amort_id' => $value->amort_id, 
                            'amount_paid' => $value->amount_paid, 
                            'principal_paid' => $value->principal_paid, 
                            'interest_paid' => $value->interest_paid, 
                            'this_week_balance' => $value->this_week_balance, 
                            'week_interest_balance' => $value->week_interest_balance, 
                            'week_principal_balance' => $value->week_principal_balance,
                            'payment_type'=>env('payment_type')
                        ); 
                    }
                    
                    $payment_informations = new \App\Payment_Information;
                 
                    if($payment_informations->insert($paymentSummaries)){
                        $cbu = new \App\CBU;    
                        $cbu->insert($this->cbuValues);
                        
  
                        destroy_session('readFile');
                        \DB::commit();
                        return true;
                        
                    }else{
                        return false;
                    }  
            }catch(Exception $e){
                \DB::rollback();
                return false;
            }
            return false;
            
          
        }
        public function computePayments(){
            
            //dd($this->collection);
            $total_paid=0;
            $interest_paid=0;
            $principal_paid=0;
            $interest_due=0;
            $principal_due=0;
            $total_due=0;
            $interest_not_collected=0;
            $principal_not_collected=0;
            $expected_amount = 0;
           
            foreach($this->collection as $k => $v){
                $total_paid+=$v->amount_paid;
                $interest_paid+=$v->interest_paid;
                $principal_paid+=$v->principal_paid;
                $interest_not_collected+=$v->week_interest_balance;
                $principal_not_collected+=$v->week_principal_balance;
                $expected_amount+=$v->principal_with_interest;
                $interest_due+=$v->week_interest_balance;
                $principal_due+=$v->week_principal_balance;
                $total_due=0;
            }
                $this->amount_paid = $total_paid;
                $this->expected_amount = $expected_amount;

                $this->interest_amount = $interest_paid;
                $this->principal_amount = $principal_paid; 
                
                $this->interest_due = $interest_due;
                $this->principal_due = $principal_due; 
                $this->total_due = $interest_due + $principal_due;
                
                
                $this->principal_not_collected = $principal_not_collected; 
                $this->interest_not_collected = $interest_not_collected; 
            if(!($this->principal_not_collected == 0 && $this->interest_not_collected == 0)){
                
                $this->isFullyPaid=false;               
            }
              
        }
    }
}
?>