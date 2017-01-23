<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLoansTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
      /*  Schema::create('cashflow_analysis', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned()->index();
            $table->bigInteger('business_net_disposable_income')->nullable();
            $table->bigInteger('household_income')->nullable();
            $table->bigInteger('household_expense')->nullable();
            $table->bigInteger('financial_risk_assessment')->nullable();
            $table->bigInteger('credit_limit')->nullable();
            $table->timestamps();
            $table->softDeletes();
            //
        });*/
        Schema::create('loan_applications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->unsigned()->index();
            $table->integer('product_id')->unsigned()->index();
            $table->string('purpose')->nullable();
            $table->bigInteger('loan_amount')->nullable();
            $table->bigInteger('loan_term')->nullable();
            $table->bigInteger('loan_interest')->nullable();
            $table->bigInteger('loan_total')->nullable();
            $table->bigInteger('weekly_amortization')->nullable();
            $table->bigInteger('weekly_cbu')->nullable();
            $table->bigInteger('co_maker_inside_cluster_id')->unsigned()->nullable();
            $table->bigInteger('co_maker_outside_cluster_id')->unsigned()->nullable();
            $table->bigInteger('business_net_disposable_income')->nullable();
            $table->bigInteger('household_income')->nullable();
            $table->bigInteger('household_expense')->nullable();
            $table->bigInteger('financial_risk_assessment')->nullable();
            $table->bigInteger('credit_limit')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
        });
        
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('interest_rate')->nullable();
            $table->bigInteger('min')->nullable();
            $table->bigInteger('max')->nullable();
            $table->bigInteger('loan_term')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
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
        //Schema::drop('cashflow_analysis');
        Schema::drop('loan_applications');
        Schema::drop('products');
    }
}
