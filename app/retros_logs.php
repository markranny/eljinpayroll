<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class retros_logs extends Model
{
    protected $fillable = [
        'id','employee_no', 'employee_name', 'working_schedule', 'active_date', 'status', 'remarks', 'month', 'period', 'year', 'created_at', 'updated_at'
    ];
}
