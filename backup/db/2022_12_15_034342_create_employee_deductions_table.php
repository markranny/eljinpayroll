<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeDeductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_deductions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('employee_no')->nullable();
            $table->string('employee_name')->nullable();
            $table->double('advance')->nullable();
            $table->double('charge')->nullable();
            $table->double('canteen')->nullable();
            $table->double('misc')->nullable();
            $table->double('uniform')->nullable();
            $table->double('bond_deposit')->nullable();
            $table->double('mutual_charge')->nullable();
            $table->string('month')->nullable();
            $table->string('period')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_deductions');
    }
}
