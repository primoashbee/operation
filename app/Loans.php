<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Loans extends Model
{
    use SoftDeletes;
    protected $table='loan_summaries';
    protected $fillable = [
        'disbursement_id',
        'client_id',
        'loan_amount',
        'loan_term',
        'cbu_new',
        'cbu_reloan',
        'processing_fee',
        'doc_stamp_tax',
        'mi_premium',
        'cli_premium',
        'total_pre_deductions',
        'total_loan_amount',
        'status',
        'is_payed',
    ];
    protected $dates = [
        'deleted_at',
        'created_at',
        'updated_at'
    ];

    public function clientInfo(){
        return $this->belongsTo('App\Client_Information','client_id');
    }

    public function isOnGoing(){
        if($this->status=="on-going"){
            return true;
        }else{
            return false;
        }
    }
    public function status(){
        return $this->status;
    }
}
