<?php

/* namespace App;

use Illuminate\Database\Eloquent\Model;

class employees extends Model
{

    
    public function employees()
    {
        return $this->hasMany(Employees::class);
    }

} */


namespace App;

use Illuminate\Database\Eloquent\Model;

class Employees extends Model
{

    protected $table = 'employees';

    protected $fillable = [
        'employee_no',
        'fullname',
        'lastname',
        'firstname',
        'middlename',
        'suffix',
        'gender',
        'educational_attainment',
        'degree',
        'civil_status',
        'birthdate',
        'contact_no',
        'email',
        'present_address',
        'permanent_address',
        'emergency_contact_name',
        'emergency_contact',
        'emergency_relationship',
        'employee_status',
        'job_status',
        'rank_file',
        'department',
        'line',
        'job_title',
        'hired_date',
        'endcontract',
        'pay_type',
        'pay_rate',
        'allowance',
        'sss_no',
        'philhealth_no',
        'hdmf_no',
        'tax_no',
        'taxable',
        'empcode',
        'costcenter',
    ];
}

