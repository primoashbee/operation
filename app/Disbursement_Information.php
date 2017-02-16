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
    /* 
    public function nextCollection(){
        $this->nCollect();
       $id = $this->id;
        
        $code = $this->clusterInfo->code;
        $first_collection = $this->first_collection_date;
        $last_collection = $this->last_collection_date;
        
        $payments = new \App\Payment_Summary;
        
        if($payments::where('disbursement_id','=',$id)->count() == 0){
            $date = new \App\Disbursement_Information;
            $date = $date::find($id);
            return $date->first_collection_date;
        }else{
        //    $payments = $payments::where('disbursement_id','=',$id)->orderBy('created_at','DESC')->first()->collection_date;
            $summary = new \App\Payment_Summary;
            if($summary::where('disbursement_id','=',$id)->count()==0){
                $amort = new \App\Amortization;                
                return $amort = $amort::where('disbursement_id','=',$id)->whereNotNull('collection_date')->first()->collection_date;
            }else{

                $paid_date = $summary::where('disbursement_id','=',$id)->orderBy('created_at','desc')->first()->collection_date;
                $amort = new \App\Amortization;
                //$amort = $amort::where('disbursement_id','=',$id)->whereNotNull('collection_date');
                //dd($amort::select('collection_date')->distinct()->count());
                //$res =  (\DB::table('weekly_amortization')->select('collection_date')->where('disbursement_id','=',1)->whereNotNull('collection_date')->distinct());
                //dd($res->first());
                $amort = $this->collectionDates();
                              
                
                //return $res->skip(1)->first()->collection_date;
                
                if($this->lastCollection() == $last_collection){
                //if('2017-08-25' == $last_collection){
                    return 'Collection Finished';
                }else{
                    //$res = $amort->where('collection_date','>','2017-08-25')->where('collection_date','<=',$last_collection);
                    $res = $amort->where('collection_date','>',$this->lastCollection())->where('collection_date','<=',$last_collection);
                    dd($res);
                    return $res->first()->collection_date;
                }
            }
        }
      



       // return $payments;
    }
    */
    public function nextCollection(){
          return  $this->collectionDates()
            ->where('collection_date','>',$this::find($this->id)->lastCollection())
            ->first()->collection_date;            
    }
    public function collectionDates(){
        $amort = new \App\Amortization;
        $amort = $amort::select('collection_date')->where('disbursement_id','=',$this->id)->whereNotNull('collection_date')->groupBy('collection_date')->orderBy('collection_date','asc')->get();
        return $amort;
    }
    public function totalPaid(){
        $di = new \App\Payment_Summary;
        return $di->where('disbursement_id','=',$this->id)->sum('amount_paid');
    }
}
