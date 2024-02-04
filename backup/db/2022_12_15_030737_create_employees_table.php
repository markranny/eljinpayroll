<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('employee_no')->unique();
            $table->string('lastname')->nullable();
            $table->string('firstname')->nullable();
            $table->string('middlename')->nullable();
            $table->string('suffix')->nullable();
            $table->string('gender')->nullable();
            $table->string('civil_status')->nullable();
            $table->string('birthdate')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('email')->nullable();
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
            $table->float('pay_rate', 8, 2)->nullable();
            $table->string('sss_no')->nullable();
            $table->string('philhealth_no')->nullable();
            $table->string('hdmf_no')->nullable();
            $table->string('tax_no')->nullable();
            $table->string('taxable')->nullable();
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
        Schema::dropIfExists('employees');
    }
}
