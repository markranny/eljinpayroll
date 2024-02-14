

    <div class="card table-header">
        <div class="card-body">
            <!-- ATTENDANCE -->
            <div class="float-right">
                <div class="row">
                <div class="col-2">
                        <a class="btn btn-primary btn-sm" href="{{ route('Fattendance') }}">Attendance POST Plugin</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


     <div class="card">
        <div class="card-body">
            <div class="material-datatables">
                <!-- <table id="importatt" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%"> -->
                <table id="attendance" class="table table-striped table-no-bordered table-hover">
                    <thead>
                        <tr>
                        <th class="flex" style="width: 200px !important;">ACTION</th>
                        <th class="flex" style="width: 200px !important;">ID</th>
                        <th class="flex" style="width: 200px !important;">ATTENDANCEID</th>
                        <th class="flex" style="width: 200px !important;">EMPLOYEE_NO</th>
                        <th class="flex" style="width: 200px !important;">EMPLOYEE_NAME</th>
                        <th class="flex" style="width: 200px !important;">NO_OF_DAYS</th>
                        <th class="flex" style="width: 200px !important;">WORKING_HRS</th>
                        <th class="flex" style="width: 200px !important;">ABSENT</th>
                        <th class="flex" style="width: 200px !important;">MINS_LATE</th>
                        <th class="flex" style="width: 200px !important;">UDT_HRS</th>
                        <th class="flex" style="width: 200px !important;">NIGHTDIF</th>
                        <th class="flex" style="width: 200px !important;">HOLIDAY</th>
                        <th class="flex" style="width: 200px !important;">HOLIDAY_PERCENT</th>
                        <th class="flex" style="width: 200px !important;">OFFDAYS</th>
                        <th class="flex" style="width: 200px !important;">OVERTIME</th>
                        <th class="flex" style="width: 200px !important;">OFFSET</th>
                        <th class="flex" style="width: 200px !important;">OB</th>
                        <th class="flex" style="width: 200px !important;">SLVL</th>
                        <th class="flex" style="width: 200px !important;">MONTH</th>
                        <th class="flex" style="width: 200px !important;">YEAR</th>
                        <th class="flex" style="width: 200px !important;">PERIOD</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="{{asset('js/functions/attendance.js')}}">
    </script>



