<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInsuranceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mi_dependent_information', function (Blueprint $table) {
            $table->increments('id');
            $table->string('description');
            $table->string('term');
            $table->integer('member_payment');
            $table->integer('spouse_payment');
            $table->integer('child_payment');
            $table->integer('parent_payment');
            $table->integer('sibling_payment');
            $table->integer('total');
            $table->integer('mi_fee');
            $table->integer('head_count');
            $table->integer('total_mi_fee');
            $table->timestamps();
        });

        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mi_dependent_information');
    }
}
