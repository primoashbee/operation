<?php
namespace App\MyClass;
class Projected_Collection{
    public $t_interest;
    public $t_principal;
    public $p_balance;
    public $i_balance;
    public $p_percentage;
    public $i_percentage;
    public $p_total;
    public $i_total;
    public $css_class;
    public function set($tp,$ti,$pb,$ib,$pt){
        $this->t_principal = $tp;
        $this->t_interest = $ti;
        $this->p_balance = $pb;
        $this->i_balance = $ib;
        $this->p_total = $pt;

        $this->percentCompute();

    }
    public function percentCompute(){
        $this->p_percentage = round(($this->t_principal /$this->p_total ) * 100,2);
        if($this->p_percentage<=25){
            $this->css_class = "progress-bar-danger"; 
        }elseif($this->p_percentage<=50){
            $this->css_class = "progress-bar-warning"; 
        }elseif($this->p_percentage<=100){
            $this->css_class = "progress-bar-success"; 
        }
    }
    
}


?>