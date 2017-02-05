<?php
namespace App\MyClass{
    Class Collection_Upload {
        public $collection;
        public $cluster_code;
        public $collection_date;
        public $amount_paid; //actual
        public $expected_amount; //projected
        public $interest_amount; //actual interset
        public $principal_amount; //actual principal
        public $principal_not_collected; //principal not collected
        public $interest_not_collected; //interest not collected
        public $required = [
            'amort_id',
            'amount_paid'
            ];
        public $errorBag = [];
        public $hasErrors=false;
        public $isFullyPaid=true;
        public $past_due_amount;
        public function get($obj,$sheetname){
            //dd($obj{0}->getSheetName());

            $this->collection = $obj;
            $this->cluster_code = $sheetname;
            $this->computeData($obj);
            $this->validateData($obj);
            
            
        }
        public function validateData($obj){
            $errorBag = $this->errorBag;
            $currentRow = 2; //because index row of excel is 1; so 1+1 =2 to get first row with record
            foreach($obj as $row){
                
                if($row->amort_id == '' || $row->amort_id === null){
                    //ammortization id is missing
                    $errorBag[] = (object) array('msg'=> 'amort_id is missing for Client: '.$row->client_name.' (See Row: '.$currentRow.' | Redownload CCR and see Instructions (Sheet 2))' );
                }elseif(!is_numeric($row->amort_id)){
                    //amortization id is not a number
                    $errorBag[] = (object) array('msg'=> 'amort_id is invalid for Client: '.$row->client_name.' (See Row: '.$currentRow.' | Redownload CCR and see Instructions (Sheet 2))' );
                }elseif($row->amount_paid > $row->principal_with_interest){
                 //amount paid > amount due
                    $errorBag[] = (object) array('msg'=> 'AMOUNT PAID ('.pesos($row->amount_paid).') greater than the amount_due ('.pesos($row->principal_with_interest).') for Client: '.$row->client_name.' (See Row: '.$currentRow.')');
                }elseif($row->amount_paid===null){
                    //amount paid is blank
                    $errorBag[] = (object) array('msg'=>'AMOUNT PAID should be provided for Client: '.$row->client_name.' (See Row: '.$currentRow.' If no payment encode "0")' );
                }elseif(!is_numeric($row->amount_paid)){
                    //amount paid is blank
                    $errorBag[] = (object) array('msg'=>'AMOUNT PAID should be numeric for Client: '.$row->client_name.' (See Row: '.$currentRow.' )');  
                }elseif($row->cbu!==null && $row->cbu < 50){
                    //amount paid is blank
                    $errorBag[] = (object) array('msg'=>'CBU has a minimum of '.pesos(50).' for Client: '.$row->client_name.' (See Row: '.$currentRow.' )');
                }   

                $currentRow++;
              
            }
            $this->errorBag = $errorBag;
            if(count($this->errorBag)>0){
                $this->hasErrors =true;
            }
        }

        public function computeData($obj){-
            $count = $obj->count();
            for($x=0; $x<=$count-1;$x++){
                if($obj{$x}->amount_paid==$obj{$x}->principal_with_interest){
                    $interest = round(($obj{$x}->interest_this_week/ $obj{$x}->principal_with_interest) * $obj{$x}->amount_paid);
                    $principal = $obj{$x}->principal_with_interest - $interest;
                    $obj{$x}= array_add($obj{$x},'principal_paid',$principal);
                    $obj{$x}= array_add($obj{$x},'interest_paid',$interest);
                    $obj{$x}= array_add($obj{$x},'this_week_balance',$obj{$x}->principal_with_interest - $obj{$x}->amount_paid);
                    $obj{$x}= array_add($obj{$x},'week_interest_balance',$obj{$x}->interest_this_week - $interest);
                    $obj{$x}= array_add($obj{$x},'week_principal_balance',$obj{$x}->principal_this_week - $principal);

                }elseif($obj{$x}->amount_paid!=$obj{$x}->principal_with_interest){
                    $interest = round(($obj{$x}->interest_this_week/ $obj{$x}->principal_with_interest) * $obj{$x}->amount_paid);
                    
                    $principal = $obj{$x}->amount_paid - $interest;
                    
                    $obj{$x}= array_add($obj{$x},'principal_paid',$principal);
                    $obj{$x}= array_add($obj{$x},'interest_paid',$interest);
                    $obj{$x}= array_add($obj{$x},'this_week_balance',$obj{$x}->principal_with_interest - $obj{$x}->amount_paid);
                    $obj{$x}= array_add($obj{$x},'week_interest_balance',$obj{$x}->interest_this_week - $interest);
                    $obj{$x}= array_add($obj{$x},'week_principal_balance',$obj{$x}->principal_this_week - $principal);

                }
            }
           
            $this->collection = $obj;
        }
        public function save(){
            
            $this->collection_date = $this->collection{0}->collection_date;
            $this->computePayments();
            $paymentSummaries = array(
                'cluster_code'=>$this->cluster_code,
                'collection_date'=>$this->collection_date,
                'amount_paid'=>$this->amount_paid,
                'uploader_id'=>1
            );
           // dd($paymentSummaries);
            foreach($this->collection as $key => $value){
               
                $paymentSummaries[] = array($key => $value->$key); 
            }
            dd($this);
        }
        public function computePayments(){
            
            //dd($this->collection);
            $total_paid=0;
            $interest_paid=0;
            $principal_paid=0;
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
            }
                $this->amount_paid = $total_paid;
                $this->expected_amount = $expected_amount;
                $this->interest_amount = $interest_paid;
                $this->principal_amount = $principal_paid; 

                $this->principal_not_collected = $principal_not_collected; 
                $this->interest_not_collected = $interest_not_collected; 
            if(!($this->principal_not_collected == 0 && $this->interest_not_collected == 0)){
                
                $this->isFullyPaid=false;               
            }
              
        }
    }
}
?>