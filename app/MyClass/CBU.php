<?php
namespace App\MyClass {
    class CBU{
        public $data;
    
        public function get($obj){
           
            $this->data = $obj;
            $this->computeCBU($obj);
          
        }
        public function computeCBU($obj){
            $data = array();
            //amort date,disbursement_id,client_id,amount
            
            foreach($obj as $key => $value){
                $data[]=array(
                    'amort_id'=>$value->amort_id,
                    'disbursement_id'=>$this->getDisbursementId($value->amort_id),
                    'client_id'=>$value->client_id,
                    'amount'=>$value->cbu
                );
            }
            

           
        }
        public function getDisbursementId($amort_id){
            $amort = new \App\Amortization;
            $amort = $amort::find($amort_id);
            return $amort->disbursement_id;
        }

    }
}

?>