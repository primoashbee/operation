<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
    
        schema::create('credit_limit',function(Blueprint $table){
            $table->increments('id');
            $table->integer('client_id')->unsigned()->nullable();
            $table->integer('co_maker_inside_cluster_id')->unsigned()->nullable();
            $table->integer('co_maker_outside_cluster_id')->unsigned()->nullable();
            $table->bigInteger('business_net_disposable_income')->nullable();
            $table->bigInteger('household_income')->nullable();
            $table->bigInteger('household_expense')->nullable();
            $table->bigInteger('financial_risk_assessment')->nullable();
            $table->bigInteger('credit_limit')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
        Schema::create('products', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('interest_rate')->nullable();
            $table->bigInteger('min')->nullable();
            $table->bigInteger('max')->nullable();
            $table->decimal('weekly_compounding_rate',20,6)->nullable();
            

            $table->bigInteger('loan_term')->nullable();
            $table->bigInteger('weeks_to_pay')->nullable();
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
    public function down(){
        
     
        Schema::dropIfExists('products');
        Schema::dropIfExists('credit_limit');

    }
}
