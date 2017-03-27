<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFinishedLoan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('finished_disbursements', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('disbursement_id')->unsigned();
            $table->boolean('is_fully_paid');
            $table->boolean('finished'); 
            $table->string('comments'); 
            $table->timeStamps();
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('finished_disbursements');
    }
}
