<?php 
namespace App\MyClass{
    class Settings{
        public $date;
        //public $date= \Carbon\Carbon::now('PST');
        
        public function __construct(){
            $this->date = \Carbon\Carbon::now('PST');            

         }



    }
}

?>