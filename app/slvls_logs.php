<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class slvls_logs extends Model
{
    protected $fillable = [
        'id','employee_no', 'date_sched', 'type', 'remarks', 'month', 'period' 
    ];
}
