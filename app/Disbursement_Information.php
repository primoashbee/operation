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
}
