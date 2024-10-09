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
use App\changeoffs;
use App\employees;
use DataTables;
use Validator;

class CSController extends Controller
{
    /*--------------------------------------------------------------
    # Change Schedule
    --------------------------------------------------------------*/

    /*--------------------------------------------------------------
    # Change Schedule NAV 
    --------------------------------------------------------------*/
    public function changeoffnav()
    {
        $employees = DB::table('employees')
                    ->orderBy('lastname', 'ASC')
                    ->get();

        $record = DB::table('numbersequences')
                ->select('employeeattendanceid')
                ->first();
      
        $emppost = $record ? str_pad($record->employeeattendanceid, 10, '0', STR_PAD_LEFT) : '0000000000';

        return view('HR.changeoff_nav', compact('employees', 'emppost'));
    }

    /*--------------------------------------------------------------
    # CHANGE OFF
    --------------------------------------------------------------*/ 
    /*--------------------------------------------------------------
    # DISPLAY CHANGE OFF RECORDS
    --------------------------------------------------------------*/ 

    public function changeoffdata(Request $request)
    {
                $changeoffs = DB::table('changeoffs')
                ->join('employees', 'changeoffs.employee_no', '=', 'employees.employee_no')
                ->select('employees.fullname', 'changeoffs.*')
                ->orderBy('working_schedule', 'DESC')
                ->get();

                return DataTables::of($changeoffs)
                ->editColumn('time_in', function($row) {
                    return Carbon::parse($row->time_in)->format('g:i A');
                })
                ->editColumn('time_out', function($row) {
                    return Carbon::parse($row->time_out)->format('g:i A');
                })
                ->make(true);
    }

    /*--------------------------------------------------------------
    # ADD DATA RECORDS - CHANGE OFF || UPDATE EMPLOYEE SCHEDULE
    --------------------------------------------------------------*/ 
    public function addsched(Request $request)
    {
        $employeeattendanceid = request('employeeattendanceid');
        $employee_name = request('employee_name');
        $datesched = request('datesched');
        $newdatesched = request('newdatesched');
        $timein = request('timein');
        $timeout = request('timeout');
        $remarks = request('remarks');

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

        $getday = Carbon::parse($newdatesched)->format('d');
        $getmonth = Carbon::parse($newdatesched)->format('F');

        if((int)$getday < 15){
            $getperiod = "1st Period";
        }else{
            $getperiod = "2nd Period";
        }

        $filter = DB::table('changeoffs')
        ->where("employee_no","=",$employee_no)
        ->where("working_schedule","=",$datesched)
        ->count();

        /* $filter2 = DB::table('employee_attendance_posts')
        ->where("employeeattendanceid", "=", $employeeattendanceid)
        ->where("employee_no", "=", $employee_no)
        ->where("date", "=", $datesched)
        ->where("day", "=", $datesched)
        ->count(); */

        $empatt = DB::table('emp_posts')
        ->where("employeeattendanceid","=",$employeeattendanceid)
        ->where("employee_no","=",$employee_no)
        /* ->where("month","=",$month)
        ->where("year","=",$year)
        ->where("period","=",$period) */
        ->count();

    /* if($empatt>1){ */
        if($filter<1){
            if($employee_no != null && $employee_name != null && $employee_no != null && $datesched != null && $newdatesched != null && $timein != null && $timeout != null && $remarks != null){
                $update = new changeoffs();
                $update->employeeattendanceid   =   $employeeattendanceid;
                $update->employee_no   =   $employee_no;
                $update->employee_name   =    $fullname;
                $update->working_schedule   =   request('datesched');
                $update->new_working_schedule   =   request('newdatesched');
                $update->time_in  =   request('timein');
                $update->time_out   =   request('timeout');
                $update->remarks   =   request('remarks');
                $update->month = $getmonth;
                $update->period = $getperiod;
                $update->save();

                Log::info('Add data into Change off table');

                $statuslogs = "
                INSERT INTO statuslogs (linecode, functions, modifieddate) values ('ChangeOff', 'Add data to Change off table', getdate())
                ";
                DB::statement($statuslogs);
        
                $timesum1 = Carbon::parse($request->timein)->format('H');
                $timesum2 = Carbon::parse($request->timeout)->format('H');
                $timetotal = (int)$timesum2 - (int)$timesum1;

                $employees = DB::table('employees')
                        ->get();

                        Log::info('Change Date Successfully!');

                        $statuslogs = "
                        INSERT INTO statuslogs (linecode, functions, modifieddate) values ('ChangeOff', 'Change Date Successfully!', getdate())
                        ";
                        DB::statement($statuslogs);
        
                return redirect()->back()->with('employees', $employees)->with('success','Change Date Successfully!'); 

                }else{
                    
                        Log::info('Please Fill Out This Form!');

                        $statuslogs = "
                        INSERT INTO statuslogs (linecode, functions, modifieddate) values ('ChangeOff', 'Please Fill Out This Form!', getdate())
                        ";
                        DB::statement($statuslogs);

                    return back()->with('error','Please Fill Out This Form!');
                }
        
                }else{

                        Log::info('Data is already exist!');

                        $statuslogs = "
                        INSERT INTO statuslogs (linecode, functions, modifieddate) values ('ChangeOff', 'Data is already exist!', getdate())
                        ";
                        DB::statement($statuslogs);

            return back()->with('error','Data is already exist!');
        }

    }

