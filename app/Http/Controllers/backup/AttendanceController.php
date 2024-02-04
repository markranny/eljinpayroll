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
use App\employee_attendances;
use App\employee_attendance_posts;
use App\employee_final_attendance_posts;
use App\employees_detail_temps;
use App\employee_attendances_logs;
use App\employee_attendance_posts_logs;
use App\employee_final_attendance_posts_logs;
use App\employees_detail_temps_logs;
use DataTables;
use Validator;

class AttendanceController extends Controller
{
    /*--------------------------------------------------------------
    # ATTENDANCE
    --------------------------------------------------------------*/
    /*--------------------------------------------------------------
    # SCHEDULE NAV 
    --------------------------------------------------------------*/
    public function attreport()
    {
        return view('HR.attendance_report_nav');
    }

    public function attdetails($employeeattendanceid , $employee_no)
    {
        $employee_attendance_posts = DB::table('employee_final_attendance_posts')
                    ->where('employeeattendanceid', '=', $employeeattendanceid)
                    ->where('employee_no', '=', $employee_no)
                    ->limit(1)
                    ->get();

        return view('HR.attendance_details_nav', ['employee_attendance_posts'=>$employee_attendance_posts]); 
    }

    public function attlistdata()
    {
        return view('HR.attendance');    
    }

    public function attpostsnav()
    {
        return view('HR.attendance_nav');
    }

    public function importdatanav()
    {
        return view('HR.Import_Attendance');
    }


    /*--------------------------------------------------------------
    # DISPLAY ATTENDANCE
    --------------------------------------------------------------*/

    public function attdetailsdata($id, $employee_no)
    {
        $employee_attendance_posts = DB::table('employee_final_attendance_posts')
        ->where('employeeattendanceid', '=', $id)
        ->where('employee_no', '=', $employee_no)
        ->get();

        return DataTables::of($employee_attendance_posts)
        ->make(true);
    }


    /*--------------------------------------------------------------
    # FUNCTIONS - ATTENDANCE
    --------------------------------------------------------------*/
    public function attreportdata(Request $request)
    {
                $emp_posts = DB::table('emp_final_posts')
                ->leftjoin('employee_final_attendance_posts', 'emp_final_posts.employee_no', '=', 'employee_final_attendance_posts.employee_no')
                ->select('emp_final_posts.*') 
                ->distinct()
                ->get();

                return DataTables::of($emp_posts)
                ->addColumn('action', function($request){
                    $btn = ' <a href="attendance-details/'.$request->employeeattendanceid.'/'.$request->employee_no.'" data-toggle="tooltip"  data-id="'.$request->id.'" data-original-title="view" class="btn btn-success btn-sm View"><span class="material-symbols-outlined">Details</span></a>';
        
                return $btn;
                })
                ->make(true);
    }

    public function fltrattreportnav(Request $request)
    {
                $employees = DB::table('employees')
                ->get();

                return view('HR.fltrattreportnav', ['employees'=>$employees]);
    }

    public function fltrattreportdata(Request $request)
    {
                $emp_posts = DB::table('emp_posts')
                ->where('employee_name', '=', $request->name)
                ->where('month', '=', $request->month)
                ->where('period', '=', $request->period)
                ->get();

                return DataTables::of($emp_posts)
                ->addColumn('action', function($request){
                    $btn = ' <a href="attendance-details/'.$request->id.'" data-toggle="tooltip"  data-id="'.$request->id.'" data-original-title="view" class="btn btn-success btn-sm View"><span class="material-symbols-outlined">Details</span></a>';
        
                return $btn;
                })
                ->make(true);
    }

