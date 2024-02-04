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
use App\slvls;
use App\employees;
use App\overtimes_logs;
use DataTables;
use Validator;

class SlvlController extends Controller
{
    /*--------------------------------------------------------------
    # SLVL
    --------------------------------------------------------------*/

    /*--------------------------------------------------------------
    # SLVL NAV 
    --------------------------------------------------------------*/
    public function slvlnav()
    {
        $employees = DB::table('employees')
                    ->orderBy('lastname', 'ASC')
                    ->get();

                    $empposts = DB::table('emp_posts')
                    ->select('employeeattendanceid')
                    ->orderBy('employeeattendanceid', 'ASC')
                    ->limit(1)
                    ->get();

        return view('HR.slvl_nav', compact('employees','empposts'));
    }

    /*--------------------------------------------------------------
    # SLVL
    --------------------------------------------------------------*/ 
    /*--------------------------------------------------------------
    # DISPLAY SLVL RECORDS
    --------------------------------------------------------------*/ 

    public function slvldata(Request $request)
    {
                $slvls = DB::table('slvls')
                ->join('employees', 'slvls.employee_no', '=', 'employees.employee_no')
                /* ->select(DB::raw('CONCAT(employees.firstname, ", ", employees.lastname) as fullname'),'overtimes.*') */
                ->select('employees.firstname', 'slvls.*')
                ->orderBy('date_sched', 'DESC')
                ->get();

                return DataTables::of($slvls)
                ->make(true);
    }


