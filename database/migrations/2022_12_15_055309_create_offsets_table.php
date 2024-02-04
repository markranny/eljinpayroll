<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffsetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offsets', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('employeeattendanceid')->nullable();
            $table->string('employee_no')->nullable();
            $table->string('employee_name')->nullable();
            $table->date('working_schedule')->nullable();
            $table->date('date_sched')->nullable();
            $table->time('offset_in', $precision = 0)->nullable();
            $table->time('offset_out', $precision = 0)->nullable();
            $table->string('offset_hrs')->nullable();
            $table->string('remarks')->nullable();
            $table->string('status')->nullable();
            $table->string('month')->nullable();
            $table->string('period')->nullable();
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
        Schema::dropIfExists('offsets');
    }
}