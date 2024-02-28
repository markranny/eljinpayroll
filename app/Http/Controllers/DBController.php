<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Foundation\Exceptions\Handler;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Log; 
use Carbon\Carbon;
use App\employees;
use DataTables;
use Validator;

class DBController extends Controller
{
                    
    public function firststate()
{
    $empcount = employees::count();

    $gross = DB::table('emp_final_posts as a')
        ->leftJoin('employees as b', 'a.employee_no', '=', 'b.employee_no')
        ->leftJoin('emp_contris as c', 'a.employee_no', '=', 'c.employee_no')
        ->leftJoin('emp_deducs as d', 'a.employee_no', '=', 'd.employee_no')
        ->selectRaw('SUM(
            CAST(a.pay_rate AS FLOAT) * 
            (CAST(a.days AS UNSIGNED) - CAST(a.slvl_hrs AS FLOAT)
            - CAST(a.holiday_hrs AS FLOAT) - CAST(a.offdays AS FLOAT))
            + CAST(a.slvl_amount AS FLOAT) + CAST(a.offdays_amount AS FLOAT)
            + CAST(a.ot_amount AS FLOAT) + CAST(a.holiday_amount AS FLOAT) + CAST(a.nightdif_amount AS FLOAT)
            + CAST(a.ctlate_amount AS FLOAT) + CAST(a.late_amount AS FLOAT) + CAST(a.udt_amount AS FLOAT)
            - (CAST(c.sss_loan AS FLOAT) + CAST(c.sss_prem AS FLOAT) + CAST(c.pag_ibig_loan AS FLOAT) + CAST(c.pag_ibig_prem AS FLOAT) + CAST(c.philhealth AS FLOAT))
            - (CAST(d.advance AS FLOAT) + CAST(d.charge AS FLOAT) + CAST(d.uniform AS FLOAT) + CAST(d.bond_deposit AS FLOAT) + CAST(d.meal AS FLOAT) + CAST(d.misc AS FLOAT) + CAST(d.mutual_charge AS FLOAT))
            - (CAST(a.ctlate_amount AS FLOAT) + CAST(a.late_amount AS FLOAT) + CAST(a.udt_amount AS FLOAT))
        ) AS gross')
        ->first();

    // Ensure $gross is not null before passing it to the view
    $grossValue = $gross ? $gross->gross : null;

    return view('home', compact('empcount', 'grossValue'));
}

}
