<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emp_posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('employee_no')->nullable();
            $table->string('employeeattendanceid')->nullable();
            $table->string('employee_name')->nullable();
            $table->string('days')->nullable();
            $table->string('working_hours')->nullable();
            $table->string('basic_pay')->nullable();
            $table->string('minutes_late')->nullable();
            $table->string('late_amount')->nullable();
            $table->string('udt_hrs')->nullable();
            $table->string('udt_amount')->nullable();
            $table->string('nightdif')->nullable();
            $table->string('nightdif_amount')->nullable();
            $table->string('holiday_amount')->nullable();
            $table->string('slvl_amount')->nullable();
            $table->string('absent')->nullable();
            $table->string('offdays')->nullable();
            $table->string('ot_hrs')->nullable();
            $table->string('ot_amount')->nullable();
            $table->string('offset_hrs')->nullable();
            $table->string('offset_amount')->nullable();
            $table->string('month')->nullable();
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
        Schema::dropIfExists('emp_posts');
    }
}
