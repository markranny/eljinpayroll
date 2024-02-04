<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class other_deductions extends Model
{
    protected $fillable = [
        'id','employee_no', 'deduc_code', 'description', 'amount', 'deduc_date', 
    ];
}
