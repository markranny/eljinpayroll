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
use App\employee_schedule_temps;
use App\employees_schedules;
use App\employees_schedules_logs;
use DataTables;
use Validator;

class ScheduleController extends Controller
{
   /*--------------------------------------------------------------
    # FUNCTION FOR SCHEDULING
    --------------------------------------------------------------*/ 
    /*--------------------------------------------------------------
    # SCHEDULE NAV 
    --------------------------------------------------------------*/

    public function schedlistnav()
    {
        /* return view('HR.schedulelist_nav'); */

        $employees = DB::table('employees')
                    ->orderBy('fullname', 'ASC')
                    ->get();

                    $empposts = DB::table('emp_posts')
                    ->select('employeeattendanceid')
                    ->orderBy('employeeattendanceid', 'DESC')
                    ->limit(1)
                    ->get();

        return view('HR.schedulelist_nav', compact('employees','empposts'));
    }

    public function importdEmpSchednav()
    {
        /* return view('HR.Import_Schedule'); */

        $employees = DB::table('employees')
                    ->orderBy('lastname', 'ASC')
                    ->get();

        $empposts = DB::table('emp_posts')
                    ->select('employeeattendanceid')
                    ->orderBy('employeeattendanceid', 'ASC')
                    ->limit(1)
                    ->get();

        return view('HR.Import_Schedule', compact('employees','empposts'));
        
    }

    public function updatesched($employee_no)
    {
        $employee_schedule_posts = employee_schedule_posts::find($employee_no);
        return response()->json($employee_schedule_posts);

    }

    public function ecaddsched(Request $request)
    {
        $employee_name = request('employee_name');
        $start_date = request('datesched');
        $end_date = request('enddatesched');
        $timein = request('timein');
        $timeout = request('timeout');

        $employee_data = DB::table('employees')
            ->select('employee_no','fullname','department','line')
            ->where('employee_no', $employee_name)
            ->first();

        if (!$employee_data) {
            return back()->with('error', 'Employee not found!');
        }

        $employee_no = $employee_data->employee_no;
        $emp_name = $employee_data->fullname;
        $department = $employee_data->department;
        $line = $employee_data->line;

        $filter = DB::table('employee_schedule_temps')
            ->where("employee_no", "=", $employee_no)
            ->where("date_sched", ">=", $start_date)
            ->where("date_sched", "<=", $end_date)
            ->count();

        if ($filter > 0) {
            return back()->with('error', 'Data already exists for the selected date range!');
        }

        if ($employee_name && $start_date && $end_date && $timein && $timeout) {
            $start_date = Carbon::parse($start_date);
            $end_date = Carbon::parse($end_date);
            $time_in = date('h:i A', strtotime($timein)); // Convert time to 12-hour format
            $time_out = date('h:i A', strtotime($timeout)); // Convert time to 12-hour format

            $updateArray = [];

            while ($start_date <= $end_date) {
                $update = new employee_schedule_temps(); // Assuming EmployeeScheduleTemp is your model name
                $update->employee_no = $employee_no;
                $update->employee_name = $emp_name;
                $update->department = $department;
                $update->line = $line;
                $update->date_sched = $start_date->toDateString();
                $update->time = $time_in . ' to ' . $time_out;
                $update->time_sched = $timein;
                $update->time_sched_out = $timeout;

                try {
                    $update->save();
                    $updateArray[] = $update;
                } catch (\Exception $e) {
                    return back()->with('error', 'Failed to save schedule: ' . $e->getMessage());
                }

                $start_date->addDay();
            }

            Log::info('Add Schedule');

            $statuslogs = "INSERT INTO statuslogs (linecode, functions, modifieddate) values ('Overtime', 'Add Schedule', getdate())";
            DB::statement($statuslogs);

            $employees = DB::table('employees')->get();

            return back()->with('employees', $employees)->with('success', 'Schedule added successfully!');
        } else {
            return back()->with('error', 'Please fill out the form completely!');
        }


    }














    /*--------------------------------------------------------------
    # EMPLOYEE SCHEDULE
    --------------------------------------------------------------*/ 
    public function Scheddata(Request $request)
    {
                $employee_schedules = DB::table('employee_schedules')
                ->get();

                return DataTables::of($employee_schedules)  
                ->addColumn('action', function($request){
                    $btn = ' <a href="schedule-infos/'.$request->sched_no.'" data-toggle="tooltip"  data-id="'.$request->id.'" data-original-title="view" class="btn btn-success btn-sm View"><span class="material-symbols-outlined">Details</span></a>';
        
                return $btn;
                })
                ->make(true);        
    }

    /*--------------------------------------------------------------
    # EMPLOYEE SCHEDULE -DETAILS
    --------------------------------------------------------------*/ 
    public function schedinfos($sched_no)
    {
        $employee_schedule_posts = DB::table('employee_schedule_posts')
        ->where('sched_no', '=', $sched_no)
        ->get();

        return view('HR.sched_details_nav', ['employee_schedule_posts'=>$employee_schedule_posts]); 
    }

