<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeSchedulePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_schedule_posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sched_no')->nullable();
            $table->string('employee_no')->nullable();
            $table->string('employee_name')->nullable();
            $table->string('department')->nullable();
            $table->string('line')->nullable();
            $table->date('date_sched')->nullable();
            $table->string('timess')->nullable();
            $table->time('time_sched', $precision = 0)->nullable();
            $table->time('time_sched_out', $precision = 0)->nullable();
            $table->date('change_sched')->nullable();
            $table->string('status')->nullable();
            $table->string('month')->nullable();
            $table->string('period')->nullable();
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
        Schema::dropIfExists('employee_schedule_posts');
    }
}
