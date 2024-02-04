<div class="LayoutTable">

<div class="card table-header">
    <div class="card-body">
        <!-- Attendance List -->
        <div class="float-right">

            <div class="row">
                <div class="col-4">
                <form id="importA-form" action="{{ route('importA') }}" method="POST">
                @csrf
                    <input type="file" class="form-control" name="file" id="file" />
                </form>
                </div>

                <div class="col-2">
                    <a class="btn btn-primary btn-sm" href="{{ route('importA') }}" onclick="event.preventDefault(); document.getElementById('importA-form').submit();">Import</a>
                </div>
                
                <div class="col-1">
                    <a class="btn btn-warning btn-sm" href="{{ route('fixedA') }}">Fixed</a>
                </div>

                <div class="col-1">
                    <a class="btn btn-danger btn-sm" href="{{ route('clearA') }}">Clear</a>
                </div>
                <div class="col-2">
                    <a class="btn btn-info btn-sm" href="{{ route('palA') }}">Post All Lines</a>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
        <div class="card-body">
            <div class="material-datatables">
                <table id="attlistdata" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                    <thead>
                        <tr>
                        <th>Employee_No</th>
                        <th>Employee_Name</th>
                        <th>Date</th>
                        <th>Day</th>
                        <th>IN1</th>
                        <th>OUT1</th>
                        <th>IN2</th>
                        <th>OUT2</th>
                        <th>Working_Hours</th>
                        <th>Roundoff_Hours</th>
                        <th>Late</th>
                        <th>Halfday</th>
                        <th>Undertime</th>
                        </tr>
                    </thead>
                </table>
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

    var table = $('#attlistdata').DataTable({

    processing: true,

    serverSide: true,

    /* dom: 'Bfrtp',

    buttons: [ 'csv', 'excel', 'pdf', 'print' ], */

    ajax: "{{ route('attlistdata') }}",

    columns: [

            {data: 'emp.employee_no', name: 'emp.employee_no'},

            {data: 'sched.employee_name', name: 'sched.employee_name'},

            {data: 'emp.date', name: 'emp.date'},

            {data: 'emp.day', name: 'emp.day'},

            {data: 'emp.in1', name: 'emp.in1'},

            {data: 'emp.out1', name: 'emp.out1'},

            {data: 'emp.in2', name: 'emp.in2'},

            {data: 'emp.out2', name: 'emp.out2'},

            {data: 'emp.hours_work', name: 'emp.hours_work'},

            {data: 'emp.roundoff_hours', name: 'emp.roundoff_hours'},

            {data: 'emp.late', name: 'emp.late'},

            {data: 'emp.halfday', name: 'emp.halfday'}, 

            {data: 'emp.undertime', name: 'emp.undertime'},

    ]

    });
});

</script>

