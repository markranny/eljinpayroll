<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeUploadAttendancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_upload_attendances', function (Blueprint $table) {
            $table->string('employee_no')->nullable();
            $table->date('date')->nullable();
            $table->string('day')->nullable();
            $table->time('in1', $precision = 0)->nullable();
            $table->time('out1', $precision = 0)->nullable();
            $table->time('in2', $precision = 0)->nullable();
            $table->time('out2', $precision = 0)->nullable();
            $table->time('nextday', $precision = 0)->nullable();
            $table->double('hours_work',10, 2);
            $table->string('location')->nullable();
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_upload_attendances');
    }
}
