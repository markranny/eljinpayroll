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
use App\employee_attendances;
use App\employee_attendance_posts;
use App\employee_final_attendance_posts;
use App\employees_detail_temps;
use App\employee_attendances_logs;
use App\employee_attendance_posts_logs;
use App\employee_final_attendance_posts_logs;
use App\employees_detail_temps_logs;
use App\employee_upload_attendances;
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
        $employees = DB::table('employees')
                    ->orderBy('lastname', 'ASC')
                    ->get();

        /* return view('HR.Import_Attendance'); */

        return view('HR.Import_Attendance', compact('employees'));
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
                /* $employee_upload_attendances = DB::table('employee_upload_attendances')
                ->get();

                return DataTables::of($employee_upload_attendances)
                ->make(true); */

                $employee_upload_attendances = DB::table('employee_upload_attendances as a')
                ->join('employees as b', 'a.employee_no', '=', 'b.employee_no')
                ->select(
                    'b.employee_no',
                    'b.fullname',
                    'a.date',
                    'a.day',
                    'a.in1',
                    'a.out1',
                    'a.in2',
                    'a.out2',
                    'a.nextday',
                    'a.hours_work',
                    'a.location'
                )
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
        $fromdate = request('fromdate');
        $todate = request('todate');

        try{
        if($count < 1)
        {

                /* $statement = "
                BULK INSERT dbo.employee_upload_attendances
                FROM '//Progenx\PAYROLL SYSTEM\Attendance\\".$file."'
                WITH
                (
                FIRSTROW = 2,
                FIELDTERMINATOR = ',', 
                ROWTERMINATOR = '\n'
                )
                "; */




                /* $statement = 
                "
                WITH DailyLogs AS (
                    SELECT 
                        Reference AS EmployeeNo,
                        CONVERT(DATE, RecordDate) AS Date,
                        FORMAT(RecordDate, 'dddd') AS Day,
                        MIN(CASE WHEN Type = 1 THEN FORMAT(ActualTime, 'HH:mm') END) AS In1,
                        MIN(CASE WHEN Type = 1 THEN ActualTime END) AS InTime,
                        MAX(CASE WHEN Type = 2 AND ActualTime <= '12:00' THEN FORMAT(ActualTime, 'HH:mm') END) AS LunchOut,
                        MAX(CASE WHEN Type = 2 AND ActualTime <= '12:00' THEN ActualTime END) AS LunchOutTime,
                        CASE 
                            WHEN MIN(CASE WHEN Type = 1 THEN ActualTime END) IS NOT NULL 
                                 AND MAX(CASE WHEN Type = 2 AND ActualTime <= '12:00' THEN ActualTime END) IS NULL THEN NULL 
                            ELSE MAX(CASE WHEN Type = 1 AND ActualTime > '12:00' THEN FORMAT(ActualTime, 'HH:mm') END) 
                        END AS AfternoonIn1,
                        MAX(CASE WHEN Type = 1 AND ActualTime > '12:00' THEN ActualTime END) AS AfternoonInTime,
                        MAX(CASE WHEN Type = 2 AND ActualTime > '12:00' THEN FORMAT(ActualTime, 'HH:mm') END) AS Out,
                        MAX(CASE WHEN Type = 2 AND ActualTime > '12:00' THEN ActualTime END) AS OutTime
                    FROM [C:\PROGRAMDATA\TOUCHLINK TIME RECORDER 3\TA3.MDF].[dbo].timelogs
                    WHERE 
                        RecordDate BETWEEN '".$fromdate."' AND '".$todate."'
                    GROUP BY 
                        Reference,
                        CONVERT(DATE, RecordDate),
                        FORMAT(RecordDate, 'dddd')
                ),
                NextDayLogs AS (
                    SELECT
                        t1.EmployeeNo,
                        t1.Date,
                        t1.Day,
                        t1.In1,
                        t1.LunchOut,
                        t1.AfternoonIn1,
                        COALESCE(t1.Out, MAX(FORMAT(t2.ActualTime, 'HH:mm'))) AS Out,
                        t1.InTime,
                        t1.LunchOutTime,
                        t1.AfternoonInTime,
                        COALESCE(t1.OutTime, MAX(t2.ActualTime)) AS OutTime,
                        MAX(FORMAT(t2.ActualTime, 'HH:mm')) AS NextDayOut,
                        DATEDIFF(MINUTE, t1.InTime, COALESCE(t1.OutTime, GETDATE())) / 60.0 AS Hours_Work
                    FROM DailyLogs t1
                    LEFT JOIN [C:\PROGRAMDATA\TOUCHLINK TIME RECORDER 3\TA3.MDF].[dbo].timelogs t2 ON t1.EmployeeNo = t2.Reference
                        AND CONVERT(DATE, t2.RecordDate) = DATEADD(DAY, 1, t1.Date)
                        AND t2.Type = 2
                    GROUP BY
                        t1.EmployeeNo,
                        t1.Date,
                        t1.Day,
                        t1.In1,
                        t1.LunchOut,
                        t1.AfternoonIn1,
                        t1.Out,
                        t1.InTime,
                        t1.LunchOutTime,
                        t1.AfternoonInTime,
                        t1.OutTime
                )
                INSERT INTO employee_upload_attendances (employee_no, date, day, in1, out1, in2, out2, nextday, hours_work, location)
                SELECT
                    EmployeeNo,
                    Date,
                    Day,
                    In1,
                    LunchOut,
                    AfternoonIn1,
                    CASE 
                        WHEN DATEPART(HOUR, CAST(In1 AS TIME)) >= 0 AND DATEPART(HOUR, CAST(In1 AS TIME)) <= 16 THEN Out
                        ELSE NextDayOut 
                    END AS Out,
                    CASE 
                        WHEN DATEPART(HOUR, CAST(In1 AS TIME)) >= 0 AND DATEPART(HOUR, CAST(In1 AS TIME)) <= 16 THEN NULL
                        ELSE NextDayOut 
                    END AS NextDay,
                    DATEDIFF(MINUTE, 
                        CAST(CONVERT(VARCHAR, Date, 111) + ' ' + In1 AS DATETIME), 
                        CASE 
                            WHEN Out >= In1 THEN CAST(CONVERT(VARCHAR, Date, 111) + ' ' + 
                                CASE 
                                    WHEN DATEPART(HOUR, CAST(In1 AS TIME)) >= 0 AND DATEPART(HOUR, CAST(In1 AS TIME)) <= 16 THEN Out
                                    ELSE NextDayOut 
                                END AS DATETIME)
                            ELSE DATEADD(DAY, 1, CAST(CONVERT(VARCHAR, Date, 111) + ' ' + 
                                CASE 
                                    WHEN DATEPART(HOUR, CAST(In1 AS TIME)) >= 0 AND DATEPART(HOUR, CAST(In1 AS TIME)) <= 16 THEN Out
                                    ELSE NextDayOut 
                                END AS DATETIME))
                        END
                    ) / 60.0 AS Hours_Worked,
                    'MAIN' AS Location
                FROM NextDayLogs
                WHERE Hours_Work IS NOT NULL
                ORDER BY
                    EmployeeNo,
                    Date;
                
                
                "; */











                $statement = "
                WITH DailyLogs AS (
                    SELECT 
                        EmployeeID AS EmployeeNo,
                        CONVERT(DATE, ActualTime) AS Date,
                        FORMAT(ActualTime, 'dddd') AS Day,
                        MIN(CASE WHEN LogStatus = 1 THEN FORMAT(ActualTime, 'HH:mm') END) AS In1,
                        MIN(CASE WHEN LogStatus = 1 THEN ActualTime END) AS InTime,
                        MAX(CASE WHEN LogStatus = 2 AND ActualTime <= '12:00' THEN FORMAT(ActualTime, 'HH:mm') END) AS LunchOut,
                        MAX(CASE WHEN LogStatus = 2 AND ActualTime <= '12:00' THEN ActualTime END) AS LunchOutTime,
                        CASE 
                            WHEN MIN(CASE WHEN LogStatus = 1 THEN ActualTime END) IS NOT NULL 
                                 AND MAX(CASE WHEN LogStatus = 2 AND ActualTime <= '12:00' THEN ActualTime END) IS NULL THEN NULL 
                            ELSE MAX(CASE WHEN LogStatus = 1 AND ActualTime > '12:00' THEN FORMAT(ActualTime, 'HH:mm') END) 
                        END AS AfternoonIn1,
                        MAX(CASE WHEN LogStatus = 1 AND ActualTime > '12:00' THEN ActualTime END) AS AfternoonInTime,
                        MAX(CASE WHEN LogStatus = 2 AND ActualTime > '12:00' THEN FORMAT(ActualTime, 'HH:mm') END) AS Out,
                        MAX(CASE WHEN LogStatus = 2 AND ActualTime > '12:00' THEN ActualTime END) AS OutTime
                    FROM AttendanceLogs
                    WHERE 
                        ActualTime BETWEEN '".$fromdate."' AND '".$todate."'
                    GROUP BY 
                        EmployeeID,
                        CONVERT(DATE, ActualTime),
                        FORMAT(ActualTime, 'dddd')
                ),
                NextDayLogs AS (
                    SELECT
                        t1.EmployeeNo,
                        t1.Date,
                        t1.Day,
                        t1.In1,
                        t1.LunchOut,
                        t1.AfternoonIn1,
                        COALESCE(t1.Out, MAX(FORMAT(t2.ActualTime, 'HH:mm'))) AS Out,
                        t1.InTime,
                        t1.LunchOutTime,
                        t1.AfternoonInTime,
                        COALESCE(t1.OutTime, MAX(t2.ActualTime)) AS OutTime,
                        MAX(FORMAT(t2.ActualTime, 'HH:mm')) AS NextDayOut,
                        DATEDIFF(MINUTE, t1.InTime, COALESCE(t1.OutTime, GETDATE())) / 60.0 AS Hours_Work
                    FROM DailyLogs t1
                    LEFT JOIN AttendanceLogs t2 ON t1.EmployeeNo = t2.EmployeeID
                        AND CONVERT(DATE, t2.ActualTime) = DATEADD(DAY, 1, t1.Date)
                        AND t2.LogStatus = 2
                    GROUP BY
                        t1.EmployeeNo,
                        t1.Date,
                        t1.Day,
                        t1.In1,
                        t1.LunchOut,
                        t1.AfternoonIn1,
                        t1.Out,
                        t1.InTime,
                        t1.LunchOutTime,
                        t1.AfternoonInTime,
                        t1.OutTime
                )
                INSERT INTO employee_upload_attendances (employee_no, date, day, in1, out1, in2, out2, nextday, hours_work, location)
                SELECT
                    EmployeeNo,
                    Date,
                    Day,
                    In1,
                    LunchOut,
                    AfternoonIn1,
                
                    CASE WHEN DATEPART(HOUR,In1) >=0 AND DATEPART(HOUR,In1) <=16 THEN Out
                    else NextDayOut END AS Out,
                    NULL AS NextDay,
                
                    DATEDIFF(MINUTE, 
                        CAST(CONVERT(VARCHAR, GETDATE(), 111) + ' ' + CONVERT(VARCHAR, In1, 108) AS DATETIME), 
                        CASE 
                            WHEN Out >= In1 THEN CAST(CONVERT(VARCHAR, GETDATE(), 111) + ' ' + CONVERT(VARCHAR,
                            CASE WHEN DATEPART(HOUR,In1) >=0 AND DATEPART(HOUR,In1) <=16 THEN Out
                            else NextDayOut END
                            , 108) AS DATETIME)
                            ELSE DATEADD(DAY, 1, CAST(CONVERT(VARCHAR, GETDATE(), 111) + ' ' + CONVERT(VARCHAR, 
                            CASE WHEN DATEPART(HOUR,In1) >=0 AND DATEPART(HOUR,In1) <=16 THEN Out
                            else NextDayOut END
                            , 108) AS DATETIME))
                        END
                    ) / 60.0 AS Hours_Worked,
                    'MAIN' as Location
                FROM NextDayLogs
                where Hours_Work is not null
                ORDER BY
                    EmployeeNo,
                    Date;
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

            // Count query for employee_attendance_posts
            $postsCount = DB::table('employee_attendance_posts')
            ->where('date', '=', $fromdate)
            ->whereBetween('date', [$fromdate, $todate])
            ->whereIn('date', function($query) {
                $query->select('date')
                    ->from('employee_attendance_posts')
                    ->groupBy('date')
                    ->havingRaw('COUNT(*) > 1');
            })
            ->count();

            // Count query for employee_attendance_savestates
            $savestatesCount = DB::table('employee_attendance_savestates')
            ->where('date', '=', $fromdate)
            ->whereBetween('date', [$fromdate, $todate])
            ->whereIn('date', function($query) {
                $query->select('date')
                    ->from('employee_attendance_savestates')
                    ->groupBy('date')
                    ->havingRaw('COUNT(*) > 1');
            })
            ->count();
    
            $count1 = (int)$importpass1;
            $count2 = (int)$postsCount;
            $count3 = (int)$savestatesCount;
    
            if($count1 <= 0 && $count2 <= 0 && $count3 <= 0){

                  // Assuming you have a query builder instance, such as $queryBuilder
                  $statement = "
                    INSERT INTO employee_attendance_savestates(employee_no, date, day, in1, out1, in2, out2, nextday, hours_work) SELECT employee_no, date, day, in1, out1, in2, out2, nextday, hours_work FROM employee_upload_attendances
                    where cast(date as date) between '$fromdate' and '$todate'
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


    /*--------------------------------------------------------------
    # POST EMPLOYEE ATTENDANCE
    --------------------------------------------------------------*/ 

    public function Amanual(Request $request)
    {
        try{
            $employee_name = request('employee_name');
            $datesched = request('datesched');
            $timein = request('timein');
            $timeout = request('timeout');

            

            $employee_data = DB::table('employees')
            ->select('employee_no', 'fullname')
            ->where('employee_no', $employee_name)
            ->first();

            $date = Carbon::parse($datesched);

            $dayOfWeek = $date->format('l');

            // Convert in1 and out2 to Carbon instances
            $in1_time = Carbon::parse($timein);
            $out2_time = Carbon::parse($timeout);

            // Calculate the difference in hours
            $hours_work = $in1_time->diffInHours($out2_time);

            

            if($employee_data != null){
                $employee_no = $employee_data->employee_no; 
                $fullname = $employee_data->fullname; 
            }else{
                return back()->with('error','Please Select employee');
            }

            DB::table('employee_upload_attendances')->insert([
                [
                    'employee_no' => $employee_no,
                    'date' => $datesched,
                    'day' => $dayOfWeek,
                    'in1' => $timein,
                    'out2' => $timeout,
                    'hours_work' => $hours_work,
                    'location' => 'MAIN'
                ]
            ]);

            /* LOGS */
            Log::info('Add Employee Attendance Manually');
    
            $statuslogs = "
            INSERT INTO statuslogs (linecode, functions, modifieddate) values ('attendance', 'Add Employee Attendance Manually', getdate())
            ";
            DB::statement($statuslogs);
    
    
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
