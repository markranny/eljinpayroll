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
use App\overtimes;
use App\employees;
use App\overtimes_logs;
use DataTables;
use Validator;

class OvertimeController extends Controller
{
    /*--------------------------------------------------------------
    # Overtime
    --------------------------------------------------------------*/

    /*--------------------------------------------------------------
    # Overtime NAV 
    --------------------------------------------------------------*/

    public function overtimenav()
    {
        $employees = DB::table('employees')
                    ->orderBy('fullname', 'ASC')
                    ->get();

                    $empposts = DB::table('emp_posts')
                    ->select('employeeattendanceid')
                    ->orderBy('employeeattendanceid', 'ASC')
                    ->limit(1)
                    ->get();

        return view('HR.overtime_nav', compact('employees','empposts'));
    }

    /*--------------------------------------------------------------
    # ADD OVERTIME RECORDS
    --------------------------------------------------------------*/ 

    public function overtimedata(Request $request)
    {
                $overtimes = DB::table('overtimes')
                ->join('employees', 'overtimes.employee_no', '=', 'employees.employee_no')
                /* ->select(DB::raw('CONCAT(employees.firstname, ", ", employees.lastname) as fullname'),'overtimes.*') */
                ->select('employees.fullname', 'overtimes.*')
                /* ->select(DB::raw('CONCAT(employees.firstname, ", ", employees.lastname) as firstname'), 'overtimes.*') */
                ->orderBy('working_schedule', 'DESC')
                ->get();

                return DataTables::of($overtimes)
                ->make(true);
    }

    public function addovertime(Request $request)
    {
        $employeeattendanceid = request('employeeattendanceid');
        $employee_name = request('employee_name');
        $datesched = request('datesched');
        $timein = request('timein');
        $timeout = request('timeout');

        $employee_data = DB::table('employees')
        ->select('employee_no')
        ->where('fullname', $employee_name)
        ->first();

        $employee_no = $employee_data->employee_no;

        $getday = Carbon::parse($datesched)->format('d');
        $getmonth = Carbon::parse($datesched)->format('F');
        $getyear = Carbon::parse($datesched)->format('Y');


        if((int)$getday < 15){
            $getperiod = "1st Period";
        }else{
            $getperiod = "2nd Period";
        }

        $timesum1 = Carbon::parse($request->timein)->format('H');
        $timesum2 = Carbon::parse($request->timeout)->format('H');
        $timetotal = (int)$timesum2 - (int)$timesum1;

        $filter = DB::table('overtimes')
        ->where("employee_no", "=", $employee_no)
        ->where("working_schedule", "=", $datesched)
        ->count();

        if($filter<1){
           // $employeeattendanceid != null && 
            if($employee_name != null &&  $datesched != null && $timein != null && $timeout != null){
                $update = new overtimes();
                $update->employeeattendanceid   =   111;
                $update->employee_no   =   $employee_no;
                $update->employee_name   =   $employee_name;
                $update->working_schedule   =   request('datesched');
                $update->ot_in   =   request('timein');
                $update->ot_out   =   request('timeout');
                $update->ot_hrs   =   $timetotal * 1.3;
                $update->remarks   =   request('remarks');
                $update->month   =   $getmonth;
                $update->year   = $getyear;
                $update->period   =   $getperiod ;
                $update->save();

                        Log::info('Add Overtime');

                        $statuslogs = "
                        INSERT INTO statuslogs (linecode, functions, modifieddate) values ('Overtime', 'Add OB table', getdate())
                        ";
                        DB::statement($statuslogs);
        
                $timesum1 = Carbon::parse($request->timein)->format('H');
                $timesum2 = Carbon::parse($request->timeout)->format('H');
                $timetotal = (int)$timesum2 - (int)$timesum1;

                /* $updateattendance = "
                update employee_attendance_posts set overtime = $timetotal * 1.3 where employee_no = '$employee_no' and date = '$datesched'
                ";

                DB::statement($updateattendance); */

                DB::table('employee_attendance_posts')
                ->where('employee_no', $employee_no)
                ->where('date', $datesched)
                ->update(['overtime' => DB::raw("{$timetotal} * 1.3")]);


                Log::info('Add Overtime to employee_attendance_posts table');

                        $statuslogs = "
                        INSERT INTO statuslogs (linecode, functions, modifieddate) values ('Overtime', 'Add OB table', getdate())
                        ";
                        DB::statement($statuslogs);

                $employees = DB::table('employees')
                        ->get();

                Log::info('Overtime Added Successfully!');

                        $statuslogs = "
                        INSERT INTO statuslogs (linecode, functions, modifieddate) values ('Overtime', 'Overtime Added Successfully!', getdate())
                        ";
                        DB::statement($statuslogs);
                return back()->with('employees', $employees)->with('success','Overtime Added Successfully!'); 

                }else{
                    return back()->with('error','Please Fill Out This Form!');
                }
        
        }else{
            return back()->with('error','Data is already exist!');
        }

    }

