<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Loan_Disbursement extends Model
{
    use SoftDeletes;
    protected $table = 'loan_application';
    protected $fillable =[
        'purpose',
        'loan_amount',
        'loan_term',
        'loan_interest',
        'loan_total',
        'weekly_amortization'
    ];
    protected $guarded = [
        'client_id',
        'co_maker_inside_cluster_id'
        'co_maker_outside_cluster_id'
    ]
    

}
