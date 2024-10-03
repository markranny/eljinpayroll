

   <!--  <div class="card table-header">
        <div class="card-body">
            ATTENDANCE
            <div class="float-right">
                <div class="row">
                <div class="col-2">
                        <a class="btn btn-primary btn-sm" href="{{ route('Fattendance') }}">Attendance POST Plugin</a>
                    </div>
                </div>
            </div>
        </div>
    </div> -->


     <div class="card">
        <div class="card-body">
            <div class="material-datatables">
                <!-- <table id="importatt" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%"> -->
                <table id="attendance" class="table table-striped table-no-bordered table-hover">
                    <thead>
                        <tr>
                        <th class="flex" style="width: 100px !important;">ACTION</th>
                        <th class="flex" style="width: 100px !important;">ID</th>
                        <th class="flex" style="width: 150px !important;">ATTENDANCEID</th>
                        <th class="flex" style="width: 150px !important;">EMPLOYEE_NO</th>
                        <th class="flex" style="width: 150px !important;">EMPLOYEE_NAME</th>
                        <th class="flex" style="width: 150px !important;">REGULAR_DAYS</th>
                        <th class="flex" style="width: 150px !important;">EARNED_DAYS</th>
                        <th class="flex" style="width: 150px !important;">WORKING_HRS</th>
                        <th class="flex" style="width: 150px !important;">ABSENT</th>
                        <th class="flex" style="width: 150px !important;">CTLATE</th>
                        <th class="flex" style="width: 150px !important;">MINS_LATE</th>
                        <th class="flex" style="width: 150px !important;">UDT_HRS</th>
                        <th class="flex" style="width: 150px !important;">NIGHTDIF</th>
                        <th class="flex" style="width: 150px !important;">HOLIDAY</th>
                        <th class="flex" style="width: 150px !important;">HOLIDAY_PERCENT</th>
                        <th class="flex" style="width: 150px !important;">OFFDAYS</th>
                        <th class="flex" style="width: 150px !important;">OVERTIME</th>
                        <th class="flex" style="width: 150px !important;">OB</th>
                        <th class="flex" style="width: 150px !important;">SLVL</th>
                        <th class="flex" style="width: 150px !important;">MONTH</th>
                        <th class="flex" style="width: 150px !important;">YEAR</th>
                        <th class="flex" style="width: 150px !important;">PERIOD</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="{{asset('js/functions/attendance.js')}}">
    </script>



