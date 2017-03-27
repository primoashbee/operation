<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalendarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yearly_calendar', function (Blueprint $table) {
            $table->increments('id');
            $table->string('holiday');
            $table->date('holiday_date')->nullable();
            $table->string('day')->nullable();
            $table->boolean('is_weekend');
            $table->string('type');
            $table->string('year');
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
        
        Schema::dropifExists('yearly_calendar');
    }
}
