<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class employee_deductions extends Model
{
    protected $fillable = [
        'id','employee_no','employee_name','advance', 'charge', 'meal', 'misc', 'uniform', 'bond_deposit', 'mutual_charge', 'month', 'year', 'period' 
    ];
}
