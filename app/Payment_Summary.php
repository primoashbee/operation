<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment_Summary extends Model
{
    protected $table = 'payment_summaries';

    protected $fillables = ['cluster_code','collection_date','amount_paid','uploader_id'];
    protected $dates = ['created_at','updated_at'];

    public function getPayments(){
        return $this->hasMany('App\Payment_Informations','amort_id');
    }
}
