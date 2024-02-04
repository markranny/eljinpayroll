

<div class="card">
        <div class="card-body">
            Payroll List
            <div class="float-right">
                <div class="row">
                    <div class="col-2">
                        <a class="btn btn-success btn-sm" href="{{ route('edtrplugin') }}">PAYROLL PLUGIN</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

     <div class="card">
        <div class="card-body">
            <!-- <div class="material-datatables"> -->
                <table id="importatt" class="table table-striped table-no-bordered table-hover">
                    <thead>
                        <tr>
                        <th style="width: 200px !important;">ACTIONS</th>
                        <th style="width: 200px !important;">ID</th>
                        <th style="width: 200px !important;">Employee_No</th>
                        <th style="width: 200px !important;">Employee_Name</th>
                        <th style="width: 200px !important;">Department</th>
                        <th style="width: 200px !important;">Job_Status</th>
                        <th style="width: 200px !important;">Job_Title</th>
                        <th style="width: 200px !important;">Taxable</th>
                        <th style="width: 200px !important;">Pay_Rate</th>
                        <th style="width: 200px !important;">Days</th>
                        <th style="width: 200px !important;">Working_hrs</th>
                        <th style="width: 200px !important;">Basic_Pay</th>
                        <th style="width: 200px !important;">Minutes_Late</th>
                        <th style="width: 200px !important;">Late_Amount</th>
                        <th style="width: 200px !important;">UDT_Hrs</th>
                        <th style="width: 200px !important;">UDT_Amount</th>
                        <th style="width: 200px !important;">Nightdif</th>
                        <th style="width: 200px !important;">Nightdif_Amount</th>
                        <th style="width: 200px !important;">Holiday_Amount</th>
                        <th style="width: 200px !important;">SLVL_Amount</th>
                        <th style="width: 200px !important;">Offdays</th>
                        <th style="width: 200px !important;">Offdays_Amount</th>
                        <th style="width: 200px !important;">OT_Hrs</th>
                        <th style="width: 200px !important;">OT_Amount</th>
                        <th style="width: 200px !important;">Offset_Hrs</th>
                        <th style="width: 200px !important;">Offset_Amount</th>
                        
                        <th style="width: 200px !important;">sss_loan</th>
                        <th style="width: 200px !important;">pag_ibig_loan</th>
                        <th style="width: 200px !important;">mutual_loan</th>
                        <th style="width: 200px !important;">sss_prem</th>
                        <th style="width: 200px !important;">pag_ibig_prem</th>
                        <th style="width: 200px !important;">philhealth</th>
                        <th style="width: 200px !important;">advance</th>
                        <th style="width: 200px !important;">charge</th>
                        <th style="width: 200px !important;">canteen</th>
                        <th style="width: 200px !important;">misc</th>
                        <th style="width: 200px !important;">uniform</th>
                        <th style="width: 200px !important;">bond_deposit</th>
                        <th style="width: 200px !important;">mutual_charge</th>
                        <th style="width: 200px !important;">Gross/Income</th>
                        <th style="width: 200px !important;">month</th>
                        <th style="width: 200px !important;">period</th>
                        </tr>
                    </thead>
                </table>
            <!-- </div> -->
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

    lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],

    processing: true,

    serverSide: true,

    paging: false,

    scrollCollapse: true,

    scrollY: true,

    scrollX: true,

    

    ajax: "{{ route('payrolllistdata') }}",

    columns: [

        {data: 'action', name: 'action', orderable: false, searchable: false},

        {data: 'employeeattendanceid', name: 'employeeattendanceid'},

        {data: 'employee_no', name: 'employee_no'},

        {data: 'employee_name', name: 'employee_name'},

        {data: 'department', name: 'department'},

        {data: 'job_status', name: 'job_status'},

        {data: 'job_title', name: 'job_title'},

        {data: 'taxable', name: 'taxable'},

        {data: 'pay_rate', name: 'pay_rate'},

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

        {data: 'offdays', name: 'offdays'},

        {data: 'offdays_amount', name: 'offdays_amount'},

        {data: 'ot_hrs', name: 'ot_hrs'},

        {data: 'ot_amount', name: 'ot_amount'},

        {data: 'offset_hrs', name: 'offset_hrs'},

        {data: 'offset_amount', name: 'offset_amount'},


        {data: 'sss_loan', name: 'sss_loan'},

        {data: 'pag_ibig_loan', name: 'pag_ibig_loan'},

        {data: 'mutual_loan', name: 'mutual_loan'},

        {data: 'sss_prem', name: 'sss_prem'},

        {data: 'pag_ibig_prem', name: 'pag_ibig_prem'},

        {data: 'philhealth', name: 'philhealth'},

        {data: 'advance', name: 'advance'},

        {data: 'charge', name: 'charge'},

        {data: 'meal', name: 'meal'},

        {data: 'misc', name: 'misc'},

        {data: 'uniform', name: 'uniform'},

        {data: 'bond_deposit', name: 'bond_deposit'},

        {data: 'mutual_charge', name: 'mutual_charge'},

        {data: 'gross', name: 'gross'},

        {data: 'month', name: 'month'},

        {data: 'period', name: 'period'}

    ]

    });
});

</script>