     /*--------------------------------------------------------------
    # DELETE CHANGEOFF
    --------------------------------------------------------------*/

    public function delete_changeoff($id, $employee_no, $new_working_schedule){
        
        try {
            $tableName = 'changeoffs';
            /* $DTR = 'employee_attendance_posts'; */
            
            $formatted_date = date('Y-m-d', strtotime($new_working_schedule));
            
            DB::beginTransaction();
            
            $recordExists = DB::table($tableName)->where('id', $id)->exists();
            /* $DTRrecords = DB::table($DTR)->where('employee_no', $idToDelete)->where('date', $date)->exists(); */
    
            /* if ($recordExists && $DTRrecords) { */
            if ($recordExists) {
                DB::table($tableName)->where('id', $id)->delete();
                /* DB::table($DTR)->where('employee_no', $idToDelete)->where('date', $date)->delete(); */
                
                DB::commit();
                return response()->json(['message' => 'success']);
            } else {
                DB::rollBack();
                return response()->json([
                    'message' => 'fail',
                    'reason' => 'Records not found'
                ], 404);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'fail',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /*--------------------------------------------------------------
    # UPDATE CHANGEOFF
    --------------------------------------------------------------*/
    public function update_changeoff(Request $request){
        try {
            $data = $request->validate([
                'id' => 'required|exists:changeoffs,id'
            ]);
            
            $datesched = request('datesched');
            $newdatesched = request('newdatesched');
            $timein = request('timein');
            $timeout = request('timeout');
            $remarks = request('remarks');
            $id = request('id');
    
            $getday = Carbon::parse($newdatesched)->format('d');
            $getmonth = Carbon::parse($newdatesched)->format('F');
            $getyear = Carbon::parse($newdatesched)->format('Y');
    
            if((int)$getday < 15){
                $getperiod = "1st Period";
            }else{
                $getperiod = "2nd Period";
            }
    
            $changeOffData = DB::table('changeoffs')
            ->where('id', $id)
            ->first();

            if(!$changeOffData){
                return response()->json(['message' => 'Invalid changeOff ID']);
            }
            $employee_no = $changeOffData->employee_no;
            $checkIfDateAlreadyExistForThisUser = DB::table('changeoffs')
            ->where("employee_no", "=", $employee_no)
            ->where("working_schedule", "=", $datesched)
            ->where('id', '!=', $id)
            ->count();

            if($checkIfDateAlreadyExistForThisUser > 0){
                return response()->json(['message' => 'Date already Exist for this user.']);
            }

            if($employee_no != null && $datesched != null && $newdatesched != null && $timein != null && $timeout != null){

                $timesum1 = Carbon::parse($timein)->format('H');
                $timesum2 = Carbon::parse($timeout)->format('H');
                $timetotal = (int)$timesum2 - (int)$timesum1;

                DB::table('changeoffs')
                ->where('id', $id)
                ->update([
                    'working_schedule' => $datesched,
                    'new_working_schedule' => $newdatesched,
                    'time_in' => $timein,
                    'time_out' => $timeout,
                    'remarks'   =>  $remarks,
                    'month'   =>  $getmonth,
                    'period'   =>  $getperiod
                ]);

                // $updateattendance1 = "
                // insert into employee_attendance_posts(employeeattendanceid,employee_name,employee_no, date, day, in1, out2, hours_work, working_hour, totalhrsneeds, totalhrs, totalhrsearned, ctlate, minutes_late, udt, udt_hrs, nightdif, period, status) values('$employeeattendanceid','$employee_name','$employee_no', '$newdatesched', 'CHANGEOFF', '$timein', '$timeout', '$timetotal', '8.0','0','9','9','0','0','-','0.00','0','$getperiod','0')
                // ";
                // DB::statement($updateattendance1);

                DB::table('employee_attendance_posts')
                ->where('employee_no', $employee_no)
                ->where('date', $datesched)
                ->update(['date' => $newdatesched]);



                /* $updateattendance2 = "
                update employee_schedule_posts set change_sched = '$datesched' where employee_no = '$employee_no' and date_sched = '$datesched'
                ";
                DB::statement($updateattendance2);


                $updateattendance3 = "
                update employee_schedule_posts set date_sched = '$newdatesched' where employee_no = '$employee_no' and date_sched = '$datesched'
                ";
                DB::statement($updateattendance3);
                */
                return response()->json(['message' => 'success']);


            }else{
                return back()->with('error','Please Fill Out This Form!');
            }

        } catch (\Exception $ex) {
            return response()->json(['message' => $ex->getMessage()]);
        }
    }

}
