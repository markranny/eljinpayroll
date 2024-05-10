<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('cls', function(){
    Artisan::call('clear-compiled');
    echo "clear-compiled: complete<br>";
    Artisan::call('cache:clear');
    echo "cache:clear: complete<br>";
    Artisan::call('config:clear');
    echo "config:clear: complete<br>";
    Artisan::call('view:clear');
    echo "view:clear: complete<br>";
    Artisan::call('optimize:clear');
    echo "optimize:clear: complete<br>";
    Artisan::call('config:cache');
    echo "config:cache: complete<br>";
    Artisan::call('view:cache');
    echo "view:cache: complete<br>";
  
  });

  Route::get('report', function(){
  
  });

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::get('/home', 'HomeController@index')->name('home');

//for deleted
Route::get('Fix', 'HomeController@fixed')->name('fixed');
Route::post('fltr-attendance-report', 'HomeController@fltrattreportnav')->name('fltrattreportnav');
Route::post('fltr-attendance-report-data', 'HomeController@fltrattreportdata')->name('fltrattreportdata');

/*--------------------------------------------------------------
    # PLUGINS
--------------------------------------------------------------*/
Route::get('employee-plugin', 'HomeController@empplugin')->name('empplugin')->middleware('is_hr');
Route::get('attendance-posts-plugin', 'HomeController@attendancepostsplugin')->name('attendancepostsplugin')->middleware('is_hr');


/*--------------------------------------------------------------
    # EMPLOYEES
--------------------------------------------------------------*/
Route::get('employee-infos', 'EmployeesController@employeeinfonav')->name('employeeinfonav')->middleware('is_hr');
Route::get('import-employee', 'EmployeesController@importdEmpnav')->name('importdEmpnav')->middleware('is_hr');
Route::get('employee-data', 'EmployeesController@Empdata')->name('Empdata')->middleware('is_hr');
Route::get('import-employee-data', 'EmployeesController@importEmpdata')->name('importEmpdata')->middleware('is_hr');
Route::post('upload-employee', 'EmployeesController@importE')->name('importE')->middleware('is_hr');
Route::get('clear-employee', 'EmployeesController@clearE')->name('clearE')->middleware('is_hr');
Route::get('post-employees', 'EmployeesController@palE')->name('palE')->middleware('is_hr');

Route::get('Inactive-Employees-Page', 'EmployeesController@ienav')->name('ienav')->middleware('is_hr');
Route::get('Inactive-Employees-List', 'EmployeesController@iedata')->name('iedata')->middleware('is_hr');

Route::get('department-page', 'EmployeesController@depnav')->name('depnav')->middleware('is_hr');
Route::get('department-list', 'EmployeesController@depdata')->name('depdata')->middleware('is_hr');
Route::post('add-department', 'EmployeesController@adddep')->name('adddep')->middleware('is_hr');
Route::get('/delete/department/{id}', 'EmployeesController@delete_department')->name('delete_department')->middleware('is_hr');
Route::post('/update/department/', 'EmployeesController@update_department')->name('update_department')->middleware('is_hr');

Route::get('line-page', 'EmployeesController@linenav')->name('linenav')->middleware('is_hr');
Route::get('line-list', 'EmployeesController@linedata')->name('linedata')->middleware('is_hr');
Route::get('/delete/linedata/{id}', 'EmployeesController@delete_linedata')->name('delete_linedata')->middleware('is_hr');
Route::post('/update/linedata/', 'EmployeesController@update_linedata')->name('update_linedata')->middleware('is_hr');
Route::post('add-line', 'EmployeesController@addline')->name('addline')->middleware('is_hr');

Route::get('rankfile-page', 'EmployeesController@rankfilenav')->name('rankfilenav')->middleware('is_hr');
Route::get('rankfile-list', 'EmployeesController@rankfiledata')->name('rankfiledata')->middleware('is_hr');
Route::post('add-rankfile', 'EmployeesController@addrankfile')->name('addrankfile')->middleware('is_hr');
Route::get('/delete/rankfile/{id}', 'EmployeesController@delete_rankfile')->name('delete_rankfile')->middleware('is_hr');
Route::post('/update/rankfile/', 'EmployeesController@update_rankfile')->name('update_rankfile')->middleware('is_hr');

