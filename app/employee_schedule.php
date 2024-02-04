<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class employee_schedule extends Model
{
    protected $fillable = [
    'employee_no', 'employee_name', 'date_sched', 'time_sched',
    ];
}
