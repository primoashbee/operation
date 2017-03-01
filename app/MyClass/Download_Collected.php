<?php
namespace App\MyClass{
    Class Download_Collected{
        public $p_id; //Payment Summary ID
        public $ps_res;
        public $pi_res;
        public $errorBag;
        public $p_report;
        public function set($p_id){
            $this->p_id = $p_id;
            $ps = new \App\Payment_Summary;
            $ps = $ps::find($p_id);
            $this->ps_res = $ps; //Payment Summary
            $pi = new \App\Payment_Information;
            $pi = $pi::where('payment_summary_id','=',$p_id)->get();
            $this->pi_res = $pi;
            $this->validateInput();
            if($this->validateInput()){
                $this->generateReport();
            }
        }
        public function validateInput(){
            $errorBag=array();
            if($this->ps_res == null){
                $errorBag[]=array('msg'=>'Payment Summary not found');
            }elseif($this->pi_res == null){
                $errorBag[]=array('msg'=>'Payment Information not found');
            }
            $this->errorBag = $errorBag;
            if(count($errorBag)){
                return false;
            }else{
                return true;
            }
        }
        public function generateReport(){
            $data = array();
            $raw = $this->pi_res;

            foreach($raw as $x){
                if($x->lastWeekdue()->total_amount==null){
                    
                    $array = array('principal'=>0, 'interest'=>0, 'total_amount'=>0,'hehe'=>'12313');
                    $pastdue = (object) $array;
                   
                }else{
                    $pastdue = $x->lastWeekDue();
                }
                $data[] = array(
                    'Client Name' => $x->clientInfo()->firstname. ' '.$x->clientInfo()->lastname,
                    'Principal Past Due' => $pastdue->principal,
                    'Interest Past Due' => $pastdue->interest,
                    'Principal Due' => $x->amortizationInfo()->principal_this_week,
                    'Interest Due' => $x->amortizationInfo()->interest_this_week,
                    'Amount Due' => $x->amortizationInfo()->principal_with_interest,
                    'Total Amount Due' => $x->amortizationInfo()->principal_with_interest + $pastdue->total_amount,
                    'Principal Paid' => $x->principal_paid,
                    'Interest Paid' => $x->interest_paid,
                    'Amount Paid' => $x->amount_paid,
                    'This Week Principal Balance' => $x->week_principal_balance,
                    'This Week Interest Balance' => $x->week_interest_balance,
                    'This Week Balance' => $x->this_week_balance
                    //'Remaining Interest Balance'=>$x->
                );
            } 
            $this->p_report = $data;
        }

    }
}
?>