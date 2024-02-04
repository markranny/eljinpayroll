<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class employees_detail_temps extends Model
{
    protected $fillable = [
        'employee_no', 'lastname', 'firstname', 'middlename', 'suffix', 'gender', 'civil_status', 'birthdate', 'contact_no', 'email', 'present_address', 'permanent_address', 'employee_status', 'department', 'job_title', 'hired_date', 'pay_type', 'pay_rate', 'sss_no', 'philhealth_no', 'hdmf_no', 'tax_no', 'taxable',
    ]; 
}
