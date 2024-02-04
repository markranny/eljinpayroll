<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class attendance_collection extends Model
{
    protected $fillable = [
        'employeeattendanceid','empcode','employee_no', 'employee_name', 'date_sched', 'day', 'in1', 'out2', 'hours_work', 'working_hour', 'late_hr', 'late_min', 'halfday', 'undertime',  'absent', 'night_dif',  
    ];
}
