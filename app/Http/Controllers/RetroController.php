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
use App\retros;
use DataTables;
use Validator;

class RetroController extends Controller
{
    /*--------------------------------------------------------------
    # RETRO
    --------------------------------------------------------------*/ 
    /*--------------------------------------------------------------
    # VIEW DATA
    --------------------------------------------------------------*/ 
    public function retronav(Request $request)
    {
        $employees = DB::table('employees')
                    ->orderBy('lastname', 'ASC')
                    ->get();

        $empposts = DB::table('emp_posts')
                    ->select('employeeattendanceid')
                    ->orderBy('employeeattendanceid', 'DESC')
                    ->limit(1)
                    ->get();
        return view('HR.retro_nav', ['employees'=>$employees]);
    }

    public function retrodata(Request $request)
    {
                $retros = DB::table('retros')
                ->join('employees', 'retros.employee_no', '=', 'employees.employee_no')
                ->select('employees.firstname', 'retros.*')
                ->orderBy('active_date', 'DESC')
                ->get();

                return DataTables::of($retros)
                ->make(true);
    }
    
    public function addretro(Request $request)
    {
        $employeeattendanceid = request('employeeattendanceid');
        $employee_name = request('employee_name');
        $working_schedule = request('working_schedule');
        $active_date = request('working_schedule');
        $retrohrs = request('retrohrs');

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

        $getday = Carbon::parse($working_schedule)->format('d');
        $getmonth = Carbon::parse($working_schedule)->format('F');
        $getyear = Carbon::parse($working_schedule)->format('Y');


        if((int)$getday < 15){
            $getperiod = "1st Period";
        }else{
            $getperiod = "2nd Period";
        }


        $filter = DB::table('retros')
        ->where("employee_no", "=", $employee_no)
        ->where("working_schedule", "=", $working_schedule)
        ->count();

        if($filter<1){

            if($employee_name != '' || $working_schedule != '' || $retrohrs != '' || $active_date != ''){
                $update = new retros();
                $update->employee_no   =   $employee_no ; 
                $update->employee_name   =   $fullname; 
                $update->working_schedule   =   request('date');
                $update->active_date   =   request('activedate');
                $update->retrohrs   =   request('retrohrs');
                $update->remarks   =   request('remarks');
                $update->month   =   $getmonth;
                $update->year   = $getyear;
                $update->period   =   $getperiod ;
                $update->save();

                $employees = DB::table('employees')
                        ->get();

                return back()->with('employees', $employees)->with('success','Retro Added Successfully!'); 

                }else{
                    return back()->with('error','Please Fill Out This Form!');
                }
        
        }else{
            return back()->with('error','Data is already exist!');
        }


    }
}
