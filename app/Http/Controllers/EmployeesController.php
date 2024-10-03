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
use App\employees_detail_temps;
use App\departments;
use App\employees;
use App\lines;
use App\rank_files;
use DataTables;
use Validator;

class EmployeesController extends Controller
{
    /*--------------------------------------------------------------
    # EMPLOYEES
    --------------------------------------------------------------*/

    /*--------------------------------------------------------------
    # EMPLOYEE NAV 
    --------------------------------------------------------------*/

    public function importdEmpnav()
    {
        return view('HR.Import_Employees');
    }

    public function employeeinfonav()
    {
        return view('HR.Employee_infos_nav');
    }

    public function ienav()
    {
        $employees = DB::table('employees')
                    ->orderBy('lastname', 'ASC')
                    ->get();

                    $empposts = DB::table('emp_posts')
                    ->select('employeeattendanceid')
                    ->orderBy('employeeattendanceid', 'ASC')
                    ->limit(1)
                    ->get();

        return view('HR.ie_nav', compact('employees','empposts'));
    }

    public function depnav()
    {
        $employees = DB::table('employees')
                    ->orderBy('lastname', 'ASC')
                    ->get();

                    $empposts = DB::table('emp_posts')
                    ->select('employeeattendanceid')
                    ->orderBy('employeeattendanceid', 'ASC')
                    ->limit(1)
                    ->get();

        return view('HR.dep_nav', compact('employees','empposts'));
    }

    public function linenav()
    {
        $employees = DB::table('employees')
                    ->orderBy('lastname', 'ASC')
                    ->get();

                    $empposts = DB::table('emp_posts')
                    ->select('employeeattendanceid')
                    ->orderBy('employeeattendanceid', 'ASC')
                    ->limit(1)
                    ->get();

        return view('HR.line_nav', compact('employees','empposts'));
    }

    public function rankfilenav()
    {
        $employees = DB::table('employees')
                    ->orderBy('lastname', 'ASC')
                    ->get();

                    $empposts = DB::table('emp_posts')
                    ->select('employeeattendanceid')
                    ->orderBy('employeeattendanceid', 'ASC')
                    ->limit(1)
                    ->get();

        return view('HR.rankfile_nav', compact('employees','empposts'));
    }

    /*--------------------------------------------------------------
    # DISPLAY EMPLOYEE INFO. 
    --------------------------------------------------------------*/

    public function Empdata(Request $request)
    {
                $employees = DB::table('employees')
                ->get();

                return DataTables::of($employees)
                ->addColumn('action', function($request){
                    $btn = ' <a href="#" data-toggle="tooltip"  data-id="'.$request->id.'" data-original-title="view" class="btn btn-success btn-sm View"><span class="material-symbols-outlined">View More Info</span></a>';
        
                return $btn;
                })
                ->make(true);
    }

    /*--------------------------------------------------------------
    # UPDATE EMPLOYEE INFO. 
    --------------------------------------------------------------*/

    public function getEmployee($employee_no)
    {
        $employee = Employees::where('employee_no', $employee_no)->first();
        if (!$employee) {
            return response()->json(['error' => 'Employee not found'], 404);
        }
        \Log::info('Employee data:', $employee->toArray());
        return response()->json($employee);
    }

    public function updateEmployee(Request $request)
    {
        $employee = Employees::where('employee_no', $request->empno)->first();
        if (!$employee) {
            return response()->json(['error' => 'Employee not found'], 404);
        }
        $employee->update($request->all());
        return response()->json(['message' => 'Employee updated successfully']);
    }


    /*--------------------------------------------------------------
    # DISPLAY UPLOADED EMPLOYEE INFO. 
    --------------------------------------------------------------*/
    public function importEmpdata(Request $request)
    {
        $employees_detail_temps = DB::table('employees_detail_temps')
                ->get();

                return DataTables::of($employees_detail_temps)
                ->make(true);
    }

    /*--------------------------------------------------------------
    # VIEW INACTIVE EMPLOYEES
    --------------------------------------------------------------*/
    public function iedata(Request $request)
    {
        $employees = DB::table('employees')
                ->where('employee_status', '=', 'INACTIVE')
                ->get();

                return DataTables::of($employees)
                ->make(true);
    }

