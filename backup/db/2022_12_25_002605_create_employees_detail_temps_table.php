<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesDetailTempsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees_detail_temps', function (Blueprint $table) {
            $table->string('employee_no')->nullable();
            $table->string('lastname')->nullable();
            $table->string('firstname')->nullable();
            $table->string('middlename')->nullable();
            $table->string('suffix')->nullable();
            $table->string('gender')->nullable();
            $table->string('civil_status')->nullable();
            $table->string('birthdate')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('email')->unique();
            $table->string('present_address')->nullable();
            $table->string('permanent_address')->nullable();
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->string('emergency_relationship')->nullable();
            $table->string('employee_status')->nullable();
            $table->string('job_status')->nullable();
            $table->string('regularization')->nullable();
            $table->string('department')->nullable();
            $table->string('job_title')->nullable();
            $table->string('hired_date')->nullable();
            $table->string('pay_type')->nullable();
            $table->string('pay_rate')->nullable();
            $table->string('sss_no')->nullable();
            $table->string('philhealth_no')->nullable();
            $table->string('hdmf_no')->nullable();
            $table->string('tax_no')->nullable();
            $table->string('taxable')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees_detail_temps');
    }
}
