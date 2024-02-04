<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeContributionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_contributions', function (Blueprint $table) {
            $table->bigIncrements('id');
            /* $table->string('employee_no')->nullable();
            $table->string('employee_name')->nullable();
            $table->double('sss_loan', 10, 5)->nullable();
            $table->double('pag_ibig_loan', 10, 5)->nullable();
            $table->double('mutual_loan', 10, 5)->nullable();
            $table->double('sss_prem1', 10, 5)->nullable();
            $table->double('pag_ibig_prem1', 10, 5)->nullable();
            $table->double('philhealth1', 10, 5)->nullable();
            $table->double('sss_prem2', 10, 5)->nullable();
            $table->double('pag_ibig_prem2', 10, 5)->nullable();
            $table->double('philhealth2', 10, 5)->nullable(); */
            $table->string('employee_no')->nullable();
            $table->string('employee_name')->nullable();
            $table->double('sss_loan', 10, 5)->nullable();
            $table->double('pag_ibig_loan', 10, 5)->nullable();
            $table->double('mutual_loan', 10, 5)->nullable();
            $table->double('sss_prem', 10, 5)->nullable();
            $table->double('pag_ibig_prem', 10, 5)->nullable();
            $table->double('philhealth', 10, 5)->nullable();
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
        Schema::dropIfExists('employee_contributions');
    }
}
