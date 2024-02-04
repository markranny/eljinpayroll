<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class employees extends Model
{
    /* protected $fillable = [
        'id','employee_no', 'lastname', 'firstname', 'middlename', 'suffix', 'gender', 'civil_status', 'birthdate', 'contact_number', 'email', 'present_address', 'employee_status', 'department', 'job_title', 'hired_date', 'pay_type', 'pay_rate', 'sss_no', 'philhealth_no', 'hdmf_no.', 'tax_no', 'taxable',
    ]; */

    public function employees()
    {
        return $this->hasMany(Employees::class);
    }

}
