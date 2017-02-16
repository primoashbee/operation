<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAmortization extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weekly_amortization', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('disbursement_id')->unsigned()->nullable();
            $table->integer('client_id')->unsigned()->nullable();
            $table->string('week')->nullable();
            $table->integer('principal_this_week')->unsigned()->nullable();
            $table->integer('interest_this_week')->unsigned()->nullable();
            $table->integer('principal_with_interest')->unsigned()->nullable();
            $table->integer('principal_balance')->unsigned()->nullable();
            $table->integer('interest_balance')->unsigned()->nullable();
            $table->string('collection_date')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::dropIfExists('weekly_amortization');
        
    }
}
