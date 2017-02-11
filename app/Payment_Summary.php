<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment_Summary extends Model
{
    protected $table = 'payment_summaries';

    protected $fillable = [
        'disbursement_id',
        'collection_date',
        'amount_paid',
        'principal_not_collected',
        'interest_not_collected',
        'uploader_id',
        //'interest_amount_due',
       // 'principal_amount_due',
        'total_amount_due',
        'isFullyPaid',
    ];
    protected $dates = ['created_at','updated_at'];

    public function getBreakdown(){
        return $this->hasMany('App\Payment_Informations','amort_id');
    }
    public function getDisbursement(){
        return $this->belongsTo('App\Disbursement_Information','disbursement_id');
    }
}
