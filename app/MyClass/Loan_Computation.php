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
        public function set($loan,$rate,$term,$weeks,$wcr){
            $this->loan = $loan;
            $this->rate = $rate;
            $this->term = $term;
            $this->weeks = $weeks;
            $this->compounding_rate = $wcr;
            $this->compute();
            $this->table();
        }

        public function compute(){

            //(rate * term)
            $this->interest = ($this->rate * $this->term);
            $this->interest_value = $this->interest * $this->loan;
            $this->total_loan = $this->loan + (($this->interest) * $this->loan);
            $this->weekly_amort=($this->total_loan / $this->weeks); 
        }
        public function table(){
            $principal_balance = $this->loan;
            $weeks = $this->weeks;
            $interest_balance = $this->interest_value;
            $amortization = $this->weekly_amort;
            $outstanding_balance = $this->total_loan;
            $principal_balance = $this->loan;
            $interest_balance = $this->interest_value;
            $total_centavos = 0;
            $total_interest_centavos=0;
            $total_principal_centavos=0;
            $principal_this_week = 0;
            $interest_this_week=0;
            $table=[];
            $t_princpial=0;
            $t_interest=0;
            $remaining=0;
            $t_interest=0;
            $t_principal=0;
            for($x=1;$x<=$weeks;$x++){
                $interest_this_week = $this->compounding_rate * $principal_balance; //interest for x week
                $i_decimal = $interest_this_week - floor($interest_this_week);
                $p_decimal = $principal_this_week - floor($principal_this_week);
                $total_interest_centavos=$i_decimal;
                $total_principal_centavos=$p_decimal;
                $total_centavos = $total_interest_centavos + $total_principal_centavos;

                $principal_this_week = $amortization -$interest_this_week ;

                $cashflow = $interest_this_week + $principal_this_week; 
                
                $outstanding_balance = $outstanding_balance - $cashflow;
                $principal_balance = $principal_balance - $principal_this_week;
                $interest_balance=  $interest_balance - $interest_this_week; 
                $cashflow_revised = $cashflow;
                
                if(is_decimal($cashflow)){
                    $cashflow_revised = floor($cashflow); //get whole number value of cashflow 
                    $remaining = $cashflow - $cashflow_revised;
                }
               
                $interest_this_week = floor($interest_this_week);  //reassign values for principal and interest
                $principal_this_week = $cashflow_revised-$interest_this_week; //$principal_this_week = $cashflow_revised - $principal_this_week;
                if($x==$weeks){
                  
                    //$t_principal=$t_principal+$table{$x-2}->p_balance+$total_principal_centavos;
                    //$t_interest=$t_interest+$table{$x-2}->i_balance+$total_interest_centavos + ($remaining * $weeks);
                    
                    //$principal_this_week = $table{$x-2}->t_principal;
                    //$interest_this_week =  $table{$x-2}->t_interest;
                    
                    $table[]=(object) array(
                        
                        'week'=>$x,
                        'cashflow'=>ceil($table{$x-2}->p_balance+$total_principal_centavos + $table{$x-2}->i_balance+$total_interest_centavos),
                        //'principal'=>$principal_balance -$table{$x-2}->t_principal,
                        'principal' => $principal_this_week,
                        'interest' => $interest_this_week,
                        //'interest'=>$interest_balance -$table{$x-2}->i_balance,
                        'remaining_balance'=>'',
                        'p_balance'=>0,
                        'i_balance'=>0,
                        't_principal'=>$principal_balance - $t_principal,
                        't_interest'=>$interest_balance- $t_interest
                        );
                    

                      
                }else{
                    $t_principal=$t_principal+$principal_this_week;
                    $t_interest=$t_interest+$interest_this_week ;
                    $table[]=(object) array(
                        'week'=>$x,
                        'cashflow'=>$cashflow,
                        'principal'=>$principal_this_week,
                        'interest'=>$interest_this_week,
                        'remaining_balance'=>'',
                        'p_balance'=>$principal_balance,
                        'i_balance'=>$interest_balance,
                        't_principal'=>$t_principal,
                        't_interest'=>$t_interest
                        );
                        
                //}
                }
              
                

            }
            $this->table=(object) $table;
            $this->t_interest = $t_interest;
            $this->t_principal = $t_princpial;
        }
        
    }
}
?>