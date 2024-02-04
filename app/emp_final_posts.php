<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class emp_final_posts extends Model
{
    protected $fillable = [
        'employeeattendanceid','employee_no', 'employee_name', 'days', 'working_hours', 'regular_pay', 'total_late_hours', 'total_late_minutes', 'late_total_amount', 'ot_rendered', 'ot_total_amount',  'total_nightdif', 'nightdif_total_amount', 'offset_rendered', 'offset_amount', 'holiday_rendered', 'holiday_total_amount', 'halfday_rendered', 'undertime_rendered', 'absent_rendered', 'changeoff_rendered', 'slvl_rendered', 'ob_amount', 'month', 'period', 'status'
    ];
}
