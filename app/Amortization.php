<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Amortization extends Model
{
    protected $table= 'weekly_amortization';

    protected $fillable = [
        'disbursement_id',
        'client_id',
        'week',
        'principal_this_week',
        'interest_this_week',
        'principal_with_interest',
        'principal_balance',
        'interest_balance',
        'collection_date'
    ];
    public function clientInfo(){
        return $this->belongsTo('App\Client_Information','client_id');
    }
    public function disbursementInfo(){
        return $this->belongsTo('App\Disbursement_Information','disbursement_id');
    }
    public function getProjectedPaid($disbursement_id,$date){
        $amortizations = $this->where('disbursement_id','=',$disbursement_id);//created collection of amortz with d_id =?
        $first_collection_date = $amortizations->where('disbursement_id','=',$disbursement_id)
                                ->where('week','=','1')
                                ->first()
                                ->collection_date;
                                //fetched first collection_date
        $amortz = $this->where('disbursement_id','=',$disbursement_id)->whereBetween('collection_date',[$first_collection_date,$date])->get();
      
        return $amortz;
    }
    public function getCollectionThisDay($disbursement_id,$date){
        $amortz = $this->where('disbursement_id','=',$disbursement_id)->where('collection_date','=',$date)->get();
      
        return $amortz;
    }
    public function todayCCR($disbursement_id,$date){
        $amortz = $this->where('disbursement_id','=',$disbursement_id)->where('collection_date','=',$date)->get();
        $return=[];
        $ctr = 0;
        foreach($amortz as $x){
            if($x->pastDue()->total_amount==null){
                $pastdue = 0;
                $p_due_interest = 0;
                $p_due_principal = 0;
            }else{
                $pastdue = $x->pastDue()->total_amount;
                $p_due_interest = $x->pastdue()->interest;
                $p_due_principal = $x->pastdue()->principal;
            }
            
            $ctr++;
            $return[] = array(
                'amort_id'=>$x->id,
                'client_id'=>$x->client_id,
                'week'=>$x->week,
                'client_name'=>$x->clientInfo->firstname.' '.$x->clientInfo->lastname,
                'principal_balance'=>$x->principal_balance+$x->pastDue()->principal,
                'interest_balance'=>$x->interest_balance+$x->pastDue()->interest,
                'collection_date'=>$x->collection_date,
                'principal_this_week'=>$x->principal_this_week,
                'interest_this_week'=>$x->interest_this_week,
                'principal_with_interest'=>$x->principal_with_interest,
                'past_due_interest' => $p_due_interest,
                'past_due_principal'=> $p_due_principal,
                'past_due'=>$pastdue,
                'total_amount_due'=>$x->principal_with_interest + $pastdue,
                'amount_paid'=>'',
                'cbu'=>''
            );
        }
        return $return;
    
    }
    public function nowCollection(){
        $now = \Carbon\Carbon::now();
        $today = $now->year .'-'.$now->month.'-'.$now->day;

        return $this->where('collection_date','=',$today)->get();
    }
    public function getLoanSummary($disbursement_id,$client_id){
        return $this->belongsTo('App\Loans','disbursement_id')->where('client_id','=',$client_id)->where('disbursement_id','=',$disbursement_id);
        //return 'hahaha';
    }
    public function func($disbursement_id,$client_id){
        //return "Disbursement id : ".$disbursement_id. "| Client ID: ".$client_id;
        //return $this->belongsTo('App\Loans','disbursement_id')->where('client_id','=',$client_id)->where('disbursement_id','=',$disbursement_id);
        return $this->belongsTo('App\Loans','disbursement_id');
        //return $this->hasManyThrough('App\Disbursement_Information','App\Loans','disbursement_id','disbursement_id');
    }
    public function todayCollectionByIdAndDate($id,$date){
        return $this->where('disbursement_id','=',$id)->where('collection_date','=',$date)->get();
    }
    public function getLoanAmount(){
        return $this->hasOne('App\Loans','disbursement_id','disbursement_id');
    }
    public function pastDue(){
        //return $this->join('past_dues','past_dues.week','=','amortization.week')->get();
        //return $this->disbursement_id;
        
        $past_due = new \App\Past_Due;
        $week = $this->week;
        //return  "Select * from past_dues where to_be_collected_on = '".add_seven_days($this->collection_date)."' and client_id = '".$this->client_id."' and week_to_be_paid ='".$week."'";
        $x = $past_due::
                where('week_to_be_paid','=',$week)
                ->where('to_be_collected_on','=',$this->collection_date)
                ->where('client_id','=',$this->client_id)
                ->where('disbursement_id','=',$this->disbursement_id);
                
        if($x->count() == 0){
            return $past_due;
        }else{
            return $x->first();
        }
    }
    public function pastDueInformation(){
        //return $this->join('past_dues','past_dues.week','=','amortization.week')->get();
        //return $this->disbursement_id;
        
        $past_due = new \App\Past_Due;
        $week = $this->week;
        //return  "Select * from past_dues where to_be_collected_on = '".add_seven_days($this->collection_date)."' and client_id = '".$this->client_id."' and week_to_be_paid ='".$week."'";
        $x = $past_due::
                where('week_to_be_paid','=',$week)
                ->where('to_be_collected_on','=',$this->collection_date)
                ->where('client_id','=',$this->client_id)
                ->where('disbursement_id','=',$this->disbursement_id);
                
        if($x->count() == 0){
            return null;
        }else{
            return $x->first();
        }
    }
}
