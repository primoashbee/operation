<?php 
function pera_format($string){
    return "₱ ".number_format($string); 
}
function pesos($string){
    return "₱ ".number_format(round($string,2),2);
}
function zero_peso(){
     return "₱ 0.00";
}
function destroy_session($key){
    if(\Session::has($key)){
        \Session::forget($key);
        return true;
    }else{
        return false;
    }                    
}
function session_exists($key){
     if(\Session::has($key)){
        
        return true;
    }else{
        return false;
    }   
}
function compute_credit_limit($bndi,$hi,$he){

    $credit_limit = $bndi + ($hi -$he);
    return $credit_limit; 
}
function total_cluster_loan($cluster_id){
    $cluster = new \App\Cluster_Members;
    $loans =  new \App\Loans;
    $cluster = $cluster->where('cluster_id','=',$cluster_id)->get();
    
    $total = 0;
    foreach($cluster as $x){    
        //$total=$total+ ($loans->where('client_id','=',$x->id)->get()->first()->loan_amount);
        if($loans->where('client_id','=',$x->client_id)->exists()){
            $total = $total +$loans->where('client_id','=',$x->client_id)->first()->loan_amount;
        }else{
        }
    }
    return $total;
}
function total_cluster_members($cluster_id){
    $cluster = new \App\Cluster_Members;
    $total = $cluster::where('cluster_id','=',$cluster_id)->count();
    return $total;
}
function cluster_status($cluster_id){
    $clusters = new \App\Disbursement_Information;
    $cluster = $clusters::where('cluster_id','=',$cluster_id);
    return 'ACTIVE';
}
function create_amortization($amt,$rate,$term,$weeks,$wcr,$first_collection_date){
    $class = new \App\MyClass\Loan_Computation;
    $amort = ($term*$rate)*($amt);
    $class->set($amt,$rate,$term,$weeks,$wcr,$first_collection_date);
    return $class;
}
function is_decimal( $val )
{
    return is_numeric( $val ) && floor( $val ) != $val;
}
function is_weekend($date) {
    //dd($date);
    //dd(strtotime($date));
    //$new = date('y-m-d',strtotime($date));
    //dd(date('l',strtotime($new))=='Sunday');
    if(date('l', strtotime($date)) == 'Sunday' || date('l', strtotime($date)) == 'Saturday')  {
        return true;
    } else {
        return false; 
    }

}

function day_name($date){
    return date('l', strtotime($date));
}

function add_seven_days($from){
    $daystosum = 7;
    $datesum = date('Y-m-d', strtotime($from.' + '.$daystosum.' days'));
    $day = date('l', strtotime($from.' + '.$daystosum.' days'));
    $x = date('W', strtotime($from.' + '.$daystosum.' days'));
    //return  (object) array('code'=>0,'msg'=>$datesum,'day'=>$day);
    return  $datesum;
}

function individual_total_loan($disbursement_id,$client_id){
    $loans = new \App\Loans;
    $loans = $loans::where('disbursement_id','=',$disbursement_id)->where('client_id','=',$client_id)->get()->first();
    return $loans;
}
?>