/*--------------------------------------------------------------
    # SCHEDULE
--------------------------------------------------------------*/
Route::get('schedule_list', 'ScheduleController@schedlistnav')->name('schedlistnav')->middleware('is_hr');
Route::get('employee-schedule', 'ScheduleController@Scheddata')->name('Scheddata')->middleware('is_hr');
Route::get('schedule-infos/{sched_no}', 'ScheduleController@schedinfos')->name('schedinfos')->middleware('is_hr');
Route::get('schedule-infos-data/{id}', 'ScheduleController@schedinfosdata')->name('schedinfosdata')->middleware('is_hr');

Route::get('import-schedule', 'ScheduleController@importdEmpSchednav')->name('importdEmpSchednav')->middleware('is_hr');
Route::get('import-employee-schedule', 'ScheduleController@importScheddata')->name('importScheddata')->middleware('is_hr');
Route::post('upload-employee-schedule', 'ScheduleController@importS')->name('importS')->middleware('is_hr');
Route::get('clear-schedule', 'ScheduleController@clearS')->name('clearS')->middleware('is_hr');
Route::post('post-employees', 'ScheduleController@palS')->name('palS')->middleware('is_hr');
Route::get('updatesched/{employee_no}', 'ScheduleController@updatesched')->name('updatesched')->middleware('is_hr');

Route::post('ec-add-Schedule', 'ScheduleController@ecaddsched')->name('ecaddsched')->middleware('is_hr');
Route::get('/delete/addsched/{employee_no}/{date_sched}', 'ScheduleController@delsched')->name('delsched')->middleware('is_hr');
Route::get('/delete/schedule/{id}', 'ScheduleController@delete_schedule')->name('delete_schedule')->middleware('is_hr');
Route::post('/update/schedule/', 'ScheduleController@update_schedule')->name('update_schedule')->middleware('is_hr');

/*--------------------------------------------------------------
    # ATTENDANCE
--------------------------------------------------------------*/
Route::get('attendance-report-page', 'AttendanceController@attreport')->name('attreport')->middleware('is_hr');
Route::get('attendance-report-data', 'AttendanceController@attreportdata')->name('attreportdata')->middleware('is_hr');
Route::get('attendance-details/{employeeattendanceid}/{employee_no}', 'AttendanceController@attdetails')->name('attdetails')->middleware('is_hr');
Route::get('filterdetails/{id}/{employee_no}', 'AttendanceController@attdetailsdata')->name('attdetailsdata')->middleware('is_hr');
Route::get('attendance-list-page', 'HomeController@attlist')->name('attlist')->middleware('is_hr');
Route::get('attendance-data', 'AttendanceController@attlistdata')->name('attlistdata')->middleware('is_hr');
Route::get('attendance-data-collection', 'AttendanceController@attlistdatacollection')->name('attlistdatacollection')->middleware('is_hr');
Route::get('attendance', 'AttendanceController@attpostsnav')->name('attpostsnav')->middleware('is_hr');
Route::get('import-attendance', 'AttendanceController@importdatanav')->name('importdatanav')->middleware('is_hr');
Route::get('import-data', 'AttendanceController@importdata')->name('importdata')->middleware('is_hr');
Route::post('upload-attendance', 'AttendanceController@importA')->name('importA')->middleware('is_hr');
Route::get('fix-attendance', 'AttendanceController@fixedA')->name('fixedA')->middleware('is_hr');
Route::get('clear-attendance', 'AttendanceController@clearA')->name('clearA')->middleware('is_hr');
Route::post('post-attendance', 'AttendanceController@palA')->name('palA')->middleware('is_hr');
Route::get('autofix', 'AttendanceController@autofix')->name('autofix')->middleware('is_hr');

