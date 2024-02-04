<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DateTimeInterface;
use Carbon\Carbon;

class employee_upload_attendances extends Model
{
    protected $fillable = [
        'employee_no', 'date', 'day', 'in1', 'out1', 'in2', 'out2', 'nextday', 'hours_work', 'location'
    ];

}
