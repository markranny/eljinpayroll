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
use App\obs;
use App\employees;
use App\employee_attendance_posts;
use App\overtimes_logs;
use DataTables;
use Validator;

class TravelOrderController extends Controller
{
    /*--------------------------------------------------------------
    # OB
    --------------------------------------------------------------*/
    /*--------------------------------------------------------------
    # OB NAV 
    --------------------------------------------------------------*/

    public function tonav()
    {
        $employees = DB::table('employees')
                    ->orderBy('lastname', 'ASC')
                    ->get();

                    $empposts = DB::table('emp_posts')
                    ->select('employeeattendanceid')
                    ->where('status','=','0')
                    ->orderBy('employeeattendanceid', 'DESC')
                    ->limit(1)
                    ->get();

        return view('HR.to_nav', compact('employees','empposts'));
    }

    /*--------------------------------------------------------------
    # VIEW DATA
    --------------------------------------------------------------*/ 
    public function todata(Request $request)
    {
                $obs = DB::table('obs')
                ->join('employees', 'obs.employee_no', '=', 'employees.employee_no')
                ->select('employees.firstname', 'obs.*')
                ->orderBy('date_sched', 'DESC')
                ->get();

                return DataTables::of($obs)
                ->make(true);
    }


    /*--------------------------------------------------------------
    # ADD OB
    --------------------------------------------------------------*/
    public function addto(Request $request)
    {
        $obtype = request('obtype');
        $employeeattendanceid = request('employeeattendanceid');
        $employee_name = request('employee_name');
        $datesched = request('datesched');
        $location = request('location');
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
        $getyear = Carbon::parse($datesched)->format('Y');

        if((int)$getday < 15){
            $getperiod = "1st Period";
        }else{
            $getperiod = "2nd Period";
        }

        try{

                $filter = DB::table('obs')  
                ->where("employee_no", "=", $employee_no)
                ->where("date_sched", "=", $datesched)
                ->count();

                if($filter<1){

                    if($employeeattendanceid != null && $employee_name != null && $employee_no != null && $datesched != null && $location != null){
                        $update = new obs();
                        $update->employeeattendanceid   =   request('employeeattendanceid');
                        $update->employee_no   =   $employee_no;
                        $update->employee_name   =   $fullname;
                        $update->date_sched   =   request('datesched');
                        $update->location   =   request('location');
                        $update->remarks   =   request('remarks');
                        $update->month = $getmonth;
                        $update->year = $getyear;
                        $update->period = $getperiod;
                        $update->save();

                        Log::info('Add OB');

                        $statuslogs = "
                        INSERT INTO statuslogs (linecode, functions, modifieddate) values ('OB', 'Add OB table', getdate())
                        ";
                        DB::statement($statuslogs);

                        /* $updateattendance1 = "
                        insert into employee_attendance_posts(employeeattendanceid,employee_name,employee_no, date, day, schedin, schedout, in1, out2, hours_work, working_hour, totalhrsneeds, totalhrs, totalhrsearned, ctlate, minutes_late, udt, udt_hrs, nightdif, ob, period, status) 
                        values('$employeeattendanceid','$employee_name','$employee_no', '$datesched', 'OB', '00:00:00.0000000', '00:00:00.0000000', '00:00', '00:00', '9.00', '8.00', '0', '9', '9', '0', '0', '-', '0','0','OB','$getperiod','0')
                        ";
                        DB::statement($updateattendance1); */

                        if($obtype == "OB"){
                            DB::table('employee_attendance_posts')->insert([
                                'employeeattendanceid' => $employeeattendanceid,
                                'employee_name' => $fullname,
                                'employee_no' => $employee_no,
                                'date' => $datesched,
                                'day' => 'OB',
                                'schedin' => '00:00:00.0000000',
                                'schedout' => '00:00:00.0000000',
                                'in1' => '08:00',
                                'out2' => '17:00',
                                'hours_work' => '9.00',
                                'working_hour' => '8.00',
                                'totalhrsneeds' => '0',
                                'totalhrs' => '9',
                                'totalhrsearned' => '9',
                                'ctlate' => '0',
                                'nightdif' => '0',
                                'minutes_late' => '0',
                                'udt' => '-',
                                'udt_hrs' => '0',
                                'ob' => 'OB',
                                'period' => $getperiod,
                                'status' => '0'
                            ]);
    
                            Log::info('Insert OB to employee_attendance_posts table');
    
                            $statuslogs = "
                            INSERT INTO statuslogs (linecode, functions, modifieddate) values ('OB', 'Insert OB to employee_attendance_posts table', getdate())
                            ";
                            DB::statement($statuslogs);
                        }

                        

                        $employees = DB::table('employees')
                                ->get();
                
                                Log::info('OB Added Successfully!');

                                $statuslogs = "
                                INSERT INTO statuslogs (linecode, functions, modifieddate) values ('OB', 'OB Added Successfully!', getdate())
                                ";
                                DB::statement($statuslogs);

                        return back()->with('employees', $employees)->with('success','OB Added Successfully!'); 

                        }else{
                            Log::info('Please Fill Out This Form!');

                                $statuslogs = "
                                INSERT INTO statuslogs (linecode, functions, modifieddate) values ('OB', 'Please Fill Out This Form!', getdate())
                                ";
                                DB::statement($statuslogs);

                            return back()->with('error','Please Fill Out This Form!');
                        }
                
                }else{

                    Log::info('Data is already exist!');

                                $statuslogs = "
                                INSERT INTO statuslogs (linecode, functions, modifieddate) values ('OB', 'Data is already exist!', getdate())
                                ";
                                DB::statement($statuslogs);


                    return back()->with('error','Data is already exist!');
                }
        }catch(\Exception $e){
            Log::info($e->getMessage());

                                $statuslogs = "
                                INSERT INTO statuslogs (linecode, functions, modifieddate) values ('OB', 'DATA ERROR', getdate())
                                ";
                                DB::statement($statuslogs);
            return back()->with('exception', $e->getMessage());
        }
    }

