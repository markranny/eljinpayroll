<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class employee_payrolls extends Model
{
    protected $fillable = [
        'id','employee_no', 'number_of_days', 'total_regular_wage', 'overtime_hrs', 'total_amount_overtime', 'slvl_total_hrs', 'total_amount_slvl', 'offset_total_hrs', 'total_amount_offset', 'nightdif_total_hrs', 'total_amount_nightdif', 'gross earnings', 'late_total_hrs', 'total_amount_late', 'holiday_total_hrs', 'total_amount_holiday', 'total_amount_benefits', 'total_amount_deductions', 'net earnings',
    ];
}
