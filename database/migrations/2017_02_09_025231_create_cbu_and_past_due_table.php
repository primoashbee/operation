<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCbuAndPastDueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('past_dues', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('amort_id');
            $table->integer('disbursement_id');
            $table->integer('client_id');
            $table->integer('principal');
            $table->integer('interest');
            $table->integer('total_amount');
            $table->string('week_to_be_paid');
            $table->string('to_be_collected_on');
            //
        });
        
        Schema::create('capital_build_ups', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('amort_id')->nullable()->unsigned();
            $table->integer('disbursement_id')->nullable()->unsigned();
            $table->integer('client_id')->nullable()->unsigned();
            $table->integer('amount')->nullable()->unsigned();
            $table->string('transaction_type')->nullable();
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
        
        
        Schema::dropIfExists('past_dues');
        Schema::dropIfExists('capital_build_ups');
        
        
    }
}