     /*--------------------------------------------------------------
    # DELETE TRAVELORDER
    --------------------------------------------------------------*/

    public function delete_travel_order($id, $employee_no, $date_sched){
        $tableName = 'obs';
        $DTR = 'employee_attendance_posts';
        $idToDelete = $id; 
        
        $recordExists = DB::table($tableName)->where('id', $idToDelete)->exists();
        $DTRrecords = DB::table($DTR)->where('employee_no', $employee_no)->where('date', $date_sched)->exists();

        
        /* dd($DTRrecords); */
        if ($recordExists && $DTRrecords) {
            DB::table($tableName)->where('id', $idToDelete)->delete();
            DB::table($DTR)->where('employee_no', $employee_no)->where('date', $date_sched)->delete();
            
            return response()->json(['message' => 'success']);
        } else {
            return response()->json(['message' => 'fail']);
        }

    }

    /*--------------------------------------------------------------
    # UPDATE TRAVELORDER
    --------------------------------------------------------------*/
    public function update_travel_order(Request $request){
        try {
            $data = $request->validate([
                'id' => 'required|exists:obs,id'
            ]);
            
            $datesched = request('datesched');
            $location = request('location');
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
    
            $obData = DB::table('obs')
            ->where('id', $id)
            ->first();

            if(!$obData){
                return response()->json(['message' => 'Invalid Overtime ID']);
            }
            $employee_no = $obData->employee_no;
            $checkIfDateAlreadyExistForThisUser = DB::table('obs')
            ->where("employee_no", "=", $employee_no)
            ->where("date_sched", "=", $datesched)
            ->where('id', '!=', $id)
            ->count();

            if($checkIfDateAlreadyExistForThisUser > 0){
                return response()->json(['message' => 'Date already Exist for this user.']);
            }

            if($datesched != null && $location != null && $remarks != null){

                DB::table('obs')
                ->where('id', $id)
                ->update([
                    'date_sched' => $datesched,
                    'location' => $location,
                    'remarks'   =>  $remarks,
                ]);
        

                DB::table('employee_attendance_posts')
                ->where('employee_no', $employee_no)
                ->where('date', $datesched)
                ->update(['date' => $datesched]);

                return response()->json(['message' => 'success']);


            }else{
                return back()->with('error','Please Fill Out This Form!');
            }

        } catch (\Exception $ex) {
            return response()->json(['message' => $ex->getMessage()]);
        }
    }
}
