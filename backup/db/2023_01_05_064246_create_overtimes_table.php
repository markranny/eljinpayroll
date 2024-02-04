<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOvertimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('overtimes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('employee_no')->nullable();
            $table->string('employee_name')->nullable();
            $table->date('working_schedule')->nullable();
            $table->time('ot_in', $precision = 0)->nullable();
            $table->time('ot_out', $precision = 0)->nullable();
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('overtimes');
    }
}