    public function attlistdatacollection()
    {
       /*  $statement = "
        select distinct emp.employee_no, sched.employee_name, sched.date_sched, emp.day, emp.in1, emp.out2, emp.hours_work,  IIF(ROUND(emp.hours_work, 0) < 12, IIF(ROUND(emp.hours_work, 0) = 0, '0', '8'), 'FOR_CHECKING') as working_hour,IIF(DATEPART(hour, cast(sched.time_sched as time)) - DATEPART(hour, cast(emp.in1 as time)) < 0, DATEPART(hour, cast(sched.time_sched as time)) - DATEPART(hour, cast(emp.in1 as time)), '0') as late_hr, IIF(DATEPART(hour, cast(sched.time_sched as time)) - DATEPART(hour, cast(emp.in1 as time)) <= 0, ABS(DATEPART(minute, cast(sched.time_sched as time)) - DATEPART(minute, cast(emp.in1 as time))), '0') as late_min, IIF(DATEPART(hour, cast(emp.in1 as time)) - DATEPART(hour, cast(sched.time_sched as time)) > 3, 'HALDAY', '-') as halfday, IIF(DATEPART(hour, cast(sched.time_sched as time)) - DATEPART(hour, cast(emp.in1 as time)) > 2, 'UNDERTIME', '-') as undertimer,IIF(ROUND(emp.hours_work, 0) = 0, 'ABSENT', '-') as absent,IIF(DATEPART(hour, cast(emp.in1 as time)) >= 10, '1', '-') as night_dif from employee_attendance_savestates emp inner join employee_schedule_posts sched on emp.employee_no = sched.employee_no and emp.date = sched.date_sched
        ";
            
        $attendance_collection = DB::statement($statement)
                ->get();

                return DataTables::of($attendance_collection)
                ->make(true); */


        $results = DB::table('employee_attendance_savestates as emp')
        ->selectDistinct('emp.employee_no', 'sched.employee_name', 'sched.date_sched', 'emp.day', 'emp.in1', 'emp.out2', 'emp.hours_work')
        ->selectRaw("CASE
            WHEN ROUND(emp.hours_work, 0) < 12 THEN
                CASE
                    WHEN ROUND(emp.hours_work, 0) = 0 THEN '0'
                    ELSE '8'
                END
            ELSE 'FOR_CHECKING'
        END as working_hour")
        ->selectRaw("CASE
            WHEN DATEPART(hour, cast(sched.time_sched as time)) - DATEPART(hour, cast(emp.in1 as time)) < 0 THEN DATEPART(hour, cast(sched.time_sched as time)) - DATEPART(hour, cast(emp.in1 as time))
            ELSE '0'
        END as late_hr")
        ->selectRaw("CASE
            WHEN DATEPART(hour, cast(sched.time_sched as time)) - DATEPART(hour, cast(emp.in1 as time)) <= 0 THEN ABS(DATEPART(minute, cast(sched.time_sched as time)) - DATEPART(minute, cast(emp.in1 as time))
            ELSE '0'
        END as late_min")
        ->selectRaw("CASE
            WHEN DATEPART(hour, cast(emp.in1 as time)) - DATEPART(hour, cast(sched.time_sched as time)) > 3 THEN 'HALFDAY'
            ELSE '-'
        END as halfday")
        ->selectRaw("CASE
            WHEN DATEPART(hour, cast(sched.time_sched as time)) - DATEPART(hour, cast(emp.in1 as time)) > 2 THEN 'UNDERTIME'
            ELSE '-'
        END as undertimer")
        ->selectRaw("CASE
            WHEN ROUND(emp.hours_work, 0) = 0 THEN 'ABSENT'
            ELSE '-'
        END as absent")
        ->selectRaw("CASE
            WHEN DATEPART(hour, cast(emp.in1 as time)) >= 10 THEN '1'
            ELSE '-'
        END as night_dif")
        ->join('employee_schedule_posts as sched', function ($join) {
            $join->on('emp.employee_no', '=', 'sched.employee_no')
                ->on('emp.date', '=', 'sched.date_sched');
        })
        ->get();
        }

    public function importdata(Request $request)
    {
        $employee_upload_attendances = DB::table('employee_upload_attendances')
                ->get();

                return DataTables::of($employee_upload_attendances)
                ->make(true);
    }


    /*--------------------------------------------------------------
    # UPLOAD EMPLOYEE ATTENDANCE
    --------------------------------------------------------------*/
    public function importA(Request $request)
    {

        $importpass = DB::table('employee_upload_attendances')->count();

        $count = (int)$importpass;

        $file = request('file');

        try{
        if($count < 1)
        {

                $statement = "

                BULK INSERT dbo.employee_upload_attendances
                FROM '//Progenx\PAYROLL SYSTEM\\".$file."'
                WITH
                (
                FIRSTROW = 2,
                FIELDTERMINATOR = ',', 
                ROWTERMINATOR = '\n'
                )
                ";


                DB::statement($statement);

                //LOGS
                Log::info('Employee attendance have been imported successfully!');

                DB::table('statuslogs')->insert([
                    'linecode' => 'attendance',
                    'functions' => 'Employee attendance have been imported successfully!',
                    'modifieddate' => now(),
                ]);

                return back()->with('success', 'Employee attendance have been imported successfully!');
                
        }
        else{

                //LOGS
                Log::error('Data import issue: Please remove your current data before proceeding with the import.');

                DB::table('statuslogs')->insert([
                    'linecode' => 'attendance',
                    'functions' => 'Data import issue: Please remove your current data before proceeding with the import.',
                    'modifieddate' => now(),
                ]);

                return back()->with('error', 'Data import issue: Please remove your current data before proceeding with the import.');
        }
        }
        catch(\Exception $e){
            Log::info($e->getMessage());

                $statuslogs = "
                INSERT INTO statuslogs (linecode, functions, modifieddate) values ('attendance', 'ERROR FILES', getdate())
                ";
                DB::statement($statuslogs);

            return back()->with('exception', $e->getMessage());
        }

        
    }

    public function fixedA(Request $request)
    {

        return view('HR.Import_Attendance');
    }

    /*--------------------------------------------------------------
    # REMOVE THE RECENTLY UPLOADED EMPLOYEE ATTENDANCE 
    --------------------------------------------------------------*/

    public function clearA(Request $request)
    {
        try{
            DB::table('employee_upload_attendances')->truncate();

            //LOGS
            Log::info('Data has been successfully cleared!');

            DB::table('statuslogs')->insert([
                'linecode' => 'attendance',
                'functions' => 'Data has been successfully cleared!',
                'modifieddate' => now(),
            ]);

            return back()->with('success', 'Data has been successfully cleared!');
        }
        catch(\Exception $e){

                //LOGS
                Log::info($e);

                $statuslogs = "
                INSERT INTO statuslogs (linecode, functions, modifieddate) values ('attendance', 'ERROR FILES', getdate())
                ";
                DB::statement($statuslogs);

            return back()->with('exception', $e->getMessage());
        }
    }


    /*--------------------------------------------------------------
    # POST EMPLOYEE ATTENDANCE
    --------------------------------------------------------------*/ 

    public function palA(Request $request)
    {
        try{
        $fromdate = request('fromdate');
        $todate = request('todate');


        $importpass1 = DB::table('employee_upload_attendances')
        ->select(DB::raw("count(*) as attendance"))
        ->count();

        $count1 = (int)$importpass1;

        if($count1 > 0){
            DB::table('employee_attendance_savestates')
            ->insertUsing(['employee_no', 'date', 'day', 'in1', 'out1', 'in2', 'out2', 'nextday', 'hours_work'], function ($query) use ($fromdate, $todate) {
                $query->select(['employee_no', 'date', 'day', 'in1', 'out1', 'in2', 'out2', 'nextday', 'hours_work'])
                    ->from('employee_upload_attendances')
                    ->whereBetween(DB::raw('CAST(date AS DATE)'), [$fromdate, $todate]);
            });

                //LOGS
                /* Log::info('Insert employee details into ECR');

                DB::table('employee_attendance_savestates_logs')->select(['employee_no', 'date', 'day', 'in1', 'out1', 'in2', 'out2', 'nextday', 'hours_work'])
                ->from('employee_upload_attendances')
                ->whereBetween(DB::raw('CAST(date AS DATE)'), [$fromdate, $todate])
                ->insertUsing([
                    'employee_no', 'date', 'day', 'in1', 'out1', 'in2', 'out2', 'nextday', 'hours_work'
                ]);
 */
                Log::info('Insert employee details into ECR logs');
                return back()->with('success', 'Data has been successfully processed!');

                $statement = "
                INSERT INTO employee_attendance_savestates(employee_no, date, day, in1, out1, in2, out2, nextday, hours_work) SELECT employee_no, date, day, in1, out1, in2, out2, nextday, hours_work FROM employee_upload_attendances
                where cast(date as date) between '$fromdate' and '$todate' 
                ";
                DB::statement($statement);

                DB::table('employee_upload_attendances')
                ->where('location', 'like', '%MAIN%')
                ->delete();

                //LOGS
                Log::info('Clean the data of employee_upload_attendances.');

                DB::table('statuslogs')->insert([
                'linecode' => 'attendance',
                'functions' => 'Clean the data of employee_upload_attendances.',
                'modifieddate' => now(),
                ]);

                return back()->with('success', 'Data has been successfully cleaned.');

                DB::table('employee_attendance_savestates')
                ->whereNotNull('in1')
                ->whereNull('out1')
                ->whereNull('in2')
                ->whereNull('out2')
                ->whereNotNull('nextday')
                ->whereRaw("CAST(DATEPART(hour, CAST(in1 AS TIME)) AS INT) > 19")
                ->update([
                    'out2' => DB::raw('nextday'),
                    'nextday' => null,
                    'remarks' => 'AF/NIGHTSHIFT',
                ]);

                //LOGS
                Log::info('Filter Night Shift');

                DB::table('employee_attendance_savestates_logs')
                ->whereNotNull('in1')
                ->whereNull('out1')
                ->whereNull('in2')
                ->whereNull('out2')
                ->whereNotNull('nextday')
                ->whereRaw("CAST(DATEPART(hour, CAST(in1 AS TIME)) AS INT) > 19")
                ->update([
                    'out2' => DB::raw('nextday'),
                    'nextday' => null,
                    'remarks' => 'AF/NIGHTSHIFT',
                ]);

                //LOGS
                Log::info('Filter Night Shift 2');

                return back()->with('success', 'Night shift filtering completed successfully.');

                DB::table('employee_attendance_savestates')
                ->whereNotNull('in1')
                ->whereNull('out1')
                ->whereNotNull('in2')
                ->whereNull('out2')
                ->whereNull('nextday')
                ->update([
                    'out2' => DB::raw('in2'),
                    'in2' => null,
                    'remarks' => 'AF/WRONGPUNCH',
                ]);

                //LOGS
                Log::info('Autofix Wrong Punch');

                DB::table('employee_attendance_savestates_logs')
                ->whereNotNull('in1')
                ->whereNull('out1')
                ->whereNotNull('in2')
                ->whereNull('out2')
                ->whereNull('nextday')
                ->update([
                    'out2' => DB::raw('in2'),
                    'in2' => null,
                    'remarks' => 'AF/WRONGPUNCH',
                ]);

                //LOGS
                Log::info('Autofix Wrong Punch 2');

                return back()->with('success', 'Wrong punch autofix completed successfully.');

                DB::table('employee_attendance_savestates')
                ->whereNotNull('in1')
                ->whereNotNull('out1')
                ->whereNull('in2')
                ->whereNull('out2')
                ->whereNull('nextday')
                ->whereRaw("CAST(hours_work AS FLOAT) > 0")
                ->update([
                    'out2' => DB::raw('out1'),
                    'out1' => null,
                    'remarks' => 'AF/HALFDAY',
                ]);

                //LOGS
                Log::info('Autofix AF/HALFDAY');

                DB::table('employee_attendance_savestates_logs')
                ->whereNotNull('in1')
                ->whereNotNull('out1')
                ->whereNull('in2')
                ->whereNull('out2')
                ->whereNull('nextday')
                ->whereRaw("CAST(hours_work AS FLOAT) > 0")
                ->update([
                    'out2' => DB::raw('out1'),
                    'out1' => null,
                    'remarks' => 'AF/HALFDAY',
                ]);

                //LOGS
                Log::info('Autofix AF/HALFDAY 2');

                return back()->with('success', 'Half-day autofix completed successfully.');
        
                DB::table('employee_attendance_savestates')
                ->where(function ($query) {
                    $query->where('hours_work', '0.00')
                        ->whereNotNull('in1')
                        ->whereNull('in2')
                        ->whereNull('out1')
                        ->whereNull('out2')
                        ->orWhere('hours_work', '0.00')
                        ->whereNull('in1')
                        ->whereNotNull('in2')
                        ->whereNull('out1')
                        ->whereNull('out2')
                        ->orWhere('hours_work', '0.00')
                        ->whereNull('in1')
                        ->whereNull('in2')
                        ->whereNotNull('out1')
                        ->whereNull('out2')
                        ->orWhere('hours_work', '0.00')
                        ->whereNull('in1')
                        ->whereNull('in2')
                        ->whereNull('out1')
                        ->whereNotNull('out2');
                })
                ->update(['remarks' => 'AF/NTI/NTO']);

                //LOGS
                Log::info('Filter no working hours');

                DB::table('employee_attendance_savestates_logs')
                ->where(function ($query) {
                    $query->where('hours_work', '0.00')
                        ->whereNotNull('in1')
                        ->whereNull('in2')
                        ->whereNull('out1')
                        ->whereNull('out2')
                        ->orWhere('hours_work', '0.00')
                        ->whereNull('in1')
                        ->whereNotNull('in2')
                        ->whereNull('out1')
                        ->whereNull('out2')
                        ->orWhere('hours_work', '0.00')
                        ->whereNull('in1')
                        ->whereNull('in2')
                        ->whereNotNull('out1')
                        ->whereNull('out2')
                        ->orWhere('hours_work', '0.00')
                        ->whereNull('in1')
                        ->whereNull('in2')
                        ->whereNull('out1')
                        ->whereNotNull('out2');
                })
                ->update(['remarks' => 'AF/NTI/NTO']);

                //LOGS
                Log::info('Filter no working hours 2');

                return back()->with('success', 'No working hours autofix completed successfully.');

                DB::table('employee_attendance_savestates')
                ->whereNotNull('in1')
                ->whereNull('out1')
                ->whereNull('in2')
                ->whereNull('out2')
                ->whereNotNull('nextday')
                ->whereRaw("CAST(DATEPART(hour, CAST(in1 AS TIME)) AS INT) < 20")
                ->update([
                    'out2' => DB::raw('nextday'),
                    'nextday' => null,
                    'remarks' => 'AF/NEXTDAY',
                ]);

                //LOGS
                Log::info('Autofix Wrong Punch (NEXTDAY)');

                DB::table('employee_attendance_savestates_logs')
                ->whereNotNull('in1')
                ->whereNull('out1')
                ->whereNull('in2')
                ->whereNull('out2')
                ->whereNotNull('nextday')
                ->whereRaw("CAST(DATEPART(hour, CAST(in1 AS TIME)) AS INT) < 20")
                ->update([
                    'out2' => DB::raw('nextday'),
                    'nextday' => null,
                    'remarks' => 'AF/NEXTDAY',
                ]);

                //LOGS
                Log::info('Autofix Wrong Punch (NEXTDAY) 2');

                return back()->with('success', 'Wrong punch autofix (NEXTDAY) completed successfully.');
            
                DB::table('employee_attendance_savestates')
                ->whereNull('in1')
                ->whereNull('in2')
                ->whereNull('out1')
                ->whereNull('out2')
                ->whereNull('nextday')
                ->delete();

                //LOGS
                Log::info('Delete instances with no time in and time out.');

                DB::table('employee_attendance_savestates_logs')
                ->whereNull('in1')
                ->whereNull('in2')
                ->whereNull('out1')
                ->whereNull('out2')
                ->whereNull('nextday')
                ->delete();

                //LOGS
                Log::info('Delete instances with no time in and time out. 2');

                return back()->with('success', 'Instances with no time in and time out have been successfully deleted.');


                // Update 'employee_attendance_savestates' to perform an autofix for wrong punches (7)
                DB::table('employee_attendance_savestates')
                ->whereNotNull('in1')
                ->whereNull('out1')
                ->whereNotNull('in2')
                ->whereNull('out2')
                ->whereNull('nextday')
                ->update([
                    'out2' => DB::raw('in2'),
                    'in2' => null,
                    'remarks' => 'AF/WRONGPUNCH',
                ]);

                // Log the action in 'statuslogs'
                Log::info('Autofix AF/WRONGPUNCH (7)');

                // Update 'employee_attendance_savestates_logs' to perform an autofix for wrong punches (7)
                DB::table('employee_attendance_savestates_logs')
                ->whereNotNull('in1')
                ->whereNull('out1')
                ->whereNotNull('in2')
                ->whereNull('out2')
                ->whereNull('nextday')
                ->update([
                    'out2' => DB::raw('in2'),
                    'in2' => null,
                    'remarks' => 'AF/WRONGPUNCH',
                ]);

                // Log the action in 'statuslogs'
                Log::info('Autofix AF/WRONGPUNCH (7) 2');

                return back()->with('success', 'Wrong punch autofix (7) completed successfully.');

                DB::table('employee_attendance_savestates')
                ->whereNull('in1')
                ->whereNotNull('out1')
                ->whereNull('in2')
                ->whereNotNull('out2')
                ->whereNull('nextday')
                ->update([
                    'in1' => DB::raw('out1'),
                    'in2' => null,
                    'remarks' => 'AF/WRONGPUNCH',
                ]);

                //LOGS
                Log::info('Autofix AF/WRONGPUNCH (8)');

                DB::table('employee_attendance_savestates_logs')
                ->whereNull('in1')
                ->whereNotNull('out1')
                ->whereNull('in2')
                ->whereNotNull('out2')
                ->whereNull('nextday')
                ->update([
                    'in1' => DB::raw('out1'),
                    'in2' => null,
                    'remarks' => 'AF/WRONGPUNCH',
                ]);

                //LOGS
                Log::info('Autofix AF/WRONGPUNCH (8) 2');

                return back()->with('success', 'Wrong punch autofix (8) completed successfully.');


                $blank = DB::table('employee_attendance_savestates')
                ->select(DB::raw("count(*) as attendance"))
                ->count();

                $count123 = (int)$blank;

                //LOGS
                Log::info('Data records successfully saved!');

                $statuslogs = [
                    'linecode' => 'attendance',
                    'functions' => "$count123 data records successfully saved!",
                    'modifieddate' => now(),
                ];
                DB::table('statuslogs')->insert($statuslogs);

                return back()->with('success', "$count123 data records successfully saved!");

                }else{

                //LOGS
                Log::info('The data is invalid');

                // Insert an entry into the 'statuslogs' table
                $statuslogs = [
                    'linecode' => 'attendance',
                    'functions' => 'The data is invalid',
                    'modifieddate' => now(),
                ];
                DB::table('statuslogs')->insert($statuslogs);

                // Return an error message to the user interface
                return back()->with('error', 'INVALID');
        }

    }catch(\Exception $e){

            //LOGS
            Log::info($e);

            $statuslogs = "
            INSERT INTO statuslogs (linecode, functions, modifieddate) values ('attendance', 'DATA ERROR', getdate())
            ";
            DB::statement($statuslogs);

            return back()->with('exception', $e->getMessage());
    }
        
    }
}
