<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class employee_final_attendance_posts_logs extends Model
{
    protected $fillable = [
        'employeeattendanceid','employee_no', 'employee_name', 'date', 'day', 'in1', 'out2', 'hours_work', 'working_hour', 'late_hr', 'late_hr_amount', 'late_min_amount', 'halfday', 'undertime',  'absent', 'night_dif', 'night_dif_amount', 'overtime', 'holiday', 'holiday_count', 'offset', 'changeoff', 'night_dif', 'slvl', 'slvl_status', 'period', 'status' 
    ];
}