    /*--------------------------------------------------------------
    # EMPLOYEE SCHEDULE - GET ID
    --------------------------------------------------------------*/ 
    public function schedinfosdata($id)
    {
        $employee_schedule_posts = DB::table('employee_schedule_posts')
        ->where('sched_no', '=', $id)
        ->get();

        return DataTables::of($employee_schedule_posts)

        ->addColumn('action', function($request){
            $btn = '<button type="button" class="btn btn-success" id="exampleModal" data-toggle="modal" data-target="#exampleModal"><span class="material-symbols-outlined"><i class="material-icons">edit</i></span></button>';
            $btn = $btn.' <a href="deletesched/'.$request->employee_no.'" data-toggle="tooltip"  data-id="'.$request->employee_no.'" data-original-title="view" class="btn btn-danger btn-sm View"><span class="material-symbols-outlined"><i class="material-icons">delete</i></span></a>';
        return $btn;

        })
        ->make(true);
    }


    /*--------------------------------------------------------------
    # DISPLAY IMPORT EMPLOYEE SCHEDULE
    --------------------------------------------------------------*/ 
    public function importScheddata(Request $request)
    {
                $employee_schedule_temps = DB::table('employee_schedule_temps')
                ->get();

                return DataTables::of($employee_schedule_temps)
                ->make(true);
    }

    /*--------------------------------------------------------------
    # IMPORT EMPLOYEE SCHEDULE
    --------------------------------------------------------------*/ 
    public function importS(Request $request)
    {

        $importpass = DB::table('employee_schedule_temps')->count();
        $count = (int)$importpass;
        $file = request('file');

        try{
        if($count < 1)
        {   
                $statement = "
                BULK INSERT dbo.employee_schedule_temps
                FROM '//Progenx\PAYROLL SYSTEM\Schedule\\".$file."'
                WITH
                (
                FIRSTROW = 2,   
                FIELDTERMINATOR = ',', 
                ROWTERMINATOR = '\n'
                )
                ";
                
                DB::statement($statement);

                //LOGS
                Log::info('Employee Schedule have been imported successfully!');

                $statuslogsData = [
                    'linecode' => 'schedule',
                    'functions' => 'Employee Schedule have been imported successfully!',
                    'modifieddate' => now(), 
                ];

                DB::table('statuslogs')->insert($statuslogsData);
        
                return back()->with('success','Employee Schedule have been imported successfully!');             
        }
        else{

                //LOGS
                /* Log::info('Employee Schedule have been imported successfully!');

                $statuslogs = [
                    'linecode' => 'schedule',
                    'functions' => 'Employee Schedule have been imported successfully!',
                    'modifieddate' => now(),
                ];

                DB::table('statuslogs')->insert($statuslogs); */

                return back()->with('error', 'Data is already exist!');
            
        }
        }
        catch(\Exception $e){

                //LOGS
                Log::info($e);

                $statuslogs = [
                    'linecode' => 'schedule',
                    'functions' => 'ERROR FILES',
                    'modifieddate' => now(),
                ];
            
                DB::table('statuslogs')->insert($statuslogs);
            
                return back()->with('exception', $e->getMessage());
        }   
    }

    /*--------------------------------------------------------------
    # REMOVE THE RECENTLY UPLOADED EMPLOYEE SCHEDULE 
    --------------------------------------------------------------*/ 
    public function clearS(Request $request)
    {
        try {
            DB::table('employee_schedule_temps')->truncate();
        
            //LOGS
            Log::info('Data has been successfully cleared!');
        
            $statuslogs = [
                'linecode' => 'schedule',
                'functions' => 'Data has been successfully cleared!',
                'modifieddate' => now(),
            ];

            DB::table('statuslogs')->insert($statuslogs);
        
            return back()->with('error', 'Clear data Successfully!');

        } catch (\Exception $e) {
            //LOGS
            Log::info($e);
        
            $statuslogs = [
                'linecode' => 'schedule',
                'functions' => 'NO DATA',
                'modifieddate' => now(),
            ];
            DB::table('statuslogs')->insert($statuslogs);
        
            return back()->with('exception', $e->getMessage());
        }
    }


