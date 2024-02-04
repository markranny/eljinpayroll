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

                $updateattendance1 = "
                insert into set_holidays(employeeattendanceid, employee_no, employee_name, date_sched, type, month, period, year) select '$employeeattendanceid', employee_no, CONCAT(employees.lastname, ' ', employees.firstname), '$datesched', '$dtype', '$getmonth', '$getperiod', '$getyear' from employees
                ";

                DB::statement($updateattendance1);

                Log::info('Add Holiday');

                $statuslogs = "
                INSERT INTO statuslogs (linecode, functions, modifieddate) values ('HOLIDAY', 'Add Holiday', getdate())
                ";
                DB::statement($statuslogs);
                

                /* $updateattendance3 = "
                    insert into employee_attendance_posts(employeeattendanceid,empcode,employee_name,employee_no, date, day, schedin, schedout, in1, out2, hours_work, working_hour, minutes_late, udt, 
                    udt_hrs, ctlate, nightdif, holiday_type, holiday_percent, holiday_amount, period, status) 
                    select Distinct '$employeeattendanceid','21002', a.employee_name, a.employee_no, '$datesched', 'HOLIDAY', '00:00:00.0000000','00:00:00.0000000', b.in1, b.out2, '9.00', '8.00','0','-','0','0','0','$dtype',
        
                    case when a.type = 'Regular Holiday' then '200' 
                    when a.type = 'Special Working Holiday' then '30' 
                    when a.type = 'Special Working Holiday' then '30' 
                    when a.type = 'Legal Holiday' then '200' 
                    when a.type = 'Special Non-Working Holiday' then '30' else '' end, 
                   
                    case when a.type = 'Regular Holiday' then FORMAT(cast(c.pay_rate as float) * 2, 'F2') 
                    when a.type = 'Special Working Holiday' then FORMAT(cast(c.pay_rate as float) * .30, 'F2') 
                    when a.type = 'Special Working Holiday' then FORMAT(cast(c.pay_rate as float) * .30, 'F2') 
                    when a.type = 'Legal Holiday' then FORMAT(cast(c.pay_rate as float) * 2, 'F2') 
                    when a.type = 'Special Non-Working Holiday' then FORMAT(cast(c.pay_rate as float) * .30, 'F2') else '0' end holidayamount,
                    
                    '$getperiod','0' from set_holidays a left join employee_attendance_posts b on a.employee_no = b.employee_no left join employees c on b.employee_no = c.employee_no where b.date = '$datesched'
                ";

                DB::statement($updateattendance3); */

                $updateattendance3 = "
                UPDATE employee_attendance_posts
                SET 
                    day = 'HOLIDAY',
                    holiday_type = '$dtype',
                    holiday_percent = CASE 
                        WHEN a.type = 'Regular Holiday' THEN '200' 
                        WHEN a.type = 'Special Working Holiday' THEN '30' 
                        WHEN a.type = 'Legal Holiday' THEN '200' 
                        WHEN a.type = 'Special Non-Working Holiday' THEN '30' 
                        ELSE ''
                    END,
                    holiday_amount = CASE 
                        WHEN a.type = 'Regular Holiday' THEN FORMAT(cast(c.pay_rate as float) * 2, 'F2') 
                        WHEN a.type = 'Special Working Holiday' THEN FORMAT(cast(c.pay_rate as float) * 0.30, 'F2') 
                        WHEN a.type = 'Legal Holiday' THEN FORMAT(cast(c.pay_rate as float) * 2, 'F2') 
                        WHEN a.type = 'Special Non-Working Holiday' THEN FORMAT(cast(c.pay_rate as float) * 0.30, 'F2') 
                        ELSE '0' 
                    END
                FROM 
                    set_holidays a
                    LEFT JOIN employees c ON a.employee_no = c.employee_no
                    LEFT JOIN employee_attendance_posts b ON a.employee_no = b.employee_no
                WHERE 
                    b.date = '$datesched';
                ";

                Log::info('Insert Holiday into employee_attendance_posts 1');

                $statuslogs = "
                INSERT INTO statuslogs (linecode, functions, modifieddate) values ('HOLIDAY', 'Insert Holiday into employee_attendance_posts 1', getdate())
                ";

                DB::statement($statuslogs);

                Log::info('Transfer empcode 21002');

                $statuslogs = "
                INSERT INTO statuslogs (linecode, functions, modifieddate) values ('HOLIDAY', 'Transfer empcode 21002', getdate())
                ";

                DB::statement($statuslogs);

                $updateattendance4 = "
                update employee_attendance_posts set empcode = '21010' where employee_no in (select employee_no from set_holidays where date_sched = '$datesched') and date = '$datesched' and empcode = '21002'
                ";

                DB::statement($updateattendance4);

                Log::info('Update empcode 21002 to 21010');

                $statuslogs = "
                INSERT INTO statuslogs (linecode, functions, modifieddate) values ('HOLIDAY', 'Update empcode 21002 to 21010', getdate())
                ";

                DB::statement($statuslogs);

                $result = DB::table('set_holidays')
                ->where('date_sched', '2023-09-30')
                ->where(function($query) {
                    $query->where('type', '!=', 'Special Working Holiday')
                        ->orWhere('type', '!=', 'Special Non Working Holiday');
                })
                ->count();


                if($result<1){

                $updateattendance5 = "
                    insert into employee_attendance_posts(employeeattendanceid,empcode,employee_name,employee_no, date, day, schedin, schedout, in1, out2, hours_work, working_hour, minutes_late, udt, udt_hrs,ctlate, holiday_type, holiday_percent, holiday_amount, nightdif, period, status) 
                    select Distinct '$employeeattendanceid','21012', a.employee_name, a.employee_no, '$datesched', 'HOLIDAY', '00:00:00.0000000','00:00:00.0000000','00:00', '00:00', '9.00', '8.00','0','-','0','0','$dtype',
                    case when a.type = 'Regular Holiday' then '200' 
                    when a.type = 'Special Working Holiday' then '30' 
                    when a.type = 'Special Working Holiday' then '30' 
                    when a.type = 'Legal Holiday' then '200' 
                    when a.type = 'Special Non-Working Holiday' then '30' else '' end, 
                   
                    case when a.type = 'Regular Holiday' then FORMAT(cast(c.pay_rate as float) * 2, 'F2') 
                    when a.type = 'Special Working Holiday' then FORMAT(cast(c.pay_rate as float) * .30, 'F2') 
                    when a.type = 'Special Working Holiday' then FORMAT(cast(c.pay_rate as float) * .30, 'F2') 
                    when a.type = 'Legal Holiday' then FORMAT(cast(c.pay_rate as float) * 2, 'F2') 
                    when a.type = 'Special Non-Working Holiday' then FORMAT(cast(c.pay_rate as float) * .30, 'F2') else '0' end holidayamount,

                    '0','$getperiod','0' from set_holidays a left join employee_attendance_posts b on a.employee_no = b.employee_no left join employees c on b.employee_no = c.employee_no
                     where b.date != '$datesched' and b.empcode != '21010'
                ";

                DB::statement($updateattendance5);

                Log::info('Insert Holiday into employee_attendance_posts 2');

                $statuslogs = "
                INSERT INTO statuslogs (linecode, functions, modifieddate) values ('HOLIDAY', 'Insert Holiday into employee_attendance_posts 2', getdate())
                ";

                DB::statement($statuslogs);

                }


               /*  $updateattendance7 = "
                Delete FROM employee_attendance_posts WHERE cast(date as date) = '$datesched' and employee_no = employee_no and holiday_type is null and day != 'HOLIDAY'
                ";

                DB::statement($updateattendance7);

                Log::info('Clean Data');

                $statuslogs = "
                INSERT INTO statuslogs (linecode, functions, modifieddate) values ('HOLIDAY', 'Clean Data', getdate())
                ";

                DB::statement($statuslogs); */

                $updateattendance8 = "
                update employee_attendance_posts set empcode = '21012' where empcode = '21010'
                ";

                DB::statement($updateattendance8);

                Log::info('update holiday empcode 21010 to 21012');

                $statuslogs = "
                INSERT INTO statuslogs (linecode, functions, modifieddate) values ('HOLIDAY', 'update holiday empcode 21010 to 21012', getdate())
                ";

                DB::statement($statuslogs);

                Log::info('Set Holiday Successfully!');

                $statuslogs = "
                INSERT INTO statuslogs (linecode, functions, modifieddate) values ('HOLIDAY', 'Set Holiday Successfully!', getdate())
                ";

                DB::statement($statuslogs);

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
