<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDisbursementTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('disbursement', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cluster_id')->unsigned()->nullable();
            $table->string('cv_number')->nullable();
            $table->integer('payee_id')->unsigned()->nullable();
            $table->bigInteger('loan_amount')->unsigned()->nullable();
            $table->string('check_number')->nullable();
            $table->string('release_date')->nullable();
            $table->boolean('is_finished')->nullable();
            $table->string('status')->nullable();
            $table->string('first_collection_date')->nullable();
            $table->string('last_collection_date')->nullable();
            $table->string('maturity_date')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
        });
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('disbursement');
    }
}
