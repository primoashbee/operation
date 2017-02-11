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
            $table->string('disbursement_id')->nullable();
            $table->string('collection_date')->nullable();
            $table->integer('total_amount_due')->unsigned()->nullable();
            //$table->integer('principal_amount_due')->unsigned()->nullable();
            //$table->integer('interest_amount_due')->unsigned()->nullable();
            $table->integer('amount_paid')->unsigned()->nullable();
            $table->integer('principal_not_collected')->unsigned()->nullable();
            $table->integer('interest_not_collected')->unsigned()->nullable();
            $table->integer('uploader_id')->unsigned()->nullable();
            $table->boolean('isFullyPaid')->nullable();
            $table->timeStamps();
            
            //
        });
        
        Schema::create('payment_informations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('payment_summary_id')->unsigned()->nullable();
            $table->integer('amort_id')->unsigned()->nullable();
            $table->integer('amount_paid')->unsigned()->nullable();
            $table->integer('principal_paid')->unsigned()->nullable();
            $table->integer('interest_paid')->unsigned()->nullable();
            $table->integer('this_week_balance')->unsigned()->nullable();
            $table->integer('week_interest_balance')->unsigned()->nullable();
            $table->integer('week_principal_balance')->unsigned()->nullable();
            $table->string('payment_type')->nullable();
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
