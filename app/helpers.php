<?php 
function money_format($string){
    return "₱ ".number_format($string); 
}
function pesos($string){
    return "₱ ".number_format(round($string,2),2);
}
function zero_peso(){
     return "₱ 0.00";
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
function create_amortization($amt,$rate,$term,$weeks,$wcr){
    $class = new \App\MyClass\Loan_Computation;
    $amort = ($term*$rate)*($amt);
    $class->set($amt,$rate,$term,$weeks,$wcr);
    return $class;
}

function is_decimal( $val )
{
    return is_numeric( $val ) && floor( $val ) != $val;
}

?>