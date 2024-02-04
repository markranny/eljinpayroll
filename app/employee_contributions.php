<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class employee_contributions extends Model
{
    protected $fillable = [
        'id','employee_no','employee_name','sss_loan', 'pag_ibig_loan', 'mutual_loan', 'sss_prem', 'pag_ibig_prem', 'philhealth', 'union', 'month', 'year', 'period' 
    ];
}
