<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CalendarYear extends Model
{
    protected $table='yearly_calendar';
    protected $fillables = ['holiday','holiday_date','day','type','year','is_weekend'];
    protected $dates = ['created_at','updated_at'];
    public function checkHitDates($input){
        $start_date = $input['start_date']->toDateString();
        $end_date= $input['end_date']->toDateString();
        $day = $input['day'];
        
        return $this->whereBetween('holiday_date',[$start_date,$end_date])->where('day','=',$day)->where('is_weekend','=',false)->get(['holiday','holiday_date','day','type','year','is_weekend']);
    }
    public function computeMaturity(){

    }
}
