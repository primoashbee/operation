<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('payment_summaries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cluster_code');
            $table->string('collection_date');
            $table->integer('amount_paid');
            $table->integer('uploader_id');
            $table->timeStamps();
            
            //
        });
        
        Schema::create('payment_informations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('amort_id');
            $table->integer('amount_paid');
            $table->integer('principal_paid');
            $table->integer('interest_paid');
            $table->integer('this_week_balance');
            $table->integer('week_interest_balance');
            $table->integer('week_principal_balance');
            //
        });
        
        Schema::create('cbu_collections', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('payment_summaries_id')->unsigned();
            $table->integer('amort_id')->unsigned();
            $table->integer('amount')->unsigned();
            //
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::drop('payment_summaries');
        Schema::drop('payment_informations');
        Schema::drop('cbu_collections');
        
        
    }
}
