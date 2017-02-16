<?php
namespace App\MyClass{
    Class Loan_Computation {
        public $loan;
        public $rate;
        public $term;
        public $weeks;
        public $total_loan;
        public $weekly_amort;
        public $interest;
        public $interest_value;
        public $actual_interest_value;
        public $table=[];
        public $compounding_rate;
        public $total_cf;
        public $i_total;
        public $p_total;
        public $t_interest;
        public $t_princpial;
        public $first_collection_date;
        public function set($loan,$rate,$term,$weeks,$wcr,$first_collection_date){
            $this->loan = $loan;
            $this->rate = $rate;
            $this->term = $term;
            $this->weeks = $weeks;
            $this->compounding_rate = $wcr;
            $this->first_collection_date = $first_collection_date;
            $this->compute();
            $this->table();
        }

        public function compute(){

            //(rate * term)
            $this->interest = ($this->rate * $this->term);
            $this->interest_value = round($this->interest * $this->loan);
            $this->total_loan = $this->loan + (($this->interest) * $this->loan);
            $this->weekly_amort=round($this->total_loan / $this->weeks); 
        }
      
        public function table(){
            $p_balance = $this->loan;
            $i_balance = $this->interest_value;
            $compounding_rate = $this->compounding_rate;
            $p_total = 0;
            $i_total = 0;
            $cashflow = $this->weekly_amort;
            $weeks = $this->weeks;
            $date=$this->first_collection_date;
            
            for($x=0;$x<=$weeks;$x++){
                
                $interest_this_week = round($compounding_rate * $p_balance);
                
                $principal_this_week = $cashflow - $interest_this_week;
                if($x==0){
                     $table[]=(object) array(
                            'week'=>$x,
                            'cashflow'=>0,
                            'principal'=>0,
                            'interest'=>0,
                            'remaining_balance'=>$this->loan + $this->interest_value,
                            'p_balance'=>$p_balance,
                            'i_balance'=>$i_balance,
                            't_principal'=>0,
                            't_interest'=>0,
                            'collection_date'=>NULL
                        );
              
                }elseif($x==$weeks){
                  
                    $interest_this_week = $this->interest_value - $i_total;
                    $principal_this_week = $this->loan - $p_total;
                    
                    $p_total=$p_total+$principal_this_week;
                    $i_total=$i_total+$interest_this_week;

                    $p_balance = $p_balance - $principal_this_week;
                    $i_balance = $i_balance - $interest_this_week;

                        $table[]=(object) array(
                            'week'=>$x,
                            'cashflow'=>$principal_this_week + $interest_this_week,
                            'principal'=>$principal_this_week,
                            'interest'=>$interest_this_week,
                            'remaining_balance'=>'',
                            'p_balance'=>$p_balance,
                            'i_balance'=>$i_balance,
                            't_principal'=>$p_total,
                            't_interest'=>$i_total,
                            'collection_date'=>$date
                        );
                        
                }else{
                    $p_total=$p_total+$principal_this_week;
                    $i_total=$i_total+$interest_this_week;

                    $p_balance = $p_balance - $principal_this_week;
                    $i_balance = $i_balance - $interest_this_week;

                        $table[]=(object) array(
                            'week'=>$x,
                            'cashflow'=>$principal_this_week + $interest_this_week,
                            'principal'=>$principal_this_week,
                            'interest'=>$interest_this_week,
                            'remaining_balance'=>'',
                            'p_balance'=>$p_balance,
                            'i_balance'=>$i_balance,
                            't_principal'=>$p_total,
                            't_interest'=>$i_total,
                            'collection_date'=>$date
                        );
                        
                $date= add_seven_days($date);
                }
               
              
            
               // dd($collection_date->msg);
            }
            
            $this->table = $table;
            $this->t_principal = $p_total;
            $this->t_interest = $i_total;
            
        }    
    }
}
?>