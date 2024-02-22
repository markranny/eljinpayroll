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
use App\retros;
use App\osphs;
use App\wos;
use App\retros_logs;
use App\wos_logs;
use App\set_holidays_logs;
use App\employee_deductions;
use App\employees;
use App\changetimes;
use DataTables;
use Validator;

class PayrollController extends Controller
{
    public function debitsummarynav()
    {
        return view('finance.debitsummarynav');
    }

    public function debitsummarydata(Request $request)
    {
    
    $payroll = DB::table('emp_final_posts as a')
    ->select(
        'b.costcenter as CostCenter',
        DB::raw('(CAST(a.pay_rate AS FLOAT) * 
                (CAST(a.days AS INT) - CAST(a.slvl_hrs AS FLOAT)
                - CAST(a.holiday_hrs AS FLOAT) - CAST(a.offdays AS FLOAT))
                + CAST(a.slvl_amount AS FLOAT) + CAST(a.offdays_amount AS FLOAT)
                + CAST(a.ot_amount AS FLOAT) + CAST(a.holiday_amount AS FLOAT) + CAST(a.nightdif_amount AS FLOAT)
                + CAST(a.ctlate_amount AS FLOAT) + CAST(a.late_amount AS FLOAT) + CAST(a.udt_amount AS FLOAT)
                - (CAST(c.sss_loan AS FLOAT) + CAST(c.sss_prem AS FLOAT) + CAST(c.pag_ibig_loan AS FLOAT) + CAST(c.pag_ibig_prem AS FLOAT) + CAST(c.philhealth AS FLOAT))
                - (CAST(d.advance AS FLOAT) + CAST(d.charge AS FLOAT) + CAST(d.uniform AS FLOAT) + CAST(d.bond_deposit AS FLOAT) + CAST(d.meal AS FLOAT) + CAST(d.misc AS FLOAT) + CAST(d.mutual_charge AS FLOAT))
                - (CAST(a.ctlate_amount AS FLOAT) + CAST(a.late_amount AS FLOAT) + CAST(a.udt_amount AS FLOAT))) as Wages'),
        'a.ot_amount as OvertimePremium'
        
    )
    ->leftJoin('employees as b', 'a.employee_no', '=', 'b.employee_no')
    ->leftJoin('emp_contris as c', 'a.employee_no', '=', 'c.employee_no')
    ->leftJoin('emp_deducs as d', 'a.employee_no', '=', 'd.employee_no')
    ->distinct()
    ->get();

    return DataTables::of($payroll)
    ->make(true);
}


public function creditsummarynav()
    {
        return view('finance.creditsummarynav');
    }

    public function creditsummarydata(Request $request)
    {
    
    $credit = DB::table('emp_final_posts as a')
    ->select(
        'b.costcenter as CostCenter',
        'a.employee_no',
        'a.employee_name',
        'c.sss_loan',
        'c.pag_ibig_loan',
        'c.mutual_loan',
        'c.sss_prem',
        'c.pag_ibig_prem',
        'c.philhealth',
        'c.unions',
        'd.advance',
        'd.bond_deposit',
        'd.charge',
        'd.meal',
        'd.misc',
        'd.uniform',
        'd.bond_deposit',
        'd.mutual_charge',
        'd.modifieddate',
    )
    ->leftJoin('employees as b', 'a.employee_no', '=', 'b.employee_no')
    ->leftJoin('emp_contris as c', 'a.employee_no', '=', 'c.employee_no')
    ->leftJoin('emp_deducs as d', 'a.employee_no', '=', 'd.employee_no')
    ->distinct()
    ->get();

    return DataTables::of($credit)
    ->make(true);
}

}
