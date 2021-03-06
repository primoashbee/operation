<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBranches extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::create('branches', function (Blueprint $table) {
            $table->increments('id');
            $table->string('operation')->nullable();
            $table->string('area')->nullable();
            $table->string('name')->nullable()->unique();
            $table->string('branch_code')->nullable()->unique();
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
        
        Schema::dropIfExists('branches');
        
    }
}
