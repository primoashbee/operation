<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('loan_summaries', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('disbursement_id')->unsigned()->nullable();
            $table->integer('client_id')->unsigned()->nullable();
            $table->integer('loan_amount')->unsigned()->nullable();
            $table->integer('loan_term')->unsigned()->nullable();
            $table->integer('cbu_new')->unsigned()->nullable();
            $table->integer('cbu_reloan')->unsigned()->nullable();
            $table->integer('processing_fee')->unsigned()->nullable();
            $table->integer('doc_stamp_tax')->unsigned()->nullable();
            $table->integer('mi_id')->unsigned()->nullable();
            $table->float('mi_premium_cblic')->unsigned()->nullable();
            $table->float('mi_premium_lmi')->unsigned()->nullable();
            $table->float('cli_premium_lmi')->unsigned()->nullable();
            $table->float('cli_premium_cblic')->unsigned()->nullable();
            $table->integer('total_pre_deductions')->unsigned()->nullable();
            $table->integer('total_loan_amount')->unsigned()->nullable();
            $table->string('status')->nullable();
            $table->boolean('is_payed')->nullable();
            $table->softDeletes();
            $table->timestamps();
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
        
        Schema::dropIfExists('loan_summaries');
        Schema::dropIfExists('amortizations');
        
    }
}
