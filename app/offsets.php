<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class offsets extends Model
{
    protected $fillable = [
        'id','employee_no', 'working_sched', 'date_sched', 'offset_in', 'offset_out',  'remarks'
    ];
}
