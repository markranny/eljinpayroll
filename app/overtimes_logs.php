<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class overtimes_logs extends Model
{
    protected $fillable = [
        'id','employee_no', 'employee_name', 'working_schedule', 'ot_in', 'ot_out', 'remarks'
    ];
}
