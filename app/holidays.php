<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class holidays extends Model
{
    protected $fillable = [
        'id','employee_no', 'working_date', 'hours_rendered', 'remarks', 
    ];
}
