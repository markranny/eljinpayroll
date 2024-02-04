<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class wos extends Model
{
    protected $fillable = [
        'id','employee_no', 'working_sched', 'date_sched', 'remarks', 'month', 'year', 'period'
    ];
}
