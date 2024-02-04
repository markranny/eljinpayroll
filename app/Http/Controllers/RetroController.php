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
        $employee_no = request('employee_no');
        $working_schedule = request('working_schedule');
        $active_date = request('working_schedule');

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

            if($employee_no != '' || $working_schedule != '' || $active_date != ''){
                $update = new retros();
                $update->employee_no   =   request('employee_no');
                $update->working_schedule   =   request('date');
                $update->active_date   =   request('activedate');
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
