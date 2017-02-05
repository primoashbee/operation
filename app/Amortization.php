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
        foreach($amortz as $x){
            $return[] = array(
                'amort_id'=>$x->id,
                'client_name'=>$x->clientInfo->firstname.' '.$x->clientInfo->lastname,
                'principal_this_week'=>$x->principal_this_week,
                'interest_this_week'=>$x->interest_this_week,
                'principal_with_interest'=>$x->principal_with_interest,
                'principal_balance'=>$x->principal_balance,
                'interest_balance'=>$x->interest_balance,
                'collection_date'=>$x->collection_date
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
}
