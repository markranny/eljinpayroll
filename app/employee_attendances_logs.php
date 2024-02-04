<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class employee_attendances_logs extends Model
{
    protected $fillable = [
        'id','employeeattendanceid', 'employee_no', 'employee_name', 'date', 'day', 'in1', 'out1', 'in2', 'out2', 'nextday', 'hours_work' 
    ];
}
