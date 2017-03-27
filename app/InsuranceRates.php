<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InsuranceRates extends Model
{
    protected $table='mi_dependent_information';
    protected $fillables = [
        'description',
        'term',
        'member_payment',
        'spouse_payment',
        'child_payment',
        'parent_paymet',
        'sibling_payment',
        'total',
        'mi_fee',
        'total_mi_fee',
    ];
    protected $dates = [
        'created_at',
        'updated_at'
    ];
}
