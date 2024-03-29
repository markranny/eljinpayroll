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
use App\set_holidays;
use App\employees;
use DataTables;
use Validator;


class HolidayController extends Controller
{
    /*--------------------------------------------------------------
    # HOLIDAY
    --------------------------------------------------------------*/
    /*--------------------------------------------------------------
    # HOLIDAY NAV 
    --------------------------------------------------------------*/
    public function holidaynav()
    {
        $employees = DB::table('employees')
                    ->orderBy('lastname', 'ASC')
                    ->get();

                    $empposts = DB::table('emp_posts')
                    ->select('employeeattendanceid')
                    ->orderBy('employeeattendanceid', 'ASC')
                    ->limit(1)
                    ->get();

        return view('HR.holiday_nav', compact('employees','empposts'));
    }

    /*--------------------------------------------------------------
    # SET HOLIDAY
    --------------------------------------------------------------*/ 
    /*--------------------------------------------------------------
    # DISPLAY HOLIDAY RECORDS
    --------------------------------------------------------------*/ 

    public function holidaydata(Request $request)
    {
                $set_holidays = DB::table('set_holidays')
                ->select('employeeattendanceid', 'type', 'date_sched')
                ->distinct()
                ->get();

                return DataTables::of($set_holidays)
                ->make(true);
    }

