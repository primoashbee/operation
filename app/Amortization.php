<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Amortization extends Model
{
    protected $table= 'weekly_amortizations';

    protected $fillable = [
        'disbursement_id',
        'client_id',
        'week',
        'principal_this_week',
        'interest_this_week',
        'principal_with_interest',
        'principal_balance',
        'interest_balance'
    ];
    public function clientInfo(){
        return $this->belongsTo('App\Client_Information','client_id');
    }
    public function disbursementInfo(){
        return $this->belongsTo('App\Disbursement_Information','disbursement_id');
    }
}
