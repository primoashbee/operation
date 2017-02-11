<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CBU extends Model
{
    public $data;
    public $inserts;
    public $timestamps = false;
    protected $table='capital_build_ups';
    protected $fillable = ['amort_id','disbursement_id','amount','transaction_type'];
    
    public function get($obj){
        
        $this->data = $obj;
        $this->cbuValues();
        
    }
    public function cbuValues(){
        $obj = $this->data;
        $data = array();
        //amort date,disbursement_id,client_id,amount
        
        foreach($obj as $key => $value){
            $data[]=array(
                //'amort_id'=>intval($value->amort_id),
                'amort_id'=>$value->amort_id,
                'disbursement_id'=>$this->getDisbursementId($value->amort_id),
                'client_id'=>$value->client_id,
                'amount'=>$value->cbu,
                'transaction_type'=>'deposit'
            );
        }
        
        $this->inserts=$data;
    
        return $data;
    }
    public function getDisbursementId($amort_id){
        $amort = new \App\Amortization;
        $amort = $amort::find($amort_id);
        return $amort->disbursement_id;
    }
}