    /*--------------------------------------------------------------
    # ADD HOLIDAY RECORDS
    --------------------------------------------------------------*/ 
    public function addholiday(Request $request)
    {
        $employeeattendanceid = request('employeeattendanceid');
        $datesched = request('datesched');
        $dtype = request('holidaytype');

        $getday = Carbon::parse($datesched)->format('d');
        $getmonth = Carbon::parse($datesched)->format('F');
        $getyear = Carbon::parse($datesched)->format('Y');

        if((int)$getday < 15){
            $getperiod = "1st Period";
        }else{
            $getperiod = "2nd Period";
        }

        $filter = DB::table('set_holidays')
        ->select('date_sched')
        ->whereNotIn('date_sched', function ($query) {
            $query->select('date_sched')
                ->from('set_holidays');
        })
        ->count();

        if($filter<1){

            if($datesched != null && $dtype != null){

                    //INSERT HOLIDAY INTO SET HOLIDAYS TABLE
                    $updateattendance1 = "
                    insert into set_holidays(employeeattendanceid, employee_no, employee_name, date_sched, type, month, period, year) 
                    
                    select '$employeeattendanceid', a.employee_no, CONCAT(a.lastname, ' ', a.firstname), '$datesched', '$dtype', '$getmonth', '$getperiod', 
                    '$getyear' from employees a inner join employee_attendance_posts b on a.employee_no = b.employee_no
                    where b.date = '$datesched'
                    ";

                    DB::statement($updateattendance1);

                    Log::info('Add Holiday to set_holidays table');

                    $statuslogs = "
                    INSERT INTO statuslogs (linecode, functions, modifieddate) values ('HOLIDAY', 'Add Holiday to set_holidays table', getdate())
                    ";
                    DB::statement($statuslogs);


                    //INSERT HOLIDAY INTO SET HOLIDAYTOEAPS TABLE
                    $IHT = "
                    insert into holidaytoeaps (employeeattendanceid, employee_no, employee_name, date, holiday_type, modifieddate)
                    select b.employeeattendanceid, a.employee_no, a.fullname, b.date_sched, '$dtype', getdate()
                    from employees a inner join set_holidays b on a.employee_no != b.employee_no 
                    
                    ";

                    DB::statement($IHT);

                    Log::info('Add Holiday to holidaytoeaps table');

                    $statuslogs = "
                    INSERT INTO statuslogs (linecode, functions, modifieddate) values ('HOLIDAY', 'Add Holiday to holidaytoeaps table', getdate())
                    ";
                    DB::statement($statuslogs);



                    $result = DB::table('set_holidays')
                    ->where('date_sched', $datesched)
                    ->where(function($query) {
                        $query->where('type', '!=', 'Special Working Holiday')
                            ->orWhere('type', '!=', 'Special Non Working Holiday');
                    })
                    ->count();


                    if($result>1){

                        DB::table('employee_attendance_posts as b')
                            ->join('set_holidays as a', 'a.employee_no', '=', 'b.employee_no')
                            ->leftJoin('employees as c', 'a.employee_no', '=', 'c.employee_no')
                            ->where('b.date', $datesched)
                            ->update([
                                'b.day' => 'HOLIDAY',
                                'b.holiday_type' => $dtype,
                                'b.holiday_percent' => DB::raw("CASE 
                                                                    WHEN b.holiday_type = 'Regular Holiday' THEN '200' 
                                                                    WHEN b.holiday_type = 'Special Working Holiday' THEN '30' 
                                                                    WHEN b.holiday_type = 'Legal Holiday' THEN '200' 
                                                                    WHEN b.holiday_type = 'Special Non-Working Holiday' THEN '30' 
                                                                    ELSE ''
                                                                END"),
                                'b.holiday_amount' => DB::raw("CASE 
                                                                    WHEN b.holiday_type = 'Regular Holiday' THEN FORMAT(cast(c.pay_rate as float) * 2, 'F2') 
                                                                    WHEN b.holiday_type = 'Special Working Holiday' THEN FORMAT(cast(c.pay_rate as float) * 0.30, 'F2') 
                                                                    WHEN b.holiday_type = 'Legal Holiday' THEN FORMAT(cast(c.pay_rate as float) * 2, 'F2') 
                                                                    WHEN b.holiday_type = 'Special Non-Working Holiday' THEN FORMAT(cast(c.pay_rate as float) * 0.30, 'F2') 
                                                                    ELSE '0' 
                                                                END")
                            ]);

                            Log::info('Insert Holiday into employee_attendance_posts 1');

                            $statuslogs = "
                            INSERT INTO statuslogs (linecode, functions, modifieddate) values ('HOLIDAY', 'Insert Holiday into employee_attendance_posts 1', getdate())
                            ";

                            DB::statement($statuslogs);

                    }else{
                        $updateattendance5 = "
                                insert into employee_attendance_posts(employeeattendanceid,empcode,employee_name,employee_no, date, day, schedin, schedout, in1, out2, hours_work, working_hour, minutes_late, udt, udt_hrs,ctlate, holiday_type, holiday_percent, holiday_amount, nightdif, period, status) 
                                select Distinct '0000000001','21012', c.fullname, c.employee_no, '2023-09-30', 'HOLIDAY', '00:00:00.0000000','00:00:00.0000000','00:00', '00:00', '9.00', '8.00','0','-','0','0','$dtype',
                                case when b.holiday_type = 'Regular Holiday' then '100' 
                                when b.holiday_type = 'Special Working Holiday' then '30' 
                                when b.holiday_type = 'Special Working Holiday' then '30' 
                                when b.holiday_type = 'Legal Holiday' then '100' 
                                when b.holiday_type = 'Special Non-Working Holiday' then '30' else '' end, 
                                                            
                                case when b.holiday_type = 'Regular Holiday' then FORMAT(cast(c.pay_rate as float) * 1, 'F2') 
                                when b.holiday_type = 'Legal Holiday' then FORMAT(cast(c.pay_rate as float) * 1, 'F2')  else '0' end holidayamount,

                                '0','2nd Period','0' from holidaytoeaps b
                                left join employees c on b.employee_no = c.employee_no 
                                
                            ";

                            DB::statement($updateattendance5);

                            Log::info('Insert Regular Holiday into employee_attendance_posts');

                            $statuslogs = "
                            INSERT INTO statuslogs (linecode, functions, modifieddate) values ('HOLIDAY', 'Insert Regular Holiday into employee_attendance_posts', getdate())
                            ";
        
                            DB::statement($statuslogs);
                    }
                


                    return Redirect::back()->with('success','Set Holiday Successfully!');

                }else{

                    Log::info('Please Fill Out This Form!');

                    $statuslogs = "
                    INSERT INTO statuslogs (linecode, functions, modifieddate) values ('HOLIDAY', 'Please Fill Out This Form!', getdate())
                    ";

                    DB::statement($statuslogs);

                    return back()->with('error','Please Fill Out This Form!');
                }
        
            }else{

                Log::info('Data is already exist!');

                $statuslogs = "
                INSERT INTO statuslogs (linecode, functions, modifieddate) values ('HOLIDAY', 'Data is already exist!', getdate())
                ";

                DB::statement($statuslogs);

                return back()->with('error','Data is already exist!');
        }
    }
}
