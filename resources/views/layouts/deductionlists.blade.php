

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
                        <th class="flex" style="width: 200px !important;">ADVANCE</th>
                        <th class="flex" style="width: 200px !important;">CHARGE</th>
                        <th class="flex" style="width: 200px !important;">MEAL</th>
                        <th class="flex" style="width: 200px !important;">MISC</th>
                        <th class="flex" style="width: 200px !important;">UNIFORM.</th>
                        <th class="flex" style="width: 200px !important;">BONDDEPO</th>
                        <th class="flex" style="width: 200px !important;">MCHARGE</th>
                        <th class="flex" style="width: 200px !important;">MONTH</th>
                        <th class="flex" style="width: 200px !important;">YEAR</th>
                        <th class="flex" style="width: 200px !important;">PERIOD</th>
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

    ajax: "{{ route('deductiondata') }}",

    dom: 'Bfrtp',

    buttons: [ 'csv', 'excel', 'pdf', 'print' ],

    columns: [

            {data: 'employee_no', name: 'employee_no'},

            {data: 'employee_name', name: 'employee_name'},

            {data: 'advance', name: 'advance'},

            {data: 'charge', name: 'charge'},

            {data: 'meal', name: 'meal'},

            {data: 'misc', name: 'misc'},

            {data: 'uniform', name: 'uniform'},

            {data: 'bond_deposit', name: 'bond_deposit'},

            {data: 'mutual_charge', name: 'mutual_charge'},

            {data: 'month', name: 'month'},

            {data: 'year', name: 'year'},

            {data: 'period', name: 'period'},

    ]

    });
});

</script>



