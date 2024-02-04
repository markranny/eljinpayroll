

    <div class="card">
        <div class="card-body">
            For Checking
            <div class="float-right">
                <div class="row">
                <div class="col-2">
                        <a class="btn btn-success btn-sm" href="{{ route('attendancepostsplugin') }}">For Checking Attendance</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


     <div class="card">
        <div class="card-body">
            <div class="material-datatables">
                <table id="importatt" class="table table-striped table-no-bordered table-hover">
                    <thead>
                        <tr>
                        <th class="flex" style="width: 200px !important;">ACTION</th>
                        <th class="flex" style="width: 200px !important;">ID</th>
                        <th class="flex" style="width: 200px !important;">ATTENDANCEID</th>
                        <th class="flex" style="width: 200px !important;">EMPLOYEE_NO</th>
                        <th class="flex" style="width: 200px !important;">EMPLOYEE_NAME</th>
                        <!-- <th class="flex" style="width: 200px !important;">PAYRATE</th>
                        <th class="flex" style="width: 200px !important;">DAYS</th>
                        <th class="flex" style="width: 200px !important;">WORKING_HRS</th>
                        <th class="flex" style="width: 200px !important;">BASIC_PAY</th>
                        <th class="flex" style="width: 200px !important;">MINS_LATE</th>
                        <th class="flex" style="width: 200px !important;">LATE_AMOUNT</th>
                        <th class="flex" style="width: 200px !important;">UDT_HRS</th>
                        <th class="flex" style="width: 200px !important;">UDT_AMOUNT</th>
                        <th class="flex" style="width: 200px !important;">NIGHTDIF</th>
                        <th class="flex" style="width: 200px !important;">NIGHTDIF_AMOUNT</th>
                        <th class="flex" style="width: 200px !important;">HOLIDAY_AMOUNT</th>
                        <th class="flex" style="width: 200px !important;">SLVL_AMOUNT</th>
                        <th class="flex" style="width: 200px !important;">ABSENT</th>
                        <th class="flex" style="width: 200px !important;">OFFDAYS</th>
                        <th class="flex" style="width: 200px !important;">OT_HRS</th>
                        <th class="flex" style="width: 200px !important;">OT_AMOUNT</th>
                        <th class="flex" style="width: 200px !important;">OFFSET_HRS</th>
                        <th class="flex" style="width: 200px !important;">OFFSET_AMOUNT</th> -->
                        <th class="flex" style="width: 200px !important;">MONTH</th>
                        <th class="flex" style="width: 200px !important;">PERIOD</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

        </div>
    </div>
</div>
        




<script type="text/javascript">

  $(function () {
      /*------------------------------------------
     --------------------------------------------
     Pass Header Token
     --------------------------------------------
     --------------------------------------------*/ 
     $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });

    var table = $('#importatt').DataTable({

    processing: true,

    serverSide: true,

    scrollCollapse: true,

    scrollY: true,

    scrollX: true,

    /* dom: 'Bfrtp',

    buttons: [ 'csv', 'excel', 'pdf', 'print' ], */

    dom: 'Bfrtip',
    buttons: [
    {
      extend: 'excel',
      exportOptions: {
        columns: [ 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23]
      },
    },
    {
      extend: 'csv',
      exportOptions: {
        page: 'all',
        columns: [ 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20, 21, 22, 23]
      },
    },
  ],

    ajax: "{{ route('attreportdata') }}",

    columns: [

                {data: 'action', name: 'action', orderable: false, searchable: false},

                {data: 'id', name: 'id'}

                {data: 'employeeattendanceid', name: 'employeeattendanceid'},

                {data: 'employee_no', name: 'employee_no'},

                {data: 'employee_name', name: 'employee_name'},

                /* {data: 'pay_rate', name: 'pay_rate'},

                {data: 'days', name: 'days'},

                {data: 'working_hours', name: 'working_hours'},

                {data: 'basic_pay', name: 'basic_pay'},

                {data: 'minutes_late', name: 'minutes_late'},

                {data: 'late_amount', name: 'late_amount'},

                {data: 'udt_hrs', name: 'udt_hrs'},

                {data: 'udt_amount', name: 'udt_amount'},

                {data: 'nightdif', name: 'nightdif'},

                {data: 'nightdif_amount', name: 'nightdif_amount'},

                {data: 'holiday_amount', name: 'holiday_amount'},

                {data: 'slvl_amount', name: 'slvl_amount'},

                {data: 'absent', name: 'absent'},

                {data: 'offdays', name: 'offdays'},

                {data: 'ot_hrs', name: 'ot_hrs'},

                {data: 'ot_amount', name: 'ot_amount'},

                {data: 'offset_hrs', name: 'offset_hrs'},

                {data: 'offset_amount', name: 'offset_amount'}, */

                {data: 'month', name: 'month'},

                {data: 'period', name: 'period'},


    ]

    });
});

</script>



