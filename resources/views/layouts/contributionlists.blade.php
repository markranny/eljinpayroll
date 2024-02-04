

<!-- <div class="card">
        <div class="card-body">
            Employee's List
            <div class="float-right">
                <div class="row">
                <div class="col-2">
                        <a class="btn btn-success btn-sm" href="{{ route('empplugin') }}">Employee Details Plugin</a>
                    </div>
                </div>
            </div>
        </div>
    </div> -->

    <div class="card">
        <div class="card-body">
            <!-- <div class="material-datatables"> -->
                <!-- <table id="importatt" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%"> -->
                <table id="importatt" class="table table-striped table-no-bordered table-hover">
                    <thead>
                        <tr>
                        <th class="flex" style="width: 200px !important;">EMPNO</th>
                        <th class="flex" style="width: 200px !important;">EMPNAME</th>
                        <th class="flex" style="width: 200px !important;">SSSLOAN</th>
                        <th class="flex" style="width: 200px !important;">HDMFLOAN</th>
                        <th class="flex" style="width: 200px !important;">MLOAN</th>
                        <th class="flex" style="width: 200px !important;">SSSPREM</th>
                        <th class="flex" style="width: 200px !important;">HDMFPREM</th>
                        <th class="flex" style="width: 200px !important;">PHILHEALTH</th>
                        <th class="flex" style="width: 200px !important;">UNIONS</th>
                        <th class="flex" style="width: 200px !important;">MONTH</th>
                        <th class="flex" style="width: 200px !important;">YEAR</th>
                        <th class="flex" style="width: 200px !important;">PERIOD</th>
                        <!-- <th class="flex" style="width: 200px !important;">ACTIONS</th> -->
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

    ajax: "{{ route('contributiondata') }}",

    dom: 'Bfrtp',

    buttons: [ 'csv', 'excel', 'pdf', 'print' ],

    columns: [

            {data: 'employee_no', name: 'employee_no'},

            {data: 'employee_name', name: 'employee_name'},

            {data: 'sss_loan', name: 'sss_loan'},

            {data: 'pag_ibig_loan', name: 'pag_ibig_loan'},

            {data: 'mutual_loan', name: 'mutual_loan'},

            {data: 'sss_prem', name: 'sss_prem'},

            {data: 'pag_ibig_prem', name: 'pag_ibig_prem'},

            {data: 'philhealth', name: 'philhealth'},

            {data: 'unions', name: 'unions'},

            {data: 'month', name: 'month'},

            {data: 'year', name: 'year'},

            {data: 'period', name: 'period'},

    ]

    });
});

</script>