/*--------------------------------------------------------------
    # OVERTIME
--------------------------------------------------------------*/
Route::get('overtime-page', 'OvertimeController@overtimenav')->name('overtimenav')->middleware('is_hr');
Route::get('overtime-list', 'OvertimeController@overtimedata')->name('overtimedata')->middleware('is_hr');
Route::post('add-overtime', 'OvertimeController@addovertime')->name('addovertime')->middleware('is_hr');
Route::get('/delete/overtime/{id}/{employee_no}/{working_schedule}', 'OvertimeController@delete_overtime')->name('delete_overtime')->middleware('is_hr');
Route::post('/update/overtime/', 'OvertimeController@update_overtime')->name('update_overtime')->middleware('is_hr');

/* Route::post('get-id/{empName}', 'HomeController@getID')->name('getID')->middleware('is_hr'); */

/*--------------------------------------------------------------
    # CHANGE OFF
--------------------------------------------------------------*/
Route::get('changeoff-page', 'CSController@changeoffnav')->name('changeoffnav')->middleware('is_hr');
Route::get('/delete/changeoff/{id}/{date}', 'CSController@delete_changeoff')->name('delete_changeoff')->middleware('is_hr');
Route::post('/update/changeoff/', 'CSController@update_changeoff')->name('update_changeoff')->middleware('is_hr');
Route::get('/changeoff-page/{employee_no}','CSController@getEmp');
Route::get('changeoff-list', 'CSController@changeoffdata')->name('changeoffdata')->middleware('is_hr');
Route::post('add-schedule', 'CSController@addsched')->name('addsched')->middleware('is_hr');
Route::post('verify', 'CSController@addsched')->name('verify')->middleware('is_hr');

/*--------------------------------------------------------------
    # OFFSET - HRS
--------------------------------------------------------------*/
Route::get('offset-page', 'HomeController@offsetnav')->name('offsetnav')->middleware('is_hr');
Route::get('offset-list', 'HomeController@offsetdata')->name('offsetdata')->middleware('is_hr');
Route::post('add-offset', 'HomeController@addoffset')->name('addoffset')->middleware('is_hr');

/*--------------------------------------------------------------
    # OFFSET - DAYS
--------------------------------------------------------------*/
Route::get('offset2-page', 'HomeController@offset2nav')->name('offset2nav')->middleware('is_hr');
Route::get('offset2-list', 'HomeController@offdata')->name('offdata')->middleware('is_hr');
Route::post('add-offset2', 'HomeController@addoffset2')->name('addoffset2')->middleware('is_hr');

/*--------------------------------------------------------------
    # HOLIDAY
--------------------------------------------------------------*/
Route::get('holiday-page', 'HolidayController@holidaynav')->name('holidaynav')->middleware('is_hr');
Route::get('holiday-list', 'HolidayController@holidaydata')->name('holidaydata')->middleware('is_hr');
Route::post('add-holiday', 'HolidayController@addholiday')->name('addholiday')->middleware('is_hr');

/*--------------------------------------------------------------
    # SLVL
--------------------------------------------------------------*/
Route::get('slvl-page', 'SlvlController@slvlnav')->name('slvlnav')->middleware('is_hr');
Route::get('slvl-list', 'SlvlController@slvldata')->name('slvldata')->middleware('is_hr');
Route::post('add-slvl', 'SlvlController@addslvl')->name('addslvl')->middleware('is_hr');
Route::get('/delete/slvl/{id}/{employee_no}/{date_sched}', 'SlvlController@delete_slvl')->name('delete_slvl')->middleware('is_hr');
Route::post('/update/slvl/', 'SlvlController@update_slvl')->name('update_slvl')->middleware('is_hr');

/*--------------------------------------------------------------
    # DEDUCTIONS/BENEFITS
--------------------------------------------------------------*/
Route::get('deductions', 'HomeController@deductions')->name('deductions')->middleware('is_finance');
Route::get('benefits', 'HomeController@benefits')->name('benefits')->middleware('is_finance');
Route::get('F-Attendance', 'HomeController@Fattendance')->name('Fattendance')->middleware('is_finance');

