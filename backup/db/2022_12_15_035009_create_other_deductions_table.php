<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtherDeductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('other_deductions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('deduc_code')->nullable();
            $table->string('employee_no')->nullable();
            $table->string('description')->nullable();
            $table->double('amount', 10, 5)->nullable();
            $table->string('deduc_date')->nullable();
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
        Schema::dropIfExists('other_deductions');
    }
}
