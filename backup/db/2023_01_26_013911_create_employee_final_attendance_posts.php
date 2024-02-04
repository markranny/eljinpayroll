<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeFinalAttendancePosts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_final_attendance_posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('employeeattendanceid')->nullable();
            $table->string('employee_no')->nullable();
            $table->string('employee_name')->nullable();
            $table->date('date')->nullable();
            $table->string('day')->nullable();
            $table->time('in1', $precision = 0)->nullable();
            $table->time('out2', $precision = 0)->nullable();
            $table->string('hours_work')->nullable();
            $table->string('working_hour')->nullable();
            $table->string('basic_pay')->nullable();
            $table->string('minutes_late')->nullable();
            $table->string('late_amount')->nullable();
            $table->string('udt')->nullable();
            $table->string('udt_hrs')->nullable();
            $table->string('udt_amount')->nullable();
            $table->string('nightdif')->nullable();
            $table->string('nightdif_amount')->nullable();
            $table->string('holiday_type')->nullable();
            $table->string('holiday_amount')->nullable();
            $table->string('slvl')->nullable();
            $table->string('slvl_amount')->nullable();

            $table->string('overtime')->nullable();
            $table->string('overtime_amount')->nullable();
            $table->string('offset')->nullable();
            $table->string('offset_amount')->nullable();

            $table->string('period')->nullable();
            $table->string('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_final_attendance_posts');
    }
}
