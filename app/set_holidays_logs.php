<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class set_holidays_logs extends Model
{
    protected $fillable = [
        'id', 'date_sched', 'holiday_type',
    ];
}
