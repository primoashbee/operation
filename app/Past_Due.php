<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Past_Due extends Model
{
    protected $table='past_dues';
    protected $fillable = [ 
        'amort_id',
        'disbursement_id',
        'client_id',
        'principal',
        'interest',
        'total_amount',
        'week_to_be_paid',
        'to_be_collected_on'
    ];
    public $data;
    public $insertValues;
    public $total_due;
    public function get($obj){
        $this->data = $obj;
        $this->disbursement_id = $obj->disbursement_id;
            
        $this->pastDueValues();
    }
    public function pastDueValues(){
        $insertValues=array();
        $total_due = 0;
        foreach($this->data->collection as $key=>$value){
            if(!$this->isOnLastWeek($value->amort_id)){
                $insertValues[]=array(
                    'amort_id' => $value->amort_id,
                    'disbursement_id' => $this->disbursement_id,
                    'client_id' => $value->client_id,
                    'principal' => $value->week_principal_balance,
                    'interest' => $value->week_interest_balance,
                    'total_amount' => $value->this_week_balance,
                    'week_to_be_paid' => $value->week + 1,
                    'to_be_collected_on' => $this->topUpOn($value->amort_id)
                );
            $total_due=$total_due+$value->past_due;
            }else{
                //Insert to remaining balances outside loan_cycle
               
            }
        }
        $this->total_due = $total_due;
        $this->insertValues = $insertValues; 
        return $insertValues;
       
    }
    public function isOnLastWeek($amort_id){
        $amort = new \App\Amortization;
        $amort = $amort::find($amort_id);
        $week_count = $amort::where('client_id','=',$amort->client_id)->where('disbursement_id','=',$this->disbursement_id)->whereNotNull('collection_date')->count();
        if($week_count==$amort->week){
            return true;
        }else{
            return false;
        }
    }
    public function topUpOn($amort_id){
        $amort = new \App\Amortization;
        $amort = $amort::find($amort_id);
        return add_seven_days($amort->collection_date);
    }
}   
