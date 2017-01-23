<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Loan_Applications extends Model
{
    use SoftDeletes;
    protected $table='loan_applications';    
    protected $dates = ['deleted_at'];
    protected $fillable = 
        [
        'product_id','client_id','purpose','loan_amount','loan_term','loan_interest','loan_total',
        'weekly_amortization','weekly_cbu','co_maker_inside_cluster_id','co_maker_outside_cluster_id',
        'business_net_disposable_income','household_income','household_expense','financial_risk_assessment',
        'credit_limit','status'
        ];
    public function clientInfo(){
        return $this->belongsTo('App\Client_Information','client_id');

    }
    public function coMakerInCluster(){
        return $this->belongsTo('App\Client_Information','co_maker_inside_cluster_id');
    }
    
    public function coMakerOutsideCluster(){
        return $this->belongsTo('App\Client_Information','co_maker_outside_cluster_id');
    }

    public function product(){
        return $this->belongsTo('App\Products','product_id');
    }
    

    
    
}
