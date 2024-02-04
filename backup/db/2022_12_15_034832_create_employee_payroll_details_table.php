<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeePayrollDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_payroll_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('employee_no')->nullable();
            $table->string('number_of_days')->nullable();
            $table->double('total_regular_wage', 10, 5)->nullable();
            $table->string('overtime_hrs')->nullable();
            $table->double('total_amount_overtime', 10, 5)->nullable();
            $table->string('slvl_total_hrs')->nullable();
            $table->double('total_amount_slvl', 10, 5)->nullable();
            $table->string('offset_total_hrs')->nullable();
            $table->double('total_amount_offset', 10, 5)->nullable();
            $table->string('nightdif_total_hrs')->nullable();
            $table->double('total_amount_nightdif', 10, 5)->nullable();
            $table->string('late_total_hrs')->nullable();
            $table->double('total_amount_late', 10, 5)->nullable();
            $table->string('holiday_total_hrs')->nullable();
            $table->double('total_amount_holiday', 10, 5)->nullable();
            $table->double('total_amount_benefits', 10, 5)->nullable();
            $table->double('total_amount_deductions', 10, 5)->nullable();
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
        Schema::dropIfExists('employee_payroll_details');
    }
}