/*--------------------------------------------------------------
    # PAYROLL
--------------------------------------------------------------*/
Route::get('payroll-list', 'HomeController@payrolllistnav')->name('payrolllistnav')->middleware('is_finance');
Route::get('payroll-list-data', 'HomeController@payrolllistdata')->name('payrolllistdata')->middleware('is_finance');
Route::get('view-payroll/{employee_no}', 'HomeController@viewpayroll')->name('viewpayroll')->middleware('is_finance');
Route::get('payslip/{employee_no}', 'HomeController@payslip')->name('payslip')->middleware('is_finance');
Route::get('send-payslip/{employee_no}', 'HomeController@sendpayslip')->name('sendpayslip')->middleware('is_finance');

/*--------------------------------------------------------------
    # TRAVEL ORDER
--------------------------------------------------------------*/
Route::get('travel-order-page', 'TravelOrderController@tonav')->name('tonav');
Route::get('/delete/travel_order/{id}/{employee_no}/{date_sched}', 'TravelOrderController@delete_travel_order')->name('delete_travel_order')->middleware('is_hr');
Route::post('/update/travel_order/', 'TravelOrderController@update_travel_order')->name('update_travel_order')->middleware('is_hr');
Route::get('travel-order-list', 'TravelOrderController@todata')->name('todata');
Route::post('add-travel-order', 'TravelOrderController@addto')->name('addto');  

/*--------------------------------------------------------------
    # RETRO
--------------------------------------------------------------*/
Route::get('retro-page', 'RetroController@retronav')->name('retronav');
Route::get('retro-list', 'RetroController@retrodata')->name('retrodata');
Route::post('add-addretro', 'RetroController@addretro')->name('addretro');

/*--------------------------------------------------------------
    # CHANGE TIME
--------------------------------------------------------------*/
Route::get('changetime-page', 'CTController@changetimenav')->name('changetimenav')->middleware('is_hr');
Route::get('/delete/changetime/{id}', 'CTController@delete_changetime')->name('delete_changetime')->middleware('is_hr');
Route::post('/update/changetime/', 'CTController@update_changetime')->name('update_changetime')->middleware('is_hr');
Route::get('changetime-list', 'CTController@changetimedata')->name('changetimedata')->middleware('is_hr');
Route::post('changetime', 'CTController@changetime')->name('changetime')->middleware('is_hr');

/*--------------------------------------------------------------
    # DASHBOARD
--------------------------------------------------------------*/
/* Route::get('', 'DBController@dbnav')->name('dashboardnav')->middleware('is_hr'); */
Route::get('', 'DBController@firststate')->name('firststate')->middleware('is_hr');

/*--------------------------------------------------------------
    # SUMMARY
--------------------------------------------------------------*/
Route::get('debit-list', 'PayrollController@debitsummarynav')->name('debitsummarynav')->middleware('is_finance');
Route::get('debit-data', 'PayrollController@debitsummarydata')->name('debitsummarydata')->middleware('is_finance');
Route::get('credit-list', 'PayrollController@creditsummarynav')->name('creditsummarynav')->middleware('is_finance');
Route::get('credit-data', 'PayrollController@creditsummarydata')->name('creditsummarydata')->middleware('is_finance');
Route::post('sentpayrollmaster', 'PayrollController@sentpayrollmaster')->name('sentpayrollmaster')->middleware('is_finance');

/*--------------------------------------------------------------
    # DEDUCTION LIST
--------------------------------------------------------------*/
Route::get('deduction-list', 'HomeController@deductionlists')->name('deductionlists')->middleware('is_finance');
Route::get('deduction-data', 'HomeController@deductiondata')->name('deductiondata')->middleware('is_finance');

/*--------------------------------------------------------------
    # CONTRIBUTION LIST
--------------------------------------------------------------*/
Route::get('contribution-list', 'HomeController@contributionlists')->name('contributionlists')->middleware('is_finance');
Route::get('contribution-data', 'HomeController@contributiondata')->name('contributiondata')->middleware('is_finance');

/*--------------------------------------------------------------
    # SACC PLUGIN
--------------------------------------------------------------*/
Route::get('SACC', 'HomeController@saccplugin')->name('saccplugin')->middleware('is_finance');

/*--------------------------------------------------------------
    # EDTR PLUGIN
--------------------------------------------------------------*/
Route::get('EDTR', 'HomeController@edtrplugin')->name('edtrplugin')->middleware('is_finance');


