<?php 
function money_format($string){
    return "₱ ".number_format($string,2); 
}
function compute_credit_limit($bndi,$hi,$he){

    $credit_limit = $bndi + ($hi -$he);
    return $credit_limit; 
}
function total_cluster_loan($cluster_id){
    $cluster = new \App\Cluster_Members;
    $loans =  new \App\Loan_Applications;
    $cluster = $cluster->where('cluster_id','=',$cluster_id)->get();
    $total = 0;
    foreach($cluster as $x){    
        //$total=$total+ ($loans->where('client_id','=',$x->id)->get()->first()->loan_amount);
        if($loans->where('client_id','=',$x->id)->exists()){
            $total = $total +$loans->where('client_id','=',1)->first()->loan_amount;
        }else{
        }
    }
    return $total;
}
?>