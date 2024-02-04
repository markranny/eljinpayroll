<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class set_holidays extends Model
{
    protected $fillable = [
        'id', 'date_sched', 'holiday_type',
    ];
}
