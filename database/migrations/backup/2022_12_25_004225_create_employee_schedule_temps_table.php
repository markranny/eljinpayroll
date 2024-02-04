<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeScheduleTempsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_schedule_temps', function (Blueprint $table) {
            $table->string('employee_no')->nullable();
            $table->string('employee_name')->nullable();
            $table->string('department')->nullable();
            $table->string('line')->nullable();
            $table->date('date_sched')->nullable();
            $table->string('time')->nullable();
            $table->time('time_sched', $precision = 0)->nullable();
            $table->time('time_sched_out', $precision = 0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_schedule_temps');
    }
}
