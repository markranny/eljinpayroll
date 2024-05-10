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
use App\changetimes;
use DataTables;
use Validator;

class CTController extends Controller
{
    /*--------------------------------------------------------------
    # CHANGE TIME SCHED
    --------------------------------------------------------------*/
    /*--------------------------------------------------------------
    # CT NAV 
    --------------------------------------------------------------*/

    public function changetimenav()
    {
        $employees = DB::table('employees')
                    ->orderBy('lastname', 'ASC')
                    ->get();

                    $empposts = DB::table('emp_posts')
                    ->select('employeeattendanceid')
                    ->orderBy('employeeattendanceid', 'DESC')
                    ->limit(1)
                    ->get();

        return view('HR.changetime_nav', compact('employees','empposts'));
    }

    /*--------------------------------------------------------------
    # CHANGE TIME SCHEDULE
    --------------------------------------------------------------*/ 
    /*--------------------------------------------------------------
    # DISPLAY CHANGE TIME SCHEDULE RECORDS
    --------------------------------------------------------------*/ 

    public function changetimedata(Request $request)
    {
                $changetimes = DB::table('changetimes')
                ->get();

                return DataTables::of($changetimes)
                ->make(true);
    }


     /*--------------------------------------------------------------
    # DELETE CHANGEOFF
    --------------------------------------------------------------*/

    public function delete_changetime($id){
        
        $tableName = 'changetimes';
        $idToDelete = $id; 
        /* $datesched = request('datesched'); */
        
        $recordExists = DB::table($tableName)->where('id', $idToDelete)->exists();

        if ($recordExists) {
            DB::table($tableName)->where('id', $idToDelete)->delete();
            
            return response()->json(['message' => 'success']);
        } else {
            return response()->json(['message' => 'fail']);
        }
    }

    /*--------------------------------------------------------------
    # UPDATE CHANGEOFF
    --------------------------------------------------------------*/
    public function update_changetime(Request $request){
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

                /* DB::table('employee_attendance_posts')
                ->where('employee_no', $employee_no)
                ->where('date', $datesched)
                ->update(['date' => $newdatesched]);



                $updateattendance2 = "
                update employee_schedule_posts set change_sched = '$datesched' where employee_no = '$employee_no' and date_sched = '$datesched'
                ";
                DB::statement($updateattendance2);


                $updateattendance3 = "
                update employee_schedule_posts set date_sched = '$newdatesched' where employee_no = '$employee_no' and date_sched = '$datesched'
                ";
                DB::statement($updateattendance3); */

                return response()->json(['message' => 'success']);


            }else{
                return back()->with('error','Please Fill Out This Form!');
            }

        } catch (\Exception $ex) {
            return response()->json(['message' => $ex->getMessage()]);
        }
    }


    /*--------------------------------------------------------------
    # ADD CHANGE TIME RECORDS
    --------------------------------------------------------------*/ 
    public function changetime(Request $request)
    {
        $employeeattendanceid = request('employeeattendanceid');
        $employee_name = request('employee_name');
        $datesched = request('datesched');
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

        $getday = Carbon::parse($datesched)->format('d');
        $getmonth = Carbon::parse($datesched)->format('F');

        if((int)$getday < 15){
            $getperiod = "1st Period";
        }else{
            $getperiod = "2nd Period";
        }

        $filter = DB::table('changetimes')
        ->where("employee_no","=",$employee_no)
        ->where("date","=",$datesched)
        ->count();

        if($filter<1){

            if($employeeattendanceid != null && $employee_name != null && $employee_no != null && $datesched != null && $timein != null && $timeout != null){
                $update = new changetimes();
                $update->employeeattendanceid   =   $employeeattendanceid;
                $update->employee_no   =   $employee_no;
                $update->employee_name   =   $fullname;
                $update->in1   =   $timein;
                $update->out1  =   $timeout;
                $update->date  =   $datesched;
                $update->remarks   =   $remarks;
                $update->save();

                Log::info('Add data into Change time table');

                $statuslogs = "
                INSERT INTO statuslogs (linecode, functions, modifieddate) values ('ChangeOff', 'Add data to Change time table', getdate())
                ";
                DB::statement($statuslogs);

                /* $updateattendance1 = "
                UPDATE employee_schedule_posts 
                SET 
                timess = '$timein to $timeout', 
                time_sched = '$timein', 
                time_sched_out = '$timeout' 
                WHERE 
                CAST(date_sched as date) = '$datesched' 
                AND employee_no = '$employee_no';
                ";

                DB::statement($updateattendance1);

                $updateattendance2 = "
                update employee_attendance_posts set ctlate = '0' where date = '$datesched' and employee_no = '$employee_no'
                ";

                DB::statement($updateattendance2);

                Log::info('Update CTL!');

                $statuslogs = "
                INSERT INTO statuslogs (linecode, functions, modifieddate) values ('ChangeTime', 'Update CTL', getdate())
                ";
                DB::statement($statuslogs); */

                $employees = DB::table('employees')
                ->get();

                Log::info('Change Time Successfully!');

                $statuslogs = "
                INSERT INTO statuslogs (linecode, functions, modifieddate) values ('ChangeTime', 'Change Time Successfully!', getdate())
                ";
                DB::statement($statuslogs);

                return back()->with('employees', $employees)->with('success','Change Time Successfully!'); 
        }
    }
}
}
