<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class nightdifs extends Model
{
    protected $fillable = [
        'id','employee_no', 'working_date', 'hours_rendered', 'remarks', 
    ];
}
