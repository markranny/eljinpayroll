<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacationleaveTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vacationleave', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('employee_no')->nullable();
            $table->string('employee_name')->nullable();
            $table->string('type')->nullable();
            $table->date('slvldate')->nullable();
            $table->date('modifieddate')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vacationleave');
    }
}
