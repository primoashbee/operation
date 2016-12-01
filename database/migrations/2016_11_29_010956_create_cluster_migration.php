<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClusterMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clusters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique();
            $table->integer('branch_id')->unsigned()->index();
            $table->string('region')->nullable();
            $table->string('pa_lastname')->nullable();
            $table->string('pa_firstname')->nullable();
            $table->timestamps();
        });
        
        Schema::create('cluster_members', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('cluster_id')->unsigned();
            $table->integer('client_id')->unsigned();
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
        
        Schema::drop('clusters');
        Schema::drop('cluster_members');
        
    }
}
