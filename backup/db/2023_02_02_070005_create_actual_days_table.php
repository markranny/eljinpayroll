<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateActualDaysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actual_days', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('employeeattendanceid')->unique();
            $table->string('days')->unique();
            $table->string('month')->unique();
            $table->string('period')->unique();
            $table->string('year')->nullable();
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
        Schema::dropIfExists('actual_days');
    }
}
