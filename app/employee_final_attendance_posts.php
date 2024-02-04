<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class employee_final_attendance_posts extends Model
{
    protected $fillable = [
        'employeeattendanceid','employee_no', 'employee_name', 'date', 'day', 'in1', 'out2', 'hours_work', 'working_hour'
    ];
}
