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
                FROM '//Progenx\PAYROLL SYSTEM\Attendance\\".$file."'
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
    
    
            $importpass1 = DB::table('employee_attendance_savestates')
            ->select(DB::raw("count(*) as attendance"))
            ->count();
    
            $count1 = (int)$importpass1;
    
            if($count1 <= 0){

                /*--------------------------------------------------------------
                # INSERT DATA TO EMPLOYEE_ATTENDANCE_SAVESTATE
                --------------------------------------------------------------*/
               /*  $dataToInsert = DB::table('employee_upload_attendances')
                    ->select([
                        'employee_no', 'date', 'day', 'in1', 'out1', 'in2', 'out2', 'nextday', 'hours_work'
                    ])
                    ->whereRaw("cast(date as date) between ? and ?", [$fromdate, $todate])
                    ->get(); */

                /* if (!$dataToInsert->isEmpty()) {
                    $dataToInsert = $dataToInsert->map(function ($item) {
                        return (array)$item;
                    })->toArray();

                    DB::table('employee_attendance_savestates')->insert($dataToInsert);
                } */





                  // Assuming you have a query builder instance, such as $queryBuilder
                  $statement = "
                    INSERT INTO employee_attendance_savestates(employee_no, date, day, in1, out1, in2, out2, nextday, hours_work) SELECT employee_no, date, day, in1, out1, in2, out2, nextday, hours_work FROM employee_upload_attendances
                    
                    ";
                    DB::statement($statement);















    
                //LOGS
                Log::info('Insert employee details into ECR');

                /*--------------------------------------------------------------
                # Insert a record into the 'statuslogs' table
                --------------------------------------------------------------*/
                DB::table('statuslogs')->insert([
                    'linecode' => 'attendance',
                    'functions' => 'Insert employee details into ECR',
                    'modifieddate' => now(),
                ]);

                /* DB::table('employee_attendance_savestates_logs')
                    ->select('employee_no', 'date', 'day', 'in1', 'out1', 'in2', 'out2', 'nextday', 'hours_work')
                    ->insertUsing(
                        ['employee_no', 'date', 'day', 'in1', 'out1', 'in2', 'out2', 'nextday', 'hours_work'],
                        function ($query) use ($fromdate, $todate) {
                            $query->select('employee_no', 'date', 'day', 'in1', 'out1', 'in2', 'out2', 'nextday', 'hours_work')
                                ->from('employee_upload_attendances')
                                ->whereBetween(DB::raw('CAST(date AS DATE)'), [$fromdate, $todate]);
                        }
                    );
                
                //LOGS
                Log::info('Insert employee details into ECR logs');

                $statuslogs = "
                INSERT INTO statuslogs (linecode, functions, modifieddate) values ('attendance', 'Insert employee details into ECR logs', getdate())
                ";
                DB::statement($statuslogs); */


    
                /*--------------------------------------------------------------
                # Delete records from 'employee_upload_attendances' table
                --------------------------------------------------------------*/
                DB::table('employee_upload_attendances')
                    ->where('location', 'like', 'MAIN%')
                    ->delete();

                //LOGS
                Log::info('Clean the data of employee_upload_attendances.');

                DB::table('statuslogs')->insert([
                    'linecode' => 'attendance',
                    'functions' => 'Clean the data of employee_upload_attendances.',
                    'modifieddate' => now(), 
                ]);

    
                /*--------------------------------------------------------------
                # AUTOFIX 1: AF/NIGHTSHIFT
                --------------------------------------------------------------*/
                DB::table('employee_attendance_savestates')
                ->whereNotNull('in1')
                ->whereNull('out1')
                ->whereNull('in2')
                ->whereNull('out2')
                ->whereNotNull('nextday')
                ->whereRaw("CAST(DATEPART(hour, CAST(in1 AS time)) AS int) > 19")
                ->update([
                    'out2' => DB::raw('nextday'),
                    'nextday' => null,
                    'remarks' => 'AF/NIGHTSHIFT',
                ]);

                //LOGS
                Log::info('Filter Night Shift');

                DB::table('statuslogs')->insert([
                'linecode' => 'attendance',
                'functions' => 'Filter Night Shift',
                'modifieddate' => now(),
                ]);

                /*--------------------------------------------------------------
                # Update 'employee_attendance_savestates_logs' table
                --------------------------------------------------------------*/
                DB::table('employee_attendance_savestates_logs')
                ->whereNotNull('in1')
                ->whereNull('out1')
                ->whereNull('in2')
                ->whereNull('out2')
                ->whereNotNull('nextday')
                ->whereRaw("CAST(DATEPART(hour, CAST(in1 AS time)) AS int) > 19")
                ->update([
                    'out2' => DB::raw('nextday'),
                    'nextday' => null,
                    'remarks' => 'AF/NIGHTSHIFT',
                ]);

                //LOGS
                Log::info('Filter Night Shift 2');

                DB::table('statuslogs')->insert([
                'linecode' => 'attendance',
                'functions' => 'Filter Night Shift 2',
                'modifieddate' => now(),
                ]);


                /*--------------------------------------------------------------
                # AUTOFIX 2: AF/WRONGPUNCH
                --------------------------------------------------------------*/
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
                DB::table('statuslogs')->insert([
                'linecode' => 'attendance',
                'functions' => 'Autofix Wrong Punch',
                'modifieddate' => now(), 
                ]);

                /*--------------------------------------------------------------
                # Update 'employee_attendance_savestates_logs' table
                --------------------------------------------------------------*/
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
                DB::table('statuslogs')->insert([
                'linecode' => 'attendance',
                'functions' => 'Autofix Wrong Punch 2',
                'modifieddate' => now(), 
                ]);

    
                /*--------------------------------------------------------------
                # AUTOFIX 3: AF/HALFDAY
                --------------------------------------------------------------*/
                DB::table('employee_attendance_savestates')
                ->whereNotNull('in1')
                ->whereNotNull('out1')
                ->whereNull('in2')
                ->whereNull('out2')
                ->whereNull('nextday')
                ->whereRaw("CAST(hours_work AS float) > 0")
                ->update([
                    'out2' => DB::raw('out1'),
                    'out1' => null,
                    'remarks' => 'AF/HALFDAY',
                ]);

                // LOGS
                Log::info('Autofix AF/HALFDAY');
                DB::table('statuslogs')->insert([
                'linecode' => 'attendance',
                'functions' => 'Autofix AF/HALFDAY',
                'modifieddate' => now(), 
                ]);

                /*--------------------------------------------------------------
                # Update 'employee_attendance_savestates_logs' table
                --------------------------------------------------------------*/
                DB::table('employee_attendance_savestates_logs')
                ->whereNotNull('in1')
                ->whereNotNull('out1')
                ->whereNull('in2')
                ->whereNull('out2')
                ->whereNull('nextday')
                ->whereRaw("CAST(hours_work AS float) > 0")
                ->update([
                    'out2' => DB::raw('out1'),
                    'out1' => null,
                    'remarks' => 'AF/HALFDAY',
                ]);

                //LOGS
                Log::info('Autofix AF/HALFDAY 2');
                DB::table('statuslogs')->insert([
                'linecode' => 'attendance',
                'functions' => 'Autofix AF/HALFDAY 2',
                'modifieddate' => now(),
                ]);
    
                
                
                /*--------------------------------------------------------------
                # AUTOFIX 4: Filter no working hours
                --------------------------------------------------------------*/
                /* DB::table('employee_attendance_savestates')
                ->whereNull('hours_work')
                ->orWhere('hours_work', 0)
                ->orWhere('hours_work', '0.00')
                ->update([
                    'hours_work' => DB::raw('DATEPART(hour, CAST(out2 AS time)) - DATEPART(hour, CAST(in1 AS time))'),
                ]); */

                // LOGS
                /* Log::info('Filter no working hours');
                DB::table('statuslogs')->insert([
                'linecode' => 'attendance',
                'functions' => 'Filter no working hours',
                'modifieddate' => now(),
                ]); */

                /*--------------------------------------------------------------
                # Update 'employee_attendance_savestates_logs' table
                --------------------------------------------------------------*/
                /* DB::table('employee_attendance_savestates_logs')
                ->whereNull('hours_work')
                ->orWhere('hours_work', 0)
                ->orWhere('hours_work', '0.00')
                ->update([
                    'hours_work' => DB::raw('DATEPART(hour, CAST(out2 AS time)) - DATEPART(hour, CAST(in1 AS time))'),
                ]); */

                //LOGS
                /* Log::info('Filter no working hours 2');
                DB::table('statuslogs')->insert([
                'linecode' => 'attendance',
                'functions' => 'Filter no working hours 2',
                'modifieddate' => now(),
                ]); */



                /*--------------------------------------------------------------
                # AUTOFIX 5: AF/NEXTDAY
                --------------------------------------------------------------*/
                DB::table('employee_attendance_savestates')
                ->whereNotNull('in1')
                ->whereNull('out1')
                ->whereNull('in2')
                ->whereNull('out2')
                ->whereNotNull('nextday')
                ->whereRaw("CAST(DATEPART(hour, CAST(in1 AS time)) AS int) < 20")
                ->update([
                    'out2' => DB::raw('nextday'),
                    'nextday' => null,
                    'remarks' => 'AF/NEXTDAY',
                ]);

                //LOGS
                Log::info('Autofix Wrong Punch (NEXTDAY)');
                DB::table('statuslogs')->insert([
                'linecode' => 'attendance',
                'functions' => 'Autofix Wrong Punch (NEXTDAY)',
                'modifieddate' => now(),
                ]);

                /*--------------------------------------------------------------
                # Update 'employee_attendance_savestates_logs' table
                --------------------------------------------------------------*/
                DB::table('employee_attendance_savestates_logs')
                ->whereNotNull('in1')
                ->whereNull('out1')
                ->whereNull('in2')
                ->whereNull('out2')
                ->whereNotNull('nextday')
                ->whereRaw("CAST(DATEPART(hour, CAST(in1 AS time)) AS int) < 20")
                ->update([
                    'out2' => DB::raw('nextday'),
                    'nextday' => null,
                    'remarks' => 'AF/NEXTDAY',
                ]);

                //LOGS
                Log::info('Autofix Wrong Punch (NEXTDAY) 2');
                DB::table('statuslogs')->insert([
                'linecode' => 'attendance',
                'functions' => 'Autofix Wrong Punch (NEXTDAY) 2',
                'modifieddate' => now(),
                ]);

                
                /*--------------------------------------------------------------
                # AUTOFIX 6: Delete instances with no time in and time out
                --------------------------------------------------------------*/
                DB::table('employee_attendance_savestates')
                ->whereNull('in1')
                ->whereNull('in2')
                ->whereNull('out1')
                ->whereNull('out2')
                ->whereNull('nextday')
                ->delete();

                //LOGS
                Log::info('Delete instances with no time in and time out.');
                DB::table('statuslogs')->insert([
                'linecode' => 'attendance',
                'functions' => 'Delete instances with no time in and time out.',
                'modifieddate' => now(),
                ]);
                

                /*--------------------------------------------------------------
                # Update 'employee_attendance_savestates_logs' table
                --------------------------------------------------------------*/
                DB::table('employee_attendance_savestates_logs')
                ->whereNull('in1')
                ->whereNull('in2')
                ->whereNull('out1')
                ->whereNull('out2')
                ->whereNull('nextday')
                ->delete();

                //LOGS
                Log::info('Delete instances with no time in and time out. 2');
                DB::table('statuslogs')->insert([
                'linecode' => 'attendance',
                'functions' => 'Delete instances with no time in and time out. 2',
                'modifieddate' => now(),
                ]);               


                
                /*--------------------------------------------------------------
                # AUTOFIX 7: AF/WRONGPUNCH
                --------------------------------------------------------------*/
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
                Log::info('Autofix AF/WRONGPUNCH (7)');
                DB::table('statuslogs')->insert([
                'linecode' => 'attendance',
                'functions' => 'Autofix AF/WRONGPUNCH (7)',
                'modifieddate' => now(),
                ]);

                /*--------------------------------------------------------------
                # Update 'employee_attendance_savestates_logs' table
                --------------------------------------------------------------*/
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
                Log::info('Autofix AF/WRONGPUNCH (7) 2');
                DB::table('statuslogs')->insert([
                'linecode' => 'attendance',
                'functions' => 'Autofix AF/WRONGPUNCH (7) 2',
                'modifieddate' => now(),
                ]);


                
                /*--------------------------------------------------------------
                # AUTOFIX 8: AF/WRONGPUNCH
                --------------------------------------------------------------*/
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
                DB::table('statuslogs')->insert([
                'linecode' => 'attendance',
                'functions' => 'Autofix AF/WRONGPUNCH (8)',
                'modifieddate' => now(),
                ]);

                /*--------------------------------------------------------------
                # Update 'employee_attendance_savestates_logs' table
                --------------------------------------------------------------*/
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
                DB::table('statuslogs')->insert([
                'linecode' => 'attendance',
                'functions' => 'Autofix AF/WRONGPUNCH (8) 2',
                'modifieddate' => now(),
                ]);


                /*--------------------------------------------------------------
                # GET SCHEDULE AND IMPORT TO EMPLOYEE ATTENDANCE POST
                --------------------------------------------------------------*/
                /* DB::table('employee_attendance_posts as a')
                ->leftJoin('employee_schedule_posts as b', function ($join) {
                    $join->on('a.employee_no', '=', 'b.employee_no')
                        ->on('a.date', '=', 'b.date_sched');
                })
                ->where('a.in1', '!=', '00:00:00.0000000')
                ->where('a.out2', '!=', '00:00:00.0000000')
                ->update([
                    'a.schedin' => DB::raw('b.time_sched'),
                    'a.schedout' => DB::raw('b.time_sched_out'),
                ]); */

                /* $update1 = "
                UPDATE a
                SET
                a.schedin = b.time_sched,
                a.schedout = b.time_sched_out
                FROM employee_attendance_posts a
                left JOIN
                employee_schedule_posts b
                on a.employee_no = b.employee_no
                and a.date = b.date_sched where a.in1 != '00:00:00.0000000' and a.out2 != '00:00:00.0000000'
                ";
                DB::statement($update1);

                //LOGS
                Log::info('GET SCHEDULE AND IMPORT TO EMPLOYEE ATTENDANCE POST');
                DB::table('statuslogs')->insert([
                'linecode' => 'attendance',
                'functions' => 'GET SCHEDULE AND IMPORT TO EMPLOYEE ATTENDANCE POST',
                'modifieddate' => now(),
                ]); */

                /*--------------------------------------------------------------
                # GET CTLATE
                --------------------------------------------------------------*/
                /* DB::table('employee_attendance_posts')
                ->update([
                    'ctlate' => DB::raw("CASE WHEN schedin != '' THEN CAST(DATEPART(HOUR, in1) AS FLOAT) - CAST(DATEPART(HOUR, schedin) AS FLOAT) ELSE '0' END"),
                ]); */

                /* $update2 = "
                update employee_attendance_posts set 
                ctlate = case when schedin != '' then cast(datepart(HOUR, in1) as float) - cast(datepart(HOUR, schedin) as float)
                else '0' end
                ";
                DB::statement($update2);

                //LOGS
                Log::info('GET CTLATE');
                DB::table('statuslogs')->insert([
                'linecode' => 'attendance',
                'functions' => 'GET CTLATE',
                'modifieddate' => now(),
                ]); */

                /*--------------------------------------------------------------
                # TOTAL RECORDS
                --------------------------------------------------------------*/
    
                $blank = DB::table('employee_attendance_savestates')
                ->select(DB::raw("count(*) as attendance"))
                ->count();
    
                $count123 = (int)$blank;
    
                //LOGS
                Log::info('Data records successfully saved!');
                $statuslogs = [
                    'linecode' => 'attendance',
                    'functions' => $count123 . ' data records successfully saved!',
                    'modifieddate' => now(), 
                ];

                DB::table('statuslogs')->insert($statuslogs);
                
                return back()->with('success',"$count123 data records successfully saved!");
                
            }else{
    
                    /* LOGS */
                    Log::info('You have an existing data!');
    
                    $statuslogs = "
                    INSERT INTO statuslogs (linecode, functions, modifieddate) values ('attendance', 'You have an existing data!', getdate())
                    ";
                    DB::statement($statuslogs);
    
                return back()->with('error','You have an existing data!');
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