     /*--------------------------------------------------------------
    # DELETE OVERTIME
    --------------------------------------------------------------*/

    public function delete_overtime($id){
        $tableName = 'overtimes';
        $idToDelete = $id; 
        
        $recordExists = DB::table($tableName)->where('id', $idToDelete)->exists();
        if ($recordExists) {
            DB::table($tableName)->where('id', $idToDelete)->delete();

            DB::table('employee_attendance_posts')
                ->where('id', $id)
                ->update([
                    'overtime' => 0
                ]);
            
            return response()->json(['message' => 'success']);
        } else {
            return response()->json(['message' => 'fail']);
        }
    }

    /*--------------------------------------------------------------
    # UPDATE OVERTIME
    --------------------------------------------------------------*/
    public function update_overtime(Request $request){
        try {
            $data = $request->validate([
                'id' => 'required|exists:overtimes,id'
            ]);
            
            $datesched = request('datesched');
            $timein = request('timein');
            $timeout = request('timeout');
            $remarks = request('remarks');
            $id = request('id');
    
            $getday = Carbon::parse($datesched)->format('d');
            $getmonth = Carbon::parse($datesched)->format('F');
            $getyear = Carbon::parse($datesched)->format('Y');
    
    
            if((int)$getday < 15){
                $getperiod = "1st Period";
            }else{
                $getperiod = "2nd Period";
            }
    
            $overtimeData = DB::table('overtimes')
            ->where('id', $id)
            ->first();

            if(!$overtimeData){
                return response()->json(['message' => 'Invalid Overtime ID']);
            }
            $employee_no = $overtimeData->employee_no;
            $checkIfDateAlreadyExistForThisUser = DB::table('overtimes')
            ->where("employee_no", "=", $employee_no)
            ->where("working_schedule", "=", $datesched)
            ->where('id', '!=', $id)
            ->count();

            if($checkIfDateAlreadyExistForThisUser > 0){
                return response()->json(['message' => 'Date already Exist for this user.']);
            }

            if($datesched != null && $timein != null && $timeout != null){
                $timesum1 = Carbon::parse($request->timein)->format('H');
                $timesum2 = Carbon::parse($request->timeout)->format('H');
                $timetotal = (int)$timesum2 - (int)$timesum1;

                DB::table('overtimes')
                ->where('id', $id)
                ->update([
                    'working_schedule' => $datesched,
                    'ot_in' => $timein,
                    'ot_out' => $timeout,
                    'ot_hrs' => $timetotal * 1.3,
                    'remarks'   =>  $remarks,
                    'month'   =>  $getmonth,
                    'year'   =>  $getyear,
                    'period'   =>  $getperiod
                ]);
        

                DB::table('employee_attendance_posts')
                ->where('employee_no', $employee_no)
                ->where('date', $datesched)
                ->update(['overtime' => DB::raw("{$timetotal} * 1.3")]);

                return response()->json(['message' => 'success']);


            }else{
                return back()->with('error','Please Fill Out This Form!');
            }

        } catch (\Exception $ex) {
            return response()->json(['message' => $ex->getMessage()]);
        }
    }
}
