<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Credit_Limit extends Model
{
    use SoftDeletes;
    protected $table = 'credit_limit';
    protected $fillable =[
        'co_maker_inside_cluster_id',
        'co_maker_outside_cluster_id',
        'business_net_disposable_income',
        'household_income',
        'household_expense',
        'financial_risk_assessment',
       
    ];
    protected $dates = [
         'deleted_at',
        'created_at',
        'updated_at'
    ];
  
    public function name(){
        return $this->hasOne('App\Client_Information','client_id');
    }
    public function coMakerInside(){
        return $this->belongsTo('App\Client_Information','co_maker_inside_cluster_id');
    }
    public function coMakerOutside(){
        return $this->belongsTo('App\Client_Information','co_maker_outside_cluster_id');
    }
}