    /*--------------------------------------------------------------
    # POST ALL LINES - EMPLOYEE SCHEDULE 
    --------------------------------------------------------------*/ 
    public function palS(Request $request)
    {
        $department = request('department');

        try {
            // Step 1: Insert data from employee_schedule_temps into employee_schedule_posts
            DB::table('employee_schedule_posts')->insertUsing(
                ['employee_no', 'employee_name', 'department', 'line', 'date_sched', 'timess', 'time_sched', 'time_sched_out'],
                function ($query) {
                    $query->from('employee_schedule_temps')
                        ->select('employee_no', 'employee_name', 'department', 'line', 'date_sched', 'time', 'time_sched', 'time_sched_out')
                        ->whereNotIn('date_sched', function ($subquery) {
                            $subquery->from('employee_schedule_posts')
                                ->select('date_sched');
                        });
                }
            );

            //LOGS
            Log::info('Insert Employee Schedule');

            // Insert a status log
            $statuslogs1 = [
                'linecode' => 'schedule',
                'functions' => 'Insert Employee Schedule',
                'modifieddate' => now(),
            ];
            DB::table('statuslogs')->insert($statuslogs1);

            // Step 2: Truncate employee_schedule_temps
            DB::table('employee_schedule_temps')->truncate();

            // Log success
            Log::info('Clean the data of employees_schedule_temps.');

            // Insert a status log
            $statuslogs2 = [
                'linecode' => 'schedule',
                'functions' => 'Clean the data of employees_schedule_temps.',
                'modifieddate' => now(),
            ];
            DB::table('statuslogs')->insert($statuslogs2);

            // Step 3: Generate new schedule ID
            $filter = DB::table('employee_schedules')->count();
            $formatted_value = str_pad($filter + 1, 8, '0', STR_PAD_LEFT);
            $mytime = Carbon::now();

            // Log success
            Log::info('Generate new schedule ID');

            // Insert a status log
            $statuslogs3 = [
                'linecode' => 'schedule',
                'functions' => 'Generate new schedule ID',
                'modifieddate' => now(),
            ];
            DB::table('statuslogs')->insert($statuslogs3);

            // Step 4: Update the ID of the employee schedule
            DB::table('employee_schedule_posts')
                ->whereNull('sched_no')
                ->update(['sched_no' => $formatted_value]);

            // Log success
            Log::info('Update the ID of the employee schedule.');

            // Insert a status log
            $statuslogs4 = [
                'linecode' => 'schedule',
                'functions' => 'Update the ID of the employee schedule.',
                'modifieddate' => now(),
            ];
            DB::table('statuslogs')->insert($statuslogs4);

            // Step 5: Set the created date for each schedule
            DB::table('employee_schedule_posts')
                ->whereNull('sched_no')
                ->update(['created_at' => $mytime]);

            // Log success
            Log::info('Set the created date for each schedule.');

            // Insert a status log
            $statuslogs5 = [
                'linecode' => 'schedule',
                'functions' => 'Set the created date for each schedule.',
                'modifieddate' => now(),
            ];
            DB::table('statuslogs')->insert($statuslogs5);

            // Step 6: Insert data into employee schedule records
            try {
                DB::table('employee_schedules')->insert([
                    'sched_no' => $formatted_value,
                    'department' => $department,
                    'created_at' => $mytime,
                ]);

                // Log success
                Log::info('Insert data into employee schedule records');

                // Insert a status log
                $statuslogs6 = [
                    'linecode' => 'schedule',
                    'functions' => 'Insert data into employee schedule records',
                    'modifieddate' => now(),
                ];
                DB::table('statuslogs')->insert($statuslogs6);
            } catch (\Exception $e) {
                // Log the exception
                Log::info('An employee schedule already exists!');

                // Insert a status log for the exception case
                $statuslogs = [
                    'linecode' => 'schedule',
                    'functions' => 'An employee schedule already exists!',
                    'modifieddate' => now(),
                ];
                DB::table('statuslogs')->insert($statuslogs);

                return back()->with('error', 'An employee schedule already exists!');
            }

            // Log success
            Log::info('The employee schedule has been successfully saved!');

            // Insert a status log
            $statuslogs7 = [
                'linecode' => 'schedule',
                'functions' => 'The employee schedule has been successfully saved!',
                'modifieddate' => now(),
            ];
            DB::table('statuslogs')->insert($statuslogs7);

            return back()->with('success', 'The employee schedule has been successfully saved!');
        } catch (\Exception $e) {
            // Log the exception
            Log::info($e);

            // Insert a status log for the exception case
            $statuslogs = [
                'linecode' => 'schedule',
                'functions' => 'DATA ERROR',
                'modifieddate' => now(),
            ];
            DB::table('statuslogs')->insert($statuslogs);

            return back()->with('exception', $e->getMessage());
        }
        
    }

    /*--------------------------------------------------------------
    # DELETE IMPORTED SCHEDULE
    --------------------------------------------------------------*/

    public function delsched($employee_no, $date_sched) {
        try {
            $tableName = 'employee_schedule_temps';
            $idToDelete = $employee_no;
    
            // Check if record exists before deleting
            $recordExists = DB::table($tableName)->where('employee_no', $idToDelete)->where('date_sched', $date_sched)->exists();
            
            if ($recordExists) {
                DB::table($tableName)->where('employee_no', $idToDelete)->where('date_sched', $date_sched)->delete();
                return response()->json(['message' => 'success']);
            } else {
                return response()->json(['message' => 'Record not found.']);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred while deleting the record.', 'error' => $e->getMessage()], 500);
        }
    }
    
}