    /*--------------------------------------------------------------
    # ADD SLVL RECORDS
    --------------------------------------------------------------*/
    public function addslvl(Request $request)
    {
        
        /* $employee_no = request('employee_no'); */
        $employeeattendanceid = request('employeeattendanceid');
        $employee_name = request('employee_name');
        $datesched = request('datesched');
        $type = request('type');
        $status = request('status');
        $remarks = request('remarks');

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

        try{

                $sllimit = DB::table('sickleave')
                ->where("employee_no", "=", $employee_no)
                ->where("modifieddate", "=", $datesched)
                ->count();

                $vllimit = DB::table('vacationleave')
                ->where("employee_no", "=", $employee_no)
                ->where("modifieddate", "=", $datesched)
                ->count();

                if($vllimit < 11){


                if($sllimit < 11){

                $filter = DB::table('slvls')
                ->where("employee_no", "=", $employee_no)
                ->where("date_sched", "=", $datesched)
                ->count();

                if($filter<1){
                    //$employeeattendanceid != null && 
                    if($employee_no != null && $employee_name != null && $type != null && $status != null){
                        $update = new slvls();
                        $update->employeeattendanceid   =   request('employeeattendanceid');
                        $update->employee_no   =   $employee_no;
                        $update->employee_name   =   $employee_name;
                        $update->date_sched   =   request('datesched');
                        $update->type   =   request('type');
                        $update->status   =   request('status');
                        $update->remarks   =   request('remarks');
                        $update->month = $getmonth;
                        $update->year = $getyear;
                        $update->period = $getperiod;
                        $update->save();

                        Log::info('Add SLVL');

                        $statuslogs = "
                        INSERT INTO statuslogs (linecode, functions, modifieddate) values ('SLVL', 'Add SLVL', getdate())
                        ";
                        DB::statement($statuslogs);

                        $employeeattendanceid = request('employeeattendanceid');

                        /* $updateattendance1 = "
                        insert into employee_attendance_posts(employeeattendanceid,employee_name,employee_no, date, day, schedin, schedout, in1, out2, hours_work, working_hour, totalhrsneeds, totalhrs, totalhrsearned, ctlate, minutes_late, udt, udt_hrs, nightdif, slvl, slvl_type, slvl_amount, period, status) 
                        values ('$employeeattendanceid','$employee_name','$employee_no', '$datesched', 'SLVL', '00:00:00.0000000', '00:00:00.0000000', '00:00', '00:00', '9.00', '8.00','0','9','9','0','0','-','0','0','$type','$status',
                        '0',
                        '$getperiod', '0')
                        ";
                        DB::statement($updateattendance1); */

                        DB::table('employee_attendance_posts')->insert([
                            'employeeattendanceid' => $employeeattendanceid,
                            'employee_name' => $employee_name,
                            'employee_no' => $employee_no,
                            'date' => $datesched,
                            'day' => 'SLVL',
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
                            'period' => $getperiod,
                            'status' => '0'
                        ]);

                        Log::info('Insert SLVL into employee_attendance_posts');

                        $statuslogs = "
                        INSERT INTO statuslogs (linecode, functions, modifieddate) values ('SLVL', 'Insert SLVL into employee_attendance_posts', getdate())
                        ";
                        DB::statement($statuslogs);

                        $employees = DB::table('employees')
                                ->get();

                        $sl = "
                        INSERT INTO sickleave (employee_no, employee_name, type, slvldate, modifieddate) select '$employee_no','$employee_name','$status', '$datesched',  getdate() from slvls where type = 'SICK LEAVE' 
                        and month = '$getmonth' and year = '$getyear' and period = '$getperiod';
                        ";
                        DB::statement($sl);

                        $vl = "
                        INSERT INTO vacationleave (employee_no, employee_name, type, slvldate, modifieddate) select '$employee_no','$employee_name','$status', '$datesched', getdate() from slvls where type = 'VACATION LEAVE' 
                        and month = '$getmonth' and year = '$getyear' and period = '$getperiod';
                        ";
                        DB::statement($vl);

                        $ml = "
                        INSERT INTO vacationleave (employee_no, employee_name, type, slvldate, modifieddate) select '$employee_no','$employee_name','$status', '$datesched', getdate() from slvls where type = 'MATERNITY LEAVE' 
                        and month = '$getmonth' and year = '$getyear' and period = '$getperiod';
                        ";
                        DB::statement($ml);

                        Log::info('SLVL Added Successfully!');

                        $statuslogs = "
                        INSERT INTO statuslogs (linecode, functions, modifieddate) values ('SLVL', 'SLVL Added Successfully!', getdate())
                        ";
                        DB::statement($statuslogs);
                
                        return back()->with('employees', $employees)->with('success','SLVL Added Successfully!'); 

                        }else{

                            Log::info('Please Fill Out This Form!');

                                $statuslogs = "
                                INSERT INTO statuslogs (linecode, functions, modifieddate) values ('SLVL', 'Please Fill Out This Form!', getdate())
                                ";
                                DB::statement($statuslogs);

                            return back()->with('error','Please Fill Out This Form!');
                        }
                
                }else{

                    Log::info('Data is already exist!');

                                $statuslogs = "
                                INSERT INTO statuslogs (linecode, functions, modifieddate) values ('SLVL', 'Data is already exist!', getdate())
                                ";
                                DB::statement($statuslogs);

                    return back()->with('error','Data is already exist!');
                }

                }else{

                    Log::info('SL LIMIT');

                                $statuslogs = "
                                INSERT INTO statuslogs (linecode, functions, modifieddate) values ('SLVL', 'Your utilization of SL is restricted!', getdate())
                                ";
                                DB::statement($statuslogs);

                    return back()->with('error','Data is already exist!');
                }

            }else{

                Log::info('VL LIMIT');

                            $statuslogs = "
                            INSERT INTO statuslogs (linecode, functions, modifieddate) values ('SLVL', 'Your utilization of VL is restricted!', getdate())
                            ";
                            DB::statement($statuslogs);

                return back()->with('error','Data is already exist!');
            }


        }catch(\Exception $e){

            Log::info($e->getMessage());

            $statuslogs = "
            INSERT INTO statuslogs (linecode, functions, modifieddate) values ('SLVL', 'DATA ERROR', getdate())
             ";
            DB::statement($statuslogs);

            return back()->with('exception', $e->getMessage());
        }
    }

     /*--------------------------------------------------------------
    # DELETE SLVL
    --------------------------------------------------------------*/

    public function delete_slvl($id){
        $tableName = 'slvls';
        $idToDelete = $id; 
        
        $recordExists = DB::table($tableName)->where('id', $idToDelete)->exists();
        if ($recordExists) {
            DB::table($tableName)->where('id', $idToDelete)->delete();
            
            return response()->json(['message' => 'success']);
        } else {
            return response()->json(['message' => 'fail']);
        }
    }

    /*--------------------------------------------------------------
    # UPDATE SLVL
    --------------------------------------------------------------*/
    public function update_slvl(Request $request){
        try {
            $data = $request->validate([
                'id' => 'required|exists:rank_files,id',
                'rank_file_code' => 'required|unique:rank_files,rank_file_code,' . $request->id,
                'rank_file' => 'required|string',
            ]);
            DB::table('rank_files')
            ->where('id', $data['id'])
            ->update([
                'rank_file_code' => $data['rank_file_code'],
                'rank_file' => $data['rank_file'],
            ]);
            return response()->json(['message' => 'success']);
        } catch (\Exception $ex) {
            return response()->json(['message' => $ex->getMessage()]);
        }
    }


}
