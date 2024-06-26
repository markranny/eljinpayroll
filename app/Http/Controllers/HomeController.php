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
use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Dompdf\Dompdf;
use Carbon\Carbon;
use phpseclib3\Net\SSH2;
use App\retros;
use App\osphs;
use App\wos;
use App\retros_logs;
use App\wos_logs;
use App\set_holidays_logs;
use App\employee_deductions;
use App\employee_contributions;
use App\employee_final_attendance_posts;
use App\employees;
use App\changetimes;
use TCPDF;
use DataTables;
use Validator;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */


    /*--------------------------------------------------------------
    # NAVIGATION/ROUTES
    --------------------------------------------------------------*/

    public function payrolllistnav()
    {
        $payslip = DB::table('emp_final_posts as a')
        ->selectRaw('
            a.employeeattendanceid,
            SUM(
                (
                    (CAST(a.pay_rate AS FLOAT) * (CAST(a.days AS FLOAT) - (CAST(a.slvl_hrs AS FLOAT) + CAST(a.offdays AS FLOAT) + CAST(a.holiday_hrs AS FLOAT)))) +
                    CAST(a.ot_amount AS FLOAT) + 
                    CAST(a.holiday_amount AS FLOAT) + 
                    CAST(a.nightdif_amount AS FLOAT) + 
                    CAST(a.offdays_amount AS FLOAT) + 
                    CAST(a.slvl_amount AS FLOAT) +
                    CAST(a.late_amount AS FLOAT) + 
                    CASE WHEN CAST(a.ctlate_amount AS FLOAT) IS NOT NULL THEN CAST(a.ctlate_amount AS FLOAT) ELSE 0 END + 
                    (CAST(a.udt_amount AS FLOAT) * -1)
                )
                -
                (
                    CAST(a.late_amount AS FLOAT) + 
                    CASE WHEN CAST(a.ctlate_amount AS FLOAT) IS NOT NULL THEN CAST(a.ctlate_amount AS FLOAT) ELSE 0 END + 
                    (CAST(a.udt_amount AS FLOAT) * -1) +
                    COALESCE(CAST(d.advance AS FLOAT), 0) + 
                    COALESCE(CAST(d.charge AS FLOAT), 0) +
                    COALESCE(CAST(d.uniform AS FLOAT), 0) +
                    COALESCE(CAST(d.meal AS FLOAT), 0) +
                    COALESCE(CAST(d.misc AS FLOAT), 0) +
                    COALESCE(CAST(d.mutual_charge AS FLOAT), 0) +
                    COALESCE(CAST(d.bond_deposit AS FLOAT), 0) +
                    COALESCE(CAST(c.sss_loan AS FLOAT), 0) + 
                    COALESCE(CAST(c.sss_prem AS FLOAT), 0) +
                    COALESCE(CAST(c.pag_ibig_loan AS FLOAT), 0) +
                    COALESCE(CAST(c.pag_ibig_prem AS FLOAT), 0) +
                    COALESCE(CAST(c.philhealth AS FLOAT), 0) +
                    COALESCE(CAST(c.mutual_loan AS FLOAT), 0) +
                    COALESCE(CAST(c.mutual_share AS FLOAT), 0) +
                    COALESCE(CAST(c.unions AS FLOAT), 0) 
                )
            ) as NETSALARY')
        ->selectRaw('CASE WHEN SUM(CAST(d.bond_deposit AS FLOAT)) IS NOT NULL THEN SUM(CAST(d.bond_deposit AS FLOAT)) ELSE 0 END AS BONDDEPO')
        ->selectRaw('CASE WHEN SUM(CAST(c.mutual_share AS FLOAT)) IS NOT NULL THEN SUM(CAST(c.mutual_share AS FLOAT)) ELSE 0 END AS MUTUALSHARE')
        ->select('a.month', 'a.year', 'a.period')
        ->leftJoin('employees as b', 'a.employee_no', '=', 'b.employee_no')
        ->leftJoin('emp_contris as c', 'a.employee_no', '=', 'c.employee_no')
        ->leftJoin('emp_deducs as d', 'a.employee_no', '=', 'd.employee_no')
        ->whereNotIn('a.employeeattendanceid', function ($query) {
            $query->select('employeeattendanceid')->from('payroll_master');
        })
        ->groupBy('a.employeeattendanceid', 'a.month', 'a.year', 'a.period')
        ->orderByDesc('a.employeeattendanceid')
        ->get();


        return view('HR.payroll_list_nav', compact('payslip'));
    }

    public function offsetnav()
    {

        $employees = DB::table('employees')
                    ->orderBy('lastname', 'ASC')
                    ->get();

        $empposts = DB::table('emp_posts')
                    ->select('employeeattendanceid')
                    ->orderBy('employeeattendanceid', 'DESC')
                    ->limit(1)
                    ->get();

        return view('HR.offset_nav', compact('employees','empposts'));
    }

    public function offset2nav()
    {
        $employees = DB::table('employees')
                    ->orderBy('lastname', 'ASC')
                    ->get();
                    $empposts = DB::table('emp_posts')
                    ->select('employeeattendanceid')
                    ->orderBy('employeeattendanceid', 'ASC')
                    ->limit(1)
                    ->get();

        return view('HR.offset2_nav', compact('employees','empposts'));
    }

    public function deductionlists()
    {
        return view('HR.deductionlist_nav');
    }

    public function contributionlists()
    {
        return view('HR.contributionlist_nav');
    }


    public function viewpayroll($employee_no)
    {
        $payroll = DB::table('emp_final_posts')
                ->join('employees', 'emp_final_posts.employee_no', '=', 'employees.employee_no')
                ->leftjoin('employee_contributions', 'employees.employee_no', '=', 'employee_contributions.employee_no')
                ->leftjoin('employee_deductions', 'employees.employee_no', '=', 'employee_deductions.employee_no')
                ->select('emp_final_posts.*','employees.*',
                'employee_deductions.advance','employee_deductions.charge','employee_deductions.meal','employee_deductions.misc','employee_deductions.uniform','employee_deductions.bond_deposit','employee_deductions.mutual_charge',
                'employee_contributions.sss_loan','employee_contributions.pag_ibig_loan','employee_contributions.mutual_loan','employee_contributions.mutual_share','employee_contributions.sss_prem','employee_contributions.pag_ibig_prem','employee_contributions.philhealth','employee_contributions.unions',

                DB::raw('
                ROUND(
                    (IIF(emp_final_posts.basic_pay is null, 0, cast(emp_final_posts.basic_pay as float))
                    + 
                    IIF(emp_final_posts.nightdif is null, 0, cast(emp_final_posts.nightdif as float))
                    + 
                    IIF(emp_final_posts.nightdif_amount is null, 0, cast(emp_final_posts.nightdif_amount as float))
                    +
                    IIF(emp_final_posts.holiday_amount is null, 0, cast(emp_final_posts.holiday_amount as float)) 
                    +
                    IIF(emp_final_posts.slvl_amount is null, 0, cast(emp_final_posts.slvl_amount as float)) 
                    + 
                    IIF(emp_final_posts.offdays is null, 0, cast(emp_final_posts.offdays as float)) 
                    + 
                    IIF(emp_final_posts.ot_amount is null, 0, cast(emp_final_posts.ot_amount as float)) 
                    + 
                    IIF(emp_final_posts.offset_amount is null, 0, cast(emp_final_posts.offset_amount as float)))
                    
                    -
                    
                    (IIF(emp_final_posts.late_amount is null, 0, cast(emp_final_posts.late_amount as float))
                    +
                    IIF(emp_final_posts.udt_amount is null, 0, cast(emp_final_posts.udt_amount as float))
                    +
                    IIF(employee_deductions.advance is null, 0, cast(employee_deductions.advance as float))
                    +
                    IIF(employee_deductions.charge is null, 0, cast(employee_deductions.charge as float))
                    +
                    IIF(employee_deductions.meal is null, 0, cast(employee_deductions.meal as float))
                    +
                    IIF(employee_deductions.misc is null, 0, cast(employee_deductions.misc as float))
                    +
                    IIF(employee_deductions.uniform is null, 0, cast(employee_deductions.uniform as float))
                    +
                    IIF(employee_deductions.bond_deposit is null, 0, cast(employee_deductions.bond_deposit as float))
                    +
                    IIF(employee_deductions.mutual_charge is null, 0, cast(employee_deductions.mutual_charge as float))
                    +
                    IIF(employee_contributions.sss_loan is null, 0, cast(employee_contributions.sss_loan as float))
                    +
                    IIF(employee_contributions.pag_ibig_loan is null, 0, cast(employee_contributions.pag_ibig_loan as float))
                    +
                    IIF(employee_contributions.mutual_loan is null, 0, cast(employee_contributions.mutual_loan as float))
                    +
                    IIF(employee_contributions.sss_prem is null, 0, cast(employee_contributions.sss_prem as float))
                    +
                    IIF(employee_contributions.pag_ibig_prem is null, 0, cast(employee_contributions.pag_ibig_prem as float))
                    +
                    IIF(employee_contributions.philhealth is null, 0, cast(employee_contributions.philhealth as float))
                    
                    
                    ), 2)
                    as gross
                '))
                ->where("employees.employee_no", "=", $employee_no)
                ->get();



        return view('HR.Payrollnav',['payroll' => $payroll]);
    }


    /*--------------------------------------------------------------
    # PLUGINS SOFTWARE APPLICATIONS
    --------------------------------------------------------------*/
    public function empplugin()
    {

        $remoteHost = '10.151.5.55';
        $username = 'Admin'; 
        $password = 'admin101'; 

        $ssh = new SSH2($remoteHost);
        if (!$ssh->login($username, $password)) {
            return response()->json(['error' => 'Access Denied']);
        }

        $process = new Process(['F:/BWPAYROLL SYSTEM/PLUGINS/employee_details.bat']);
        $process->run();

        if (!$process->isSuccessful()) {
            return response()->json(['error' => 'Failed to execute command']);
        }

        return back()->with('success', 'Open Employee Details UI');
    }

    
    public function index()
    {
        $empcount = employees::count();
        $empcount = $empcount ? ($empcount->empcount ?? $empcount) : '0.00';

        $gross = DB::table('emp_final_posts as a')
            ->select(DB::raw("FORMAT(
                SUM(
                    CAST(a.pay_rate AS FLOAT) * 
                    (CAST(a.days AS FLOAT) - CAST(a.slvl_hrs AS FLOAT) - CAST(a.holiday_hrs AS FLOAT) - CAST(a.offdays AS FLOAT))
                    + CAST(a.slvl_amount AS FLOAT) + CAST(a.offdays_amount AS FLOAT)
                    + CAST(a.ot_amount AS FLOAT) + CAST(a.holiday_amount AS FLOAT) + CAST(a.nightdif_amount AS FLOAT)
                    + CAST(a.ctlate_amount AS FLOAT) + CAST(a.late_amount AS FLOAT) + CAST(a.udt_amount AS FLOAT)
                    - (CAST(c.sss_loan AS FLOAT) + CAST(c.sss_prem AS FLOAT) + CAST(c.pag_ibig_loan AS FLOAT) + CAST(c.pag_ibig_prem AS FLOAT) + CAST(c.philhealth AS FLOAT))
                    - (CAST(d.advance AS FLOAT) + CAST(d.charge AS FLOAT) + CAST(d.uniform AS FLOAT) + CAST(d.bond_deposit AS FLOAT) + CAST(d.meal AS FLOAT) + CAST(d.misc AS FLOAT) + CAST(d.mutual_charge AS FLOAT))
                    - (CAST(a.ctlate_amount AS FLOAT) + CAST(a.late_amount AS FLOAT) + CAST(a.udt_amount AS FLOAT))
                ),
                '#,##0.00') AS gross"))
            ->leftJoin('employees as b', 'a.employee_no', '=', 'b.employee_no')
            ->leftJoin('emp_contris as c', 'a.employee_no', '=', 'c.employee_no')
            ->leftJoin('emp_deducs as d', 'a.employee_no', '=', 'd.employee_no')
            ->first();

        $overtimePremium = DB::table('emp_final_posts as a')
            ->select(DB::raw("FORMAT(SUM(cast(a.ot_amount as float)), '#,##0.00') as OvertimePremium"))
            ->leftJoin('employees as b', 'a.employee_no', '=', 'b.employee_no')
            ->leftJoin('emp_contris as c', 'a.employee_no', '=', 'c.employee_no')
            ->leftJoin('emp_deducs as d', 'a.employee_no', '=', 'd.employee_no')
            ->distinct()
            ->first();

            $mutualshare = DB::table('emp_final_posts as a')
            ->select(DB::raw('SUM(cast(c.mutual_share as float)) as MutualShare'))
            ->select(DB::raw("FORMAT(SUM(cast(c.mutual_share as float)), '#,##0.00') as MutualShare"))
            ->leftJoin('employees as b', 'a.employee_no', '=', 'b.employee_no')
            ->leftJoin('emp_contris as c', 'a.employee_no', '=', 'c.employee_no')
            ->leftJoin('emp_deducs as d', 'a.employee_no', '=', 'd.employee_no')
            ->distinct()
            ->first();
        

            if($overtimePremium != null){
                $grossValue = $gross ? ($gross->gross ?? '0.00') : '0.00';
            }else{
                $grossValue = $gross ? $gross->gross : '0.00';
            }

            if($overtimePremium != null){
                $overtimePremiumValue = $overtimePremium ? ($overtimePremium->OvertimePremium ?? '0.00' ) : '0.00';
            }else{
                $overtimePremiumValue = $overtimePremium ? $overtimePremium->OvertimePremium : '0.00';
            }

            /* if($mutualshare != null){
                $mutualshareValue = $mutualshare->MutualShare;
            }else{
                $mutualshareValue = $mutualshare ? $mutualshare->mutualshare : '0.00';
            } */

            if($mutualshare != null){
                $mutualshareValue = $mutualshare ? ($mutualshare->mutualshare ?? '0.00' ) : '0.00';
            }else{
                $mutualshareValue = $mutualshare ? $mutualshare->mutualshare : '0.00';
            }

        /* dd($mutualshareValue); */

    return view('home', compact('empcount', 'grossValue', 'overtimePremiumValue', 'mutualshareValue'));
    }

    public function saccplugin()
    {
        exec("C:/BWPAYROLL SYSTEM/PLUGINS/sacc.bat");
        return view('home');
    }

    public function edtrplugin()
    {
        $process = new Process(['C:/BWPAYROLL SYSTEM/PLUGINS/edtr.bat']);
        $process->run();

        // Executes after the command finishes
        if (!$process->isSuccessful()) {
            return view('HR.home');
        }

        // Fetch the output and handle if needed
        $output = $process->getOutput();
        return back()->with('success', 'Open DTR UI');
    }

    public function attlist()
    {
        $process = new Process(['C:/BWPAYROLL SYSTEM/PLUGINS/attendance_checking.bat']);
        $process->run();

        // Executes after the command finishes
        if (!$process->isSuccessful()) {
            return view('HR.Import_Attendance');
        }

        // Fetch the output and handle if needed
        $output = $process->getOutput();
        return back()->with('success', 'Import EAC UI');
        
    }

    public function attendancepostsplugin()
    {
        $process = new Process(['C:/BWPAYROLL SYSTEM/PLUGINS/attendance-list-plugin.bat']);
        $process->run();

        // Executes after the command finishes
        if (!$process->isSuccessful()) {
            return view('HR.home');
        }

        // Fetch the output and handle if needed
        $output = $process->getOutput();
        return back()->with('success', 'Open DRAFT UI');
    }

    public function deductions()
    {
        $process = new Process(['C:/BWPAYROLL SYSTEM/PLUGINS/employee_deductions.bat']);
        $process->run();

        // Executes after the command finishes
        if (!$process->isSuccessful()) {
            return view('HR.home');
        }

        // Fetch the output and handle if needed
        $output = $process->getOutput();
        return back()->with('success', 'Open Deductions UI');
    }

    public function benefits()
    {
        $process = new Process(['C:/BWPAYROLL SYSTEM/PLUGINS/employee_benefits.bat']);
        $process->run();

        // Executes after the command finishes
        if (!$process->isSuccessful()) {
            return view('HR.home');
        }

        // Fetch the output and handle if needed
        $output = $process->getOutput();
        return back()->with('success', 'Open Benefits UI');
    }

    public function Fattendance()
    {
        exec("C:/BWPAYROLL SYSTEM/PLUGINS/attendance-final-posts.bat");
        return view('home');
    }

    public function fixed()
    {
        exec("C:/BWPAYROLL SYSTEM/PLUGINS/endtask.bat");
        return view('HR.Import_Attendance');
    }  


    /*--------------------------------------------------------------
    # OFFSET - HRS
    --------------------------------------------------------------*/ 
    /*--------------------------------------------------------------
    # DISPLAY OFFSET RECORDS
    --------------------------------------------------------------*/ 

    public function offsetdata(Request $request)
    {
                $osphs = DB::table('osphs')
                ->join('employees', 'osphs.employee_no', '=', 'employees.employee_no')
                ->select('employees.firstname', 'osphs.*')
                ->orderBy('working_schedule', 'DESC')
                ->get();

                return DataTables::of($osphs)
                ->make(true);
    }

    /*--------------------------------------------------------------
    # ADD OFFSET RECORDS
    --------------------------------------------------------------*/ 
    public function addoffset(Request $request)
    {
        $employeeattendanceid = request('employeeattendanceid');
        $employee_no = request('employee_no');
        $employee_name = request('employee_name');
        $workingsched = request('workingsched');
        $datesched = request('datesched');
        $offsetin = request('offsetin');
        $offsetout = request('offsetout');

        $employee_data = DB::table('employees')
        ->select('employee_no', 'fullname')
        ->where('employee_no', $employee_name)
        ->first();

        if($employee_data != null){
            $employee_no = $employee_data->employee_no; 
            $fullname = $employee_data->fullname; 
        }else{
            return back()->with('error','Please Select employee');
        }

        $getday = Carbon::parse($datesched)->format('d');
        $getmonth = Carbon::parse($datesched)->format('F');
        $getyear = Carbon::parse($datesched)->format('Y');


        if((int)$getday < 15){
            $getperiod = "1st Period";
        }else{
            $getperiod = "2nd Period";
        }

        $time1 = Carbon::parse($request->offsetin)->format('H');
        $time2 = Carbon::parse($request->offsetout)->format('H');
        $timetotal = (int)$time2 - (int)$time1;

        $filter = DB::table('osphs')
        ->where("employee_no", "=", $employee_no)
        ->where("working_schedule", "=", $datesched)
        ->count();

        if($filter<1){

            if($employeeattendanceid != null && $employee_name != null && $employee_no != null && $datesched != null && $workingsched != null && $offsetin != null && $offsetout != null){
                $update = new osphs();
                $update->employeeattendanceid   =   request('employeeattendanceid');
                $update->employee_no   =   $employee_no;
                $update->employee_name   =   $fullname;
                $update->working_schedule   =   request('workingsched');
                $update->date_sched   =   request('datesched');
                $update->osphs_in   =   request('offsetin');
                $update->osphs_out   =   request('offsetout');
                $update->osphs_hrs   =   $timetotal;
                $update->remarks   =   request('remarks');
                $update->month   =   $getmonth;
                $update->year   = $getyear;
                $update->period   =   $getperiod ;
                $update->save();

                Log::info('Add OSPHS');

                        $statuslogs = "
                        INSERT INTO statuslogs (linecode, functions, modifieddate) values ('OFFSETHRS', 'Add OSPHS', getdate())
                        ";
                        DB::statement($statuslogs);

                $employees = DB::table('employees')
                        ->get();
        
                $updatesched = "
                update employee_attendance_posts set day='OFFSET' where employee_no = '$employee_no' and date = '$datesched'
                ";

                DB::statement($updatesched);

                Log::info('Update offset days');

                        $statuslogs = "
                        INSERT INTO statuslogs (linecode, functions, modifieddate) values ('OFFSETHRS', 'Update offset days', getdate())
                        ";
                        DB::statement($statuslogs);

                $updateattendance2 = "
                update employee_attendance_posts set offsethrs = '$timetotal' where employee_no = '$employee_no' and date = '$datesched' and employeeattendanceid = '$employeeattendanceid'
                ";

                DB::statement($updateattendance2);

                Log::info('Update offset hrs');

                        $statuslogs = "
                        INSERT INTO statuslogs (linecode, functions, modifieddate) values ('OFFSETHRS', 'Update offset hrs', getdate())
                        ";
                        DB::statement($statuslogs);

                $updateattendance5 = "
                update employee_attendance_posts set working_hour = Case when (cast(offsethrs as float) + cast(working_hour as float))  > 8 then '8.00' else FORMAT(cast(offsethrs as float) + cast(working_hour as float), 'F2') end where employee_no = '$employee_no' and date = '$datesched' and employeeattendanceid = '$employeeattendanceid'
                ";

                DB::statement($updateattendance5);

                Log::info('Update working hrs');

                        $statuslogs = "
                        INSERT INTO statuslogs (linecode, functions, modifieddate) values ('OFFSETHRS', 'Update working hrs', getdate())
                        ";
                        DB::statement($statuslogs);

                $updateattendance3 = "
                update employee_attendance_posts set udt_hrs = Case when cast(working_hour as float)  > 8 then '0.00' else FORMAT(cast(working_hour as float) - 8, 'F2') end where employee_no = '$employee_no' and date = '$datesched' and employeeattendanceid = '$employeeattendanceid'
                ";

                DB::statement($updateattendance3);

                Log::info('Update UDT hrs');

                        $statuslogs = "
                        INSERT INTO statuslogs (linecode, functions, modifieddate) values ('OFFSETHRS', 'Update UDT hrs', getdate())
                        ";
                        DB::statement($statuslogs);
                
                $updateattendance4 = "
                update employee_attendance_posts set udt = Case when cast(udt_hrs as float) = 0 then '-' when cast(udt_hrs as float) > 2 then 'HALFDAY' else 'UNDERTIME' end where employee_no = '$employee_no' and date = '$datesched' and employeeattendanceid = '$employeeattendanceid'
                ";

                DB::statement($updateattendance4);

                Log::info('Update UDT');

                        $statuslogs = "
                        INSERT INTO statuslogs (linecode, functions, modifieddate) values ('OFFSETHRS', 'Update UDT', getdate())
                        ";
                        DB::statement($statuslogs);

                        Log::info('Offset Added Successfully!');

                        $statuslogs = "
                        INSERT INTO statuslogs (linecode, functions, modifieddate) values ('OFFSETHRS', 'Offset Added Successfully!', getdate())
                        ";
                        DB::statement($statuslogs);

                return back()->with('employees', $employees)->with('success','Offset Added Successfully!'); 

                }else{

                    Log::info('Please Fill Out This Form!');

                        $statuslogs = "
                        INSERT INTO statuslogs (linecode, functions, modifieddate) values ('OFFSETHRS', 'Please Fill Out This Form!', getdate())
                        ";
                        DB::statement($statuslogs);

                    return back()->with('error','Please Fill Out This Form!');
                }
        
        }else{

            Log::info('Data is already used!');

                        $statuslogs = "
                        INSERT INTO statuslogs (linecode, functions, modifieddate) values ('OFFSETHRS', 'Data is already used!', getdate())
                        ";
                        DB::statement($statuslogs);

            return back()->with('error','Data is already used!');
        }


    }


    /*--------------------------------------------------------------
    # PAYROLL
    --------------------------------------------------------------*/
    /*--------------------------------------------------------------
    # VIEW PAYROLL LIST
    --------------------------------------------------------------*/

    /* public function payrolllistdata(Request $request)
    {
                $payroll = DB::table('emp_final_posts as a')
                ->select(
                    'a.employeeattendanceid',
                    'a.employee_no',
                    'a.employee_name',
                    'a.department',
                    'a.job_status',
                    'a.rank_file',
                    'a.day_needs',
                    'a.days',
                    DB::raw("FORMAT(cast(a.pay_rate as float) * 
                        (cast(a.days as int) - cast(a.slvl_hrs as float)
                        - cast(a.holiday_hrs as float) - cast(a.offdays as float))
                        + cast(a.slvl_amount as float) + cast(a.offdays_amount as float)
                        + cast(a.ot_amount as float) + cast(a.holiday_amount as float) + cast(a.nightdif_amount as float)
                        + cast(a.ctlate_amount as float) + cast(a.late_amount as float) + cast(a.udt_amount as float)
                        + (cast(c.sss_loan as float) + cast(c.sss_prem as float) + cast(c.pag_ibig_loan as float) + cast(c.pag_ibig_prem as float) + cast(c.philhealth as float))s
                        + (cast(d.advance as float) + cast(d.charge as float) + cast(d.uniform as float) + cast(d.bond_deposit as float) + cast(d.meal as float) + cast(d.misc as float) + cast(d.mutual_charge as float))
                        + (cast(a.ctlate_amount as float) + cast(a.late_amount as float) + cast(a.udt_amount as float)), 'F2') as GrossAmount"),
                    DB::raw("FORMAT(cast(a.pay_rate as float) * 
                        (cast(a.days as int) - cast(a.slvl_hrs as float)
                        - cast(a.holiday_hrs as float) - cast(a.offdays as float))
                        + cast(a.slvl_amount as float) + cast(a.offdays_amount as float)
                        + cast(a.ot_amount as float) + cast(a.holiday_amount as float) + cast(a.nightdif_amount as float)
                        + cast(a.ctlate_amount as float) + cast(a.late_amount as float) + cast(a.udt_amount as float)
                        - (cast(c.sss_loan as float) + cast(c.sss_prem as float) + cast(c.pag_ibig_loan as float) + cast(c.pag_ibig_prem as float) + cast(c.philhealth as float))
                        - (cast(d.advance as float) + cast(d.charge as float) + cast(d.uniform as float) + cast(d.bond_deposit as float) + cast(d.meal as float) + cast(d.misc as float) + cast(d.mutual_charge as float))
                        - (cast(a.ctlate_amount as float) + cast(a.late_amount as float) + cast(a.udt_amount as float)), 'F2') as NetAmount"),

                    DB::raw("FORMAT((cast(d.advance as float) + cast(d.charge as float) + cast(d.uniform as float) + cast(d.bond_deposit as float) + cast(d.meal as float) + cast(d.misc as float) + cast(d.mutual_charge as float)), 'F2') as TotalDeducAmount"),

                    DB::raw("FORMAT((cast(c.sss_loan as float) + cast(c.sss_prem as float) + cast(c.pag_ibig_loan as float) + cast(c.pag_ibig_prem as float) + cast(c.philhealth as float)), 'F2') as TotalContriAmount"),

                    DB::raw("FORMAT((cast(a.ctlate_amount as float) + cast(a.late_amount as float) + cast(a.udt_amount as float)), 'F2') as TotalOtherDeduc"),
                    
                    'a.basic_pay',
                    'a.per_trip',
                    'a.pertrip_amount',
                    'a.ctlate_amount',
                    'a.late_amount',
                    'a.udt_amount',
                    'a.nightdif_amount',
                    'a.holiday_amount',
                    'a.offdays_amount',
                    'a.ot_amount',
                    'a.slvl_amount',
                    'a.ob_amount',
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
                    'a.month',
                    'a.year',
                    'a.period'
                )
                ->leftJoin('employees as b', 'a.employee_no', '=', 'b.employee_no')
                ->leftJoin('emp_contris as c', 'a.employee_no', '=', 'c.employee_no')
                ->leftJoin('emp_deducs as d', 'a.employee_no', '=', 'd.employee_no')
                


                ->distinct()
                ->get();

                return DataTables::of($payroll)

                    ->addColumn('action', function($request){
                        $btn = ' <a href="view-payroll/'.$request->employee_no.'" data-toggle="tooltip"  data-id="'.$request->employee_no.'" data-original-title="view" class="btn btn-success btn-sm View"><span class="material-symbols-outlined"><i class="material-icons">article</i></span></a>';
                        $btn = $btn.' <a href="payslip/'.$request->employee_no.'" data-toggle="tooltip"  data-id="'.$request->employee_no.'" data-original-title="view" class="btn btn-danger btn-sm View"><span class="material-symbols-outlined"><i class="material-icons">download</i></span></a>';
                        $btn = $btn.' <a href="send-payslip/'.$request->employee_no.'" data-toggle="tooltip"  data-id="'.$request->employee_no.'" data-original-title="view" class="btn btn-primary btn-sm View"><span class="material-symbols-outlined"><i class="material-icons">send</i></span></a>';
                    return $btn;

                    })
                ->make(true);
    } */



    public function payrolllistdata(Request $request)
    {
                $payroll = DB::table('emp_final_posts as a')
                ->select(
                    'a.employeeattendanceid',
                    'a.employee_no',
                    'a.employee_name',
                    'a.department',
                    'a.job_status',
                    DB::raw("
                
                    (
                        (CAST(a.pay_rate AS FLOAT) * (CAST(a.days AS FLOAT) - (CAST(a.slvl_hrs AS FLOAT) + CAST(a.offdays AS FLOAT) + CAST(a.holiday_hrs AS FLOAT)))) +
                        CAST(a.ot_amount AS FLOAT) + 
                        CAST(a.holiday_amount AS FLOAT) + 
                        CAST(a.nightdif_amount AS FLOAT) + 
                        CAST(a.offdays_amount AS FLOAT) + 
                        CAST(a.slvl_amount AS FLOAT) +
                        CAST(a.late_amount AS FLOAT) + CASE WHEN CAST(a.ctlate_amount AS FLOAT) IS NOT NULL THEN CAST(a.ctlate_amount AS FLOAT) ELSE 0 END + (CAST(a.udt_amount AS FLOAT) * -1)
                    )
                
                    -
                
                    (
                        CAST(a.late_amount AS FLOAT) + CASE WHEN CAST(a.ctlate_amount AS FLOAT) IS NOT NULL THEN CAST(a.ctlate_amount AS FLOAT) ELSE 0 END + (CAST(a.udt_amount AS FLOAT) * -1) +
                        CASE WHEN CAST(d.advance AS FLOAT) IS NOT NULL THEN CAST(d.advance AS FLOAT) ELSE 0 END + 
                        CASE WHEN CAST(d.charge AS FLOAT) IS NOT NULL THEN CAST(d.charge AS FLOAT) ELSE 0 END +
                        CASE WHEN CAST(d.uniform AS FLOAT) IS NOT NULL THEN CAST(d.uniform AS FLOAT) ELSE 0 END +
                        CASE WHEN CAST(d.meal AS FLOAT) IS NOT NULL THEN CAST(d.meal AS FLOAT) ELSE 0 END +
                        CASE WHEN CAST(d.misc AS FLOAT) IS NOT NULL THEN CAST(d.misc AS FLOAT) ELSE 0 END +
                        CASE WHEN CAST(d.mutual_charge AS FLOAT) IS NOT NULL THEN CAST(d.mutual_charge AS FLOAT) ELSE 0 END +
                        CASE WHEN CAST(d.bond_deposit AS FLOAT) IS NOT NULL THEN CAST(d.bond_deposit AS FLOAT) ELSE 0 END +
                
                        CASE WHEN CAST(c.sss_loan AS FLOAT) IS NOT NULL THEN CAST(c.sss_loan AS FLOAT) ELSE 0 END + 
                        CASE WHEN CAST(c.sss_prem AS FLOAT) IS NOT NULL THEN CAST(c.sss_prem AS FLOAT) ELSE 0 END +
                        CASE WHEN CAST(c.pag_ibig_loan AS FLOAT) IS NOT NULL THEN CAST(c.pag_ibig_loan AS FLOAT) ELSE 0 END +
                        CASE WHEN CAST(c.pag_ibig_prem AS FLOAT) IS NOT NULL THEN CAST(c.pag_ibig_prem AS FLOAT) ELSE 0 END +
                        CASE WHEN CAST(c.philhealth AS FLOAT) IS NOT NULL THEN CAST(c.philhealth AS FLOAT) ELSE 0 END +
                        CASE WHEN CAST(c.mutual_loan AS FLOAT) IS NOT NULL THEN CAST(c.mutual_loan AS FLOAT) ELSE 0 END +
                        CASE WHEN CAST(c.mutual_share AS FLOAT) IS NOT NULL THEN CAST(c.mutual_share AS FLOAT) ELSE 0 END +
                        CASE WHEN CAST(c.unions AS FLOAT) IS NOT NULL THEN CAST(c.unions AS FLOAT) ELSE 0 END 
                    )
                        AS 
                        NETSALARY

                    "),
                    DB::raw("CASE WHEN CAST(d.bond_deposit AS FLOAT) IS NOT NULL THEN CAST(d.bond_deposit AS FLOAT) ELSE 0 END AS BONDDEPO"),
                    DB::raw("CASE WHEN CAST(c.mutual_share AS FLOAT) IS NOT NULL THEN CAST(c.mutual_share AS FLOAT) ELSE 0 END AS MUTUALSHARE"),
                    'a.month',
                    'a.year',
                    'a.period'
                )
                ->leftJoin('employees as b', 'a.employee_no', '=', 'b.employee_no')
                ->leftJoin('emp_contris as c', 'a.employee_no', '=', 'c.employee_no')
                ->leftJoin('emp_deducs as d', 'a.employee_no', '=', 'd.employee_no')
                
                ->distinct()
                ->get();

                return DataTables::of($payroll)

                    ->addColumn('action', function($request){
                        $btn = ' <a href="view-payroll/'.$request->employee_no.'" data-toggle="tooltip"  data-id="'.$request->employee_no.'" data-original-title="view" class="btn btn-success btn-sm View"><span class="material-symbols-outlined"><i class="material-icons">article</i></span></a>';
                        $btn = $btn.' <a href="payslip/'.$request->employee_no.'" data-toggle="tooltip"  data-id="'.$request->employee_no.'" data-original-title="view" class="btn btn-danger btn-sm View"><span class="material-symbols-outlined"><i class="material-icons">download</i></span></a>';
                        $btn = $btn.' <a href="send-payslip/'.$request->employee_no.'" data-toggle="tooltip"  data-id="'.$request->employee_no.'" data-original-title="view" class="btn btn-primary btn-sm View"><span class="material-symbols-outlined"><i class="material-icons">send</i></span></a>';
                    return $btn;

                    })
                ->make(true);
    }



    /*--------------------------------------------------------------
    # PAYSLIP
    --------------------------------------------------------------*/
    public function payslip($employee_no)
    {


        $payslip = DB::table('emp_final_posts')
                ->join('employees', 'emp_final_posts.employee_no', '=', 'employees.employee_no')
                ->leftjoin('employee_contributions', 'employees.employee_no', '=', 'employee_contributions.employee_no')
                ->leftjoin('employee_deductions', 'employees.employee_no', '=', 'employee_deductions.employee_no')
                ->select('emp_final_posts.*','employees.*',
                'employee_deductions.advance','employee_deductions.charge','employee_deductions.meal','employee_deductions.misc','employee_deductions.uniform','employee_deductions.bond_deposit','employee_deductions.mutual_charge',
                'employee_contributions.sss_loan','employee_contributions.pag_ibig_loan','employee_contributions.mutual_loan','employee_contributions.mutual_loan','employee_contributions.mutual_share','employee_contributions.sss_prem','employee_contributions.pag_ibig_prem','employee_contributions.philhealth','employee_contributions.unions',

                DB::raw('
                ROUND(
                    (IIF(emp_final_posts.basic_pay is null, 0, cast(emp_final_posts.basic_pay as float))
                    + 
                    IIF(emp_final_posts.nightdif is null, 0, cast(emp_final_posts.nightdif as float))
                    + 
                    IIF(emp_final_posts.nightdif_amount is null, 0, cast(emp_final_posts.nightdif_amount as float))
                    +
                    IIF(emp_final_posts.holiday_amount is null, 0, cast(emp_final_posts.holiday_amount as float)) 
                    +
                    IIF(emp_final_posts.slvl_amount is null, 0, cast(emp_final_posts.slvl_amount as float)) 
                    + 
                    IIF(emp_final_posts.offdays is null, 0, cast(emp_final_posts.offdays as float)) 
                    + 
                    IIF(emp_final_posts.ot_amount is null, 0, cast(emp_final_posts.ot_amount as float)) 
                    + 
                    IIF(emp_final_posts.offset_amount is null, 0, cast(emp_final_posts.offset_amount as float))
                    + 
                    IIF(emp_final_posts.ob_amount is null, 0, cast(emp_final_posts.ob_amount as float)))
                    
                    -
                    
                    (IIF(emp_final_posts.late_amount is null, 0, cast(emp_final_posts.late_amount as float))
                    +
                    IIF(emp_final_posts.udt_amount is null, 0, cast(emp_final_posts.udt_amount as float))
                    +
                    IIF(employee_deductions.advance is null, 0, cast(employee_deductions.advance as float))
                    +
                    IIF(employee_deductions.charge is null, 0, cast(employee_deductions.charge as float))
                    +
                    IIF(employee_deductions.meal is null, 0, cast(employee_deductions.meal as float))
                    +
                    IIF(employee_deductions.misc is null, 0, cast(employee_deductions.misc as float))
                    +
                    IIF(employee_deductions.uniform is null, 0, cast(employee_deductions.uniform as float))
                    +
                    IIF(employee_deductions.bond_deposit is null, 0, cast(employee_deductions.bond_deposit as float))
                    +
                    IIF(employee_deductions.mutual_charge is null, 0, cast(employee_deductions.mutual_charge as float))
                    +
                    IIF(employee_contributions.sss_loan is null, 0, cast(employee_contributions.sss_loan as float))
                    +
                    IIF(employee_contributions.pag_ibig_loan is null, 0, cast(employee_contributions.pag_ibig_loan as float))
                    +
                    IIF(employee_contributions.mutual_loan is null, 0, cast(employee_contributions.mutual_loan as float))
                    +
                    IIF(employee_contributions.sss_prem is null, 0, cast(employee_contributions.sss_prem as float))
                    +
                    IIF(employee_contributions.pag_ibig_prem is null, 0, cast(employee_contributions.pag_ibig_prem as float))
                    +
                    IIF(employee_contributions.philhealth is null, 0, cast(employee_contributions.philhealth as float))
                    +
                    IIF(employee_contributions.unions is null, 0, cast(employee_contributions.unions as float))
                    
                    
                    
                    ), 2)
                    as gross
                '))
                ->where("employees.employee_no", "=", $employee_no)
                ->get();
        

        $pdf = Pdf::loadView('hr.payslip',['payslip'=>$payslip]);
        return $pdf->stream('payslip.pdf',array('Attachment'=>0));     
    }

    /*--------------------------------------------------------------
    # DISPLAY DEDUCTION DATA
    --------------------------------------------------------------*/
    public function deductiondata(Request $request)
    {
        $employee_deductions = DB::table('employee_deductions')
                ->get();

                return DataTables::of($employee_deductions)
                ->make(true);
    }

    /*--------------------------------------------------------------
    # DISPLAY DEDUCTION DATA
    --------------------------------------------------------------*/
    public function contributiondata(Request $request)
    {
        $employee_contributions = DB::table('employee_contributions')
                ->get();

                return DataTables::of($employee_contributions)
                ->make(true);
    }



    /*--------------------------------------------------------------
    # SEND PAYSLIP
    --------------------------------------------------------------*/
    public function sendpayslip($employee_no)
    {
        try{
        $payslip = DB::table('emp_final_posts')
                ->join('employees', 'emp_final_posts.employee_no', '=', 'employees.employee_no')
                ->leftjoin('employee_contributions', 'employees.employee_no', '=', 'employee_contributions.employee_no')
                ->leftjoin('employee_deductions', 'employees.employee_no', '=', 'employee_deductions.employee_no')
                ->select('emp_final_posts.*','employees.*',
                'employee_deductions.advance','employee_deductions.charge','employee_deductions.meal','employee_deductions.misc','employee_deductions.uniform','employee_deductions.bond_deposit','employee_deductions.mutual_charge',
                'employee_contributions.sss_loan','employee_contributions.pag_ibig_loan','employee_contributions.mutual_loan','employee_contributions.sss_prem','employee_contributions.pag_ibig_prem','employee_contributions.philhealth','employee_contributions.unions',

                DB::raw('
                ROUND(
                    (IIF(emp_final_posts.basic_pay is null, 0, cast(emp_final_posts.basic_pay as float))
                    + 
                    IIF(emp_final_posts.nightdif is null, 0, cast(emp_final_posts.nightdif as float))
                    + 
                    IIF(emp_final_posts.nightdif_amount is null, 0, cast(emp_final_posts.nightdif_amount as float))
                    +
                    IIF(emp_final_posts.holiday_amount is null, 0, cast(emp_final_posts.holiday_amount as float)) 
                    +
                    IIF(emp_final_posts.slvl_amount is null, 0, cast(emp_final_posts.slvl_amount as float)) 
                    + 
                    IIF(emp_final_posts.offdays is null, 0, cast(emp_final_posts.offdays as float)) 
                    + 
                    IIF(emp_final_posts.ot_amount is null, 0, cast(emp_final_posts.ot_amount as float)) 
                    + 
                    IIF(emp_final_posts.offset_amount is null, 0, cast(emp_final_posts.offset_amount as float))
                    + 
                    IIF(emp_final_posts.ob_amount is null, 0, cast(emp_final_posts.ob_amount as float)))
                    
                    -
                    
                    (IIF(emp_final_posts.late_amount is null, 0, cast(emp_final_posts.late_amount as float))
                    +
                    IIF(emp_final_posts.udt_amount is null, 0, cast(emp_final_posts.udt_amount as float))
                    +
                    IIF(employee_deductions.advance is null, 0, cast(employee_deductions.advance as float))
                    +
                    IIF(employee_deductions.charge is null, 0, cast(employee_deductions.charge as float))
                    +
                    IIF(employee_deductions.meal is null, 0, cast(employee_deductions.meal as float))
                    +
                    IIF(employee_deductions.misc is null, 0, cast(employee_deductions.misc as float))
                    +
                    IIF(employee_deductions.uniform is null, 0, cast(employee_deductions.uniform as float))
                    +
                    IIF(employee_deductions.bond_deposit is null, 0, cast(employee_deductions.bond_deposit as float))
                    +
                    IIF(employee_deductions.mutual_charge is null, 0, cast(employee_deductions.mutual_charge as float))
                    +
                    IIF(employee_contributions.sss_loan is null, 0, cast(employee_contributions.sss_loan as float))
                    +
                    IIF(employee_contributions.pag_ibig_loan is null, 0, cast(employee_contributions.pag_ibig_loan as float))
                    +
                    IIF(employee_contributions.mutual_loan is null, 0, cast(employee_contributions.mutual_loan as float))
                    +
                    IIF(employee_contributions.sss_prem is null, 0, cast(employee_contributions.sss_prem as float))
                    +
                    IIF(employee_contributions.pag_ibig_prem is null, 0, cast(employee_contributions.pag_ibig_prem as float))
                    +
                    IIF(employee_contributions.philhealth is null, 0, cast(employee_contributions.philhealth as float))
                    +
                    IIF(employee_contributions.unions is null, 0, cast(employee_contributions.unions as float))
                    
                    
                    
                    ), 2)
                    as gross
                '))
                ->where("employees.employee_no", "=", $employee_no)
                ->get();



                $data = [];

        /* Mail::send('hr.payslip', ['payslip' => $payslip] + $data, function ($message) {
            $message->to('aglapay.markranny@gmail.com', 'Recipient Name')
                    ->subject('Test Email');
        }); */

        Mail::send('hr.sendpayslipheader', ['payslip' => $payslip] + $data, function ($message) use ($payslip) {
            // Generate PDF using TCPDF
            $pdf = new TCPDF();
            $pdf->AddPage();
            // Add your content to the PDF
            $pdf->writeHTML('<h1>Payslip</h1>');
            // Output the PDF content
            $pdfContent = $pdf->Output('payslip.pdf', 'S'); // 'S' parameter returns PDF as a string
        
            $employee_email = $payslip->first()->email;

            // Attach PDF to the email
            $message->from('dianamaenillo21@gmail.com', 'PAYSLIP')
                    ->to($employee_email, 'PAYSLIP')
                    ->subject('ECPAYROLL')
                    ->attachData($pdfContent, 'payslip.pdf', [
                        'mime' => 'application/pdf',
                    ]);
        });

        /* Mail::send([], [], function ($message) use ($payslip) {
            // Render Blade view to a string with inline CSS styles
            $pdfContent = View::make('hr.sendpayslip', ['payslip' => $payslip])->render();
        
            // Generate PDF using TCPDF
            $pdf = new TCPDF();
            $pdf->AddPage();
            // Set font
            $pdf->SetFont('helvetica', '', 10);
            // Add the rendered Blade view content to the PDF
            $pdf->writeHTML($pdfContent, true, false, true, false, '');
        
            // Output the PDF content
            $pdfOutput = $pdf->Output('payslip.pdf', 'S'); // 'S' parameter returns PDF as a string
        
            // Attach PDF to the email
            $message->from('dianamaenillo21@gmail.com', 'PAYROLL')
                    ->to('dianamaenillo21@gmail.com', 'Sample')
                    ->subject('Test Email')
                    ->attachData($pdfOutput, 'payslip.pdf', [
                        'mime' => 'application/pdf',
                    ]);
        });
        return "Test email sent successfully!"; */

        return back()->with('success','Payslip sent successfully!!!');
        } catch (\Exception $e) {
        // Log the error or do whatever necessary for error handling
        return back()->with('error', 'Error occurred while sending payslip: ' . $e->getMessage());
    }
    }


}
