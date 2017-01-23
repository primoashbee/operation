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
}
