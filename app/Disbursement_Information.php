<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Disbursement_Information extends Model
{
    use SoftDeletes;
    protected $table = 'disbursement';
    protected $fillable = [ 
        'cv_number',
        'payee_id',
        'loan_amount',
        'check_number',
        'release_date',
        'first_collection_date',
        'last_collection_date',
        'maturity_date',
        'cluster_id',
        'status',
        'is_finished',
    ];
    protected $dates = [
        'created_at',
        'updated_at',	
        'deleted_at'
    ];
    
   
    public function clusterInfo(){
        return $this->belongsTo('App\Cluster_Information','cluster_id');
    }
    public function payeeName(){
        return $this->belongsTo('App\Client_Information','payee_id');
    }
    public function loans(){
        return $this->hasMany('App\Loans','disbursement_id');
    }
    public function activeForCollection(){

        //return \DB::select('select * from branches= ?', [1]);
        return $this->where('status','=','on-going')->get();    
        
    }
    public function getCollectionDates($disbursement_id){
        $amort = new \App\Amortization;
        
        $amort = $amort::distinct()->where('disbursement_id','=',$disbursement_id)->whereNotNull('collection_date')->orderBy('collection_date','asc')->get(['collection_date']);
        if($amort==null){
            return false;
        }
        return $amort;
    }
    public function getCollectionThisDay(){
        $now = \Carbon\Carbon::now();
        $today = $now->year .'-'.$now->month.'-'.$now->day;
       
        return $this->hasMany('App\Amortization','disbursement_id')->where('collection_date','=',$today)->get();
    }
    public function getCollectionThisDaySet($today){
     
        // $now = \Carbon\Carbon::now();
        // $today = $now->year .'-'.$now->month.'-'.$now->day;
        
        return $this->hasMany('App\Amortization','disbursement_id')->where('collection_date','=',$today)->get();
    }
    public function getLoanSummary($client_id){
        //return $this->hasOne('App\Loans','disbursement_id')->where('disbursement_id','=',$disbursement_id)->where('client_id','=',$client_id);
        return $this->hasOne('App\Loans','disbursement_id')->where('client_id','=',$client_id)->get();
    }
    public function lastCollection(){
        $this->collectionDates();
        
        $id = $this->id;
        $code = $this->clusterInfo->code;
        $first_collection = $this->first_collection_date;
        
        $payments = new \App\Payment_Summary;
        if($payments::where('disbursement_id','=',$id)->count() == 0){
            return  'None';
        }else{
            return $payments::where('disbursement_id','=',$id)->orderBy('created_at','DESC')->first()->collection_date;
        }
    }
    public function nextCollection(){
        if($this->cycleEnd()){
                return 'Collection Ended';
         }

        if($this->lastCollection()=="None"){
            
            return $this->first_collection_date;
        }else{
          return  $this->collectionDates()
            ->where('collection_date','>',$this::find($this->id)->lastCollection())
            ->first()->collection_date;
        }            
    }
    public function collectionDates(){
        $amort = new \App\Amortization;
        $amort = $amort::select('collection_date')->where('disbursement_id','=',$this->id)->whereNotNull('collection_date')->groupBy('collection_date')->orderBy('collection_date','asc')->get();
        return $amort;
    }
    public function totalPaid(){
        $ps = new \App\Payment_Summary;
        return $ps->where('disbursement_id','=',$this->id)->sum('amount_paid');
    }
   
    public function collectionIsPaid($collection_date){
        $ps = new \App\Payment_Summary;
        if($ps->where('disbursement_id','=',$this->id)->where('collection_date','=',$collection_date)->count() > 0){
            return true;
        }else{
            return false;
        }
    }
    public function cbuCollected(){
        $cbu = new \App\CBU;
        
        $cbu = $cbu::where('disbursement_id','=',$this->id)->get();
        $cbu = $cbu->sum('amount');
        return $cbu;
    }
    
    public function cycleEnd(){
        $fd = new \App\Finished_Disbursement;
        if($fd::where('disbursement_id','=',$this->id)->count() > 0 ){
            return true;
        }else{
            return false;
        }
    }
    public function isInBranch(){
        
        if($this->clusterInfo->branch_id == \Auth::user()->branch_code){
            return true;
        }
        return false;
    }
    public function lastCollectionDate(){
        return $this->collectionDates()->last();
    }
    public function hasStartedCollecting(){
        $ps = new \App\Payment_Summary;
        if($ps::where('disbursement_id','=',$this->id)->count() > 0 ){
            return true;
        }   
        return false;
    }
    public function branchCode(){
        return $this->clusterInfo->branch_id;
    }
}
