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
        return view('HR.payroll_list_nav');
    }

    public function offsetnav()
    {
        $employees = DB::table('employees')
                    ->orderBy('lastname', 'ASC')
                    ->get();
                    
                    $empposts = DB::table('emp_posts')
                    ->select('employeeattendanceid')
                    ->orderBy('employeeattendanceid', 'ASC')
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
        // Assuming your .bat file is located at the specified path
        $batFilePath = 'C:/BWPAYROLL SYSTEM/PLUGINS/employee_details.bat';

        // Check if the .bat file exists
        if (file_exists($batFilePath)) {
            // Execute the .bat file using exec()
            $output = exec('cmd /Z "'.$batFilePath.'"', $outputArray, $returnCode);

            return view('HR.Employee_infos_nav');
        } else {
            // Handle case when the .bat file doesn't exist
            dd('The .bat file does not exist.');
        }  

        /* exec("Z:/Bat Files/employee_details.bat");
        return view('HR.Employee_infos_nav'); */
    }

    
    public function index()
    {
        $empcount = 0; // Initialize $empcount
        $empcount = Employees::count();
        return view('home', compact('empcount'));
    }

    public function saccplugin()
    {
        exec("C:/BWPAYROLL SYSTEM/PLUGINS/sacc.bat");
        return view('home');
    }

    public function edtrplugin()
    {
        // Assuming your .bat file is located at the specified path
        $batFilePath = 'C:/BWPAYROLL SYSTEM/PLUGINS/edtr.bat';

        // Check if the .bat file exists
        if (file_exists($batFilePath)) {
            // Execute the .bat file using exec()
            $output = exec('cmd /C "'.$batFilePath.'"', $outputArray, $returnCode);

            return view('home');
        } else {
            // Handle case when the .bat file doesn't exist
            dd('The .bat file does not exist.');
        }  
    }

    public function attlist()
    {
        // Assuming your .bat file is located at the specified path
        $batFilePath = 'C:/BWPAYROLL SYSTEM/PLUGINS/attendance_checking.bat';

        // Check if the .bat file exists
        if (file_exists($batFilePath)) {
            // Execute the .bat file using exec()
            $output = exec('cmd /C "'.$batFilePath.'"', $outputArray, $returnCode);

            return view('HR.Import_Attendance');
        } else {
            // Handle case when the .bat file doesn't exist
            dd('The .bat file does not exist.');
        }  
    }

    public function attendancepostsplugin()
    {
        // Assuming your .bat file is located at the specified path
        $batFilePath = 'C:/BWPAYROLL SYSTEM/PLUGINS/attendance-list-plugin.bat';

        // Check if the .bat file exists
        if (file_exists($batFilePath)) {
            // Execute the .bat file using exec()
            $output = exec('cmd /C "'.$batFilePath.'"', $outputArray, $returnCode);

            return view('home');
        } else {
            // Handle case when the .bat file doesn't exist
            dd('The .bat file does not exist.');
        }  
    }

    public function deductions()
    {
        exec("C:/BWPAYROLL SYSTEM/PLUGINS/employee_deductions.bat");
        return view('home');
    }

    public function benefits()
    {
        exec("C:/BWPAYROLL SYSTEM/PLUGINS/employee_benefits.bat");
        return view('home');
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
                /* ->select(DB::raw('CONCAT(employees.firstname, ", ", employees.lastname) as fullname'),'overtimes.*') */
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

            if($employeeattendanceid != null && $employee_name != null && $employee_no != null && $datesched != null && $workingsched != null && $timein != null && $timeout != null){
                $update = new osphs();
                $update->employeeattendanceid   =   request('employeeattendanceid');
                $update->employee_no   =   request('employee_no');
                $update->employee_name   =   $employee_name;
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
    # OFFSET - DAYS
    --------------------------------------------------------------*/ 
    /*--------------------------------------------------------------
    # DISPLAY OFFSET RECORDS - DAYS
    --------------------------------------------------------------*/ 
    public function offdata(Request $request)
    {
                $wos = DB::table('wos')
                ->join('employees', 'wos.employee_no', '=', 'employees.employee_no')
                ->select('employees.firstname', 'wos.*')
                ->orderBy('date_sched', 'DESC')
                ->get();

                return DataTables::of($wos)
                ->make(true);
    }

    /*--------------------------------------------------------------
    # ADD OFFSET RECORDS - DAYS
    --------------------------------------------------------------*/ 
    public function addoffset2(Request $request)
    {
        $employeeattendanceid = request('employeeattendanceid');
        $employee_no = request('employee_no');
        $employee_name = request('employee_name');
        $datesched = request('datesched');
        $worksched = request('worksched');
        $remarks = request('remarks');

        $getday = Carbon::parse($datesched)->format('d');
        $getmonth = Carbon::parse($datesched)->format('F');
        $getyear = Carbon::parse($datesched)->format('Y');

        if((int)$getday < 15){
            $getperiod = "1st Period";
        }else{
            $getperiod = "2nd Period";
        }

        try{

                $filter = DB::table('wos')  
                ->where("employee_no", "=", $employee_no)
                ->where("date_sched", "=", $datesched)
                ->count();

                if($filter<1){

                    if($employeeattendanceid != null && $employee_name != null && $employee_no != null && $datesched != null && $worksched != null && $timein != null && $timeout != null){
                        $update = new wos();
                        $update->employeeattendanceid   =   request('employeeattendanceid');
                        $update->employee_no   =   request('employee_no');
                        $update->employee_name   =   $employee_name;
                        $update->date_sched   =   request('datesched');
                        $update->working_sched   =   request('worksched');
                        $update->wos_hrs   =   '9';
                        $update->remarks   =   request('remarks');
                        $update->month = $getmonth;
                        $update->year = $getyear;
                        $update->period = $getperiod;
                        $update->save();

                        /* DB::statement($updatesched); */

                        Log::info('Add offset days');

                        $statuslogs = "
                        INSERT INTO statuslogs (linecode, functions, modifieddate) values ('OFFSETHRS', 'Add offset days', getdate())
                        ";
                        DB::statement($statuslogs);
                
                        $timesum1 = Carbon::parse($request->offsetin)->format('H');
                        $timesum2 = Carbon::parse($request->offsetout)->format('H');
                        $offsettotal = (int)$timesum2 - (int)$timesum1;

                        $updateattendance = "
                        insert into employee_attendance_posts(employeeattendanceid,empcode,employee_name,employee_no, date, day, in1, out2, hours_work, working_hour, minutes_late, udt, udt_hrs, nightdif, offsethrs, period, status) values('$employeeattendanceid','1','$employee_name','$employee_no', '$datesched', 'OFFSET', '00:00', '00:00', '9.0', '8.0','0','-','0.00','0','9','$getperiod','0')
                        ";

                        DB::statement($updateattendance);

                        Log::info('Add Offset days into amployee_attendance_posts');

                        $statuslogs = "
                        INSERT INTO statuslogs (linecode, functions, modifieddate) values ('OFFSETHRS', 'Add Offset days into amployee_attendance_posts', getdate())
                        ";
                        DB::statement($statuslogs);

                        $employees = DB::table('employees')
                                ->get();
                
                        Log::info('OFFSET Added Successfully!');

                        $statuslogs = "
                        INSERT INTO statuslogs (linecode, functions, modifieddate) values ('OFFSETHRS', 'OFFSET Added Successfully!', getdate())
                        ";
                        DB::statement($statuslogs);

                        return back()->with('employees', $employees)->with('success','OFFSET Added Successfully!'); 

                        }else{

                        Log::info('Please Fill Out This Form!');

                        $statuslogs = "
                        INSERT INTO statuslogs (linecode, functions, modifieddate) values ('OFFSETHRS', 'Please Fill Out This Form!', getdate())
                        ";
                        DB::statement($statuslogs);

                            return back()->with('error','Please Fill Out This Form!');
                        }
                
                }else{
                    Log::info('Please Fill Out This Form!');

                        $statuslogs = "
                        INSERT INTO statuslogs (linecode, functions, modifieddate) values ('OFFSETHRS', 'Data is already exist!', getdate())
                        ";
                        DB::statement($statuslogs);

                    return back()->with('error','Data is already exist!');
                }

        }catch(\Exception $e){
            return back()->with('exception', $e->getMessage());
        }
    }


    /*--------------------------------------------------------------
    # PAYROLL
    --------------------------------------------------------------*/
    /*--------------------------------------------------------------
    # VIEW PAYROLL LIST
    --------------------------------------------------------------*/

    public function payrolllistdata(Request $request)
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
                        + (cast(c.sss_loan as float) + cast(c.sss_prem as float) + cast(c.pag_ibig_loan as float) + cast(c.pag_ibig_prem as float) + cast(c.philhealth as float))
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
                        $btn = $btn.' <a href="payslip/'.$request->employee_no.'" data-toggle="tooltip"  data-id="'.$request->employee_no.'" data-original-title="view" class="btn btn-danger btn-sm View"><span class="material-symbols-outlined"><i class="material-icons">receipt_long</i></span></a>';
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


}
