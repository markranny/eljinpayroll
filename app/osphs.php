<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class osphs extends Model
{
    protected $fillable = [
        'id','employee_no', 'working_sched', 'date_sched', 'wos2_in', 'wos2_out',  'remarks'
    ];
}
