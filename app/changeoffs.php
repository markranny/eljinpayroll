<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class changeoffs extends Model
{
    protected $fillable = [
        'id','employeeattendanceid','employee_no', 'employee_name', 'working_schedule', 'new_working_schedule', 'time_in', 'time_out', 'remarks'
    ];
}