    /*--------------------------------------------------------------
    # VIEW DEPARTMENT
    --------------------------------------------------------------*/
    public function depdata(Request $request)
    {
    $departments = DB::table('departments')
                ->get();

                return DataTables::of($departments)
                ->make(true);
    }

    /*--------------------------------------------------------------
    # DELETE DEPARTMENT
    --------------------------------------------------------------*/

    public function delete_department($id){
        $tableName = 'departments';
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
    # UPDATE DEPARTMENT
    --------------------------------------------------------------*/

    public function update_department(Request $request){
        try {
            $data = $request->validate([
                'id' => 'required|exists:departments,id',
                'dept_code' => 'required|unique:departments,dept_code,' . $request->id,
                'department' => 'required|string',
            ]);
            DB::table('departments')
            ->where('id', $data['id'])
            ->update([
                'dept_code' => $data['dept_code'],
                'department' => $data['department'],
            ]);
            return response()->json(['message' => 'success']);
        } catch (\Exception $ex) {
            return response()->json(['message' => $ex->getMessage()]);
        }
    }
    /*--------------------------------------------------------------
    # ADD DEPARTMENT
    --------------------------------------------------------------*/ 
    public function adddep(Request $request)
    {
        $depcode = request('dep_code');
        $department = request('department');

            if($depcode != null && $department != null){
                $update = new departments();
                $update->dept_code   =   $depcode;
                $update->department   =   $department;
                $update->save();

                //LOGS
                Log::info('Add Department');

                $data = [
                    'linecode' => 'DEPARTMENT',
                    'functions' => 'Add Department',
                    'modifieddate' => now(), 
                ];

                DB::table('statuslogs')->insert($data);

                $employees = DB::table('employees')
                ->get();


                //LOGS
                Log::info('Department Added Successfully!');

                DB::table('statuslogs')->insert([
                    'linecode' => 'DEPARTMENT',
                    'functions' => 'Department Added Successfully!',
                    'modifieddate' => DB::raw('getdate()'),
                ]);

                return back()->with('success','Department Added Successfully!');

            }else{
                
                //LOGS
                Log::info('Please Fill out the form!');

                DB::table('statuslogs')->insert([
                    'linecode' => 'DEPARTMENT',
                    'functions' => 'Please Fill out the form!',
                    'modifieddate' => DB::raw('getdate()'),
                ]);

                return back()->with('error','Please Fill out the form!');
            }
    }

    /*--------------------------------------------------------------
    # VIEW LINE/SECTION
    --------------------------------------------------------------*/
    public function linedata(Request $request)
    {
        $lines = DB::table('lines')
        ->get();

        return DataTables::of($lines)
        ->make(true);
    }
    /*--------------------------------------------------------------
    # DELETE LINE/SECTION
    --------------------------------------------------------------*/

    public function delete_linedata($id){
        $tableName = 'lines';
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
    # UPDATE LINE/SECTION
    --------------------------------------------------------------*/

    public function update_linedata(Request $request){
        try {
            $data = $request->validate([
                'id' => 'required|exists:lines,id',
                'code' => 'required|unique:lines,code,' . $request->id,
                'description' => 'required|string',
            ]);
            DB::table('lines')
            ->where('id', $data['id'])
            ->update([
                'code' => $data['code'],
                'descriptions' => $data['description'],
            ]);
            return response()->json(['message' => 'success']);
        } catch (\Exception $ex) {
            return response()->json(['message' => $ex->getMessage()]);
        }
    }

    /*--------------------------------------------------------------
    # ADD LINE
    --------------------------------------------------------------*/ 
    public function addline(Request $request)
    {
        $code = request('code');
        $descriptions = request('descriptions');

            if($code != null && $descriptions != null){
                $update = new lines();
                $update->code   =   $code;
                $update->descriptions   =   $descriptions;
                $update->save();

                //LOGS
                Log::info('Add Line/Section');

                DB::table('statuslogs')->insert([
                    'linecode' => 'LINE',
                    'functions' => 'Add Line/Section',
                    'modifieddate' => now(),
                ]);

                $employees = DB::table('employees')->get();

                Log::info('Line/Section Added Successfully!');

                DB::table('statuslogs')->insert([
                    'linecode' => 'LINE',
                    'functions' => 'Line/Section Added Successfully!',
                    'modifieddate' => now(),
                ]);  
                
                return back()->with('success','Lne/Section Added Successfully!');


            }else{

                //LOGS
                Log::info('Please Fill out the form!');

                DB::table('statuslogs')->insert([
                    'linecode' => 'LINE',
                    'functions' => 'Please Fill out the form!',
                    'modifieddate' => now(),
                ]);

                return back()->with('error','Please Fill out the form!');
            }
    }

    /*--------------------------------------------------------------
    # VIEW RANKFILE
    --------------------------------------------------------------*/
    public function rankfiledata(Request $request)
    {
    $rank_files = DB::table('rank_files')
                ->get();

                return DataTables::of($rank_files)
                ->make(true); 
    }

    /*--------------------------------------------------------------
    # DELETE RANKFILE
    --------------------------------------------------------------*/

    public function delete_rankfile($id){
        $tableName = 'rank_files';
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
    # UPDATE RANKFILE
    --------------------------------------------------------------*/
    public function update_rankfile(Request $request){
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
    /*--------------------------------------------------------------
    # ADD RANKFILE
    --------------------------------------------------------------*/ 
    public function addrankfile(Request $request)
    {
        $rank_file_code = request('rank_file_code');
        $rank_file = request('rank_file');

            if($rank_file_code != null && $rank_file != null){
                $update = new rank_files();
                $update->rank_file_code   =   $rank_file_code;
                $update->rank_file   =   $rank_file;
                $update->save();

                //LOGS
                Log::info('Add Rank File');

                DB::table('statuslogs')->insert([
                    'linecode' => 'RANKFILE',
                    'functions' => 'Add Rank File',
                    'modifieddate' => now(), 
                ]);

                $employees = DB::table('employees')->get();

                Log::info('Rank File Added Successfully!');

                DB::table('statuslogs')->insert([
                    'linecode' => 'RANKFILE',
                    'functions' => 'Add Rank File Added Successfully!',
                    'modifieddate' => now(), 
                ]);

                return back()->with('success','Add Rank File Added Successfully!');


            }else{

                //LOGS
                Log::info('Please Fill out the form!');

                DB::table('statuslogs')->insert([
                    'linecode' => 'RANKFILE',
                    'functions' => 'Please Fill out the form!',
                    'modifieddate' => now(), 
                ]);

                return back()->with('error', 'Please Fill out the form!');
            }
    }


    /*--------------------------------------------------------------
    # UPLOAD EMPLOYEE INFORMATIONS
    --------------------------------------------------------------*/

    public function importE(Request $request)
    {

        $importpass = DB::table('employees_detail_temps')->count();

        $count = (int)$importpass;

        $file = request('file');

        try{
        if($count < 1)
        {
            
            $filePath = '//Progenx\PAYROLL SYSTEM\Employees\\'.$file;

            DB::table('employees_detail_temps')->truncate();

              $statement = "
                BULK INSERT dbo.employees_detail_temps
                FROM '//Progenx\PAYROLL SYSTEM\Employees\\".$file."'
                WITH
                (
                FIRSTROW = 2,
                FIELDTERMINATOR = ',', 
                ROWTERMINATOR = '\n'
                )
                ";
                DB::statement($statement);

            // LOGS
            Log::info('Employee details have been imported successfully!');

            DB::table('statuslogs')->insert([
                'linecode' => 'employees',
                'functions' => 'Employee details have been imported successfully!',
                'modifieddate' => now(), 
            ]);

            return back()->with('success', 'Employee details have been imported successfully!');            
        }

        else
        {
            // LOGS
            Log::info('Data import issue: Please remove your current data before proceeding with the import.');

            DB::table('statuslogs')->insert([
                'linecode' => 'employees',
                'functions' => 'Data import issue: Please remove your current data before proceeding with the import',
                'modifieddate' => now(),
            ]);

            return back()->with('erroruploademployee', 'Data import issue: Please remove your current data before proceeding with the import.');
        }

        }
        catch(\Exception $e){

            //LOGS
            Log::error($e->getMessage());

            DB::table('statuslogs')->insert([
                'linecode' => 'employees',
                'functions' => 'ERROR FILES',
                'modifieddate' => now(), 
            ]);

            return back()->with('exception', $e->getMessage());
        }   
    }

    /*--------------------------------------------------------------
    # CLEAR RECENT IMPORT DATA - EMPLOYEE INFORMATIONS
    --------------------------------------------------------------*/


    public function clearE(Request $request)
    {

        try {
            DB::table('employees_detail_temps')->truncate();
        
            /* LOGS */
            Log::info('Data has been successfully cleared!');
        
            DB::table('statuslogs')->insert([
                'linecode' => 'employees',
                'functions' => 'Data has been successfully cleared!',
                'modifieddate' => now(),
            ]);
        
            return back()->with('success', 'Data has been successfully cleared');
            
        } catch (\Exception $e) {
            //LOGS
            Log::error($e->getMessage());

            DB::table('statuslogs')->insert([
                'linecode' => 'employees',
                'functions' => 'NO DATA',
                'modifieddate' => now(),
            ]);
        
            return back()->with('exception', $e->getMessage());
        }
    }

    /*--------------------------------------------------------------
    # POST EMPLOYEE RECORDS - EMPLOYEE INFORMATIONS
    --------------------------------------------------------------*/
    
    public function palE(Request $request)
    {
        try {
            DB::table('employees')->insertUsing(
                [
                    'employee_no', 'lastname', 'firstname', 'middlename', 'suffix', 'gender', 'educational_attainment', 'degree',
                    'civil_status', 'birthdate', 'contact_no', 'email', 'present_address', 'permanent_address', 'emergency_contact_name',
                    'emergency_contact', 'emergency_relationship', 'employee_status', 'job_status', 'rank_file', 'department', 'line',
                    'job_title', 'hired_date', 'endcontract', 'pay_type', 'pay_rate', 'allowance', 'sss_no', 'philhealth_no', 'hdmf_no', 'tax_no', 'taxable', 'costcenter',
                    'empcode'
                ],
                function ($query) {
                    $query->select(
                        'employee_no', 'lastname', 'firstname', 'middlename', 'suffix', 'gender', 'educational_attainment', 'degree',
                        'civil_status', 'birthdate', 'contact_no', 'email', 'present_address', 'permanent_address', 'emergency_contact_name',
                        'emergency_contact', 'emergency_relationship', 'employee_status', 'job_status', 'rank_file', 'department', 'line',
                        'job_title', 'hired_date', 'endcontract', 'pay_type', 'pay_rate', 'allowance', 'sss_no', 'philhealth_no', 'hdmf_no', 'tax_no',
                        'taxable', 'costcenter', 'empcode'
                    )->from('employees_detail_temps');
                }
            );
        
            //LOGS
            Log::info('Insert employee details.');

            DB::table('statuslogs')->insert([
                'linecode' => 'employees',
                'functions' => 'Insert employee details.',
                'modifieddate' => now()
            ]);
        
            DB::table('employees_detail_temps')->truncate();
        
            //LOGS
            Log::info('Clean the data of employees_detail_temps');
        
            DB::table('statuslogs')->insert([
                'linecode' => 'employees',
                'functions' => 'Clean the data of employees_detail_temps',
                'modifieddate' => now()
            ]);
        
            //LOGS
            Log::info('The employee details have been successfully saved!');
        
            DB::table('statuslogs')->insert([
                'linecode' => 'employees',
                'functions' => 'The employee details have been successfully saved!',
                'modifieddate' => now()
            ]);

            employees::query()
            ->update([
                'fullname' => \DB::raw("CONCAT(lastname, ' ', firstname)")
            ]);

            //LOGS
            Log::info('Concat Fullname!');
        
            DB::table('statuslogs')->insert([
                'linecode' => 'employees',
                'functions' => 'Concat Fullname!',
                'modifieddate' => now()
            ]);
        
            return back()->with('success', 'Post All Lines Successfully!');
            
        } catch (\Exception $e) {
            return back()->with('exception', $e->getMessage());
        }
    }
}
