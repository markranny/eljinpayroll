<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class obs_logs extends Model
{
    protected $fillable = [
        'id','employee_no', 'date_sched', 'location', 'remarks', 'month', 'period' 
    ];
}
