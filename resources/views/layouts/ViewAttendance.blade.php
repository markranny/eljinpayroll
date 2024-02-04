

<div class="card">
    <div class="card-body">
        Attendance List
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
                        <th>IN</th>
                        <th>OUT</th>
                        <th>Import_Hours</th>
                        <th>Working_Hours</th>
                        <th>Hrs_Late</th>
                        <th>Min_Late</th>
                        <th>Halfday</th>
                        <th>Undertime</th>
                        <th>Absent</th>
                        <th>NightDif</th>
                        </tr>
                    </thead>
                </table>
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

    ajax: "{{ route('attlistdatacollection') }}",

    columns: [

            {data: 'employee_no', name: 'employee_no'},

            {data: 'employee_name', name: 'employee_name'},

            {data: 'date_sched', name: 'date_sched'},

            {data: 'day', name: 'day'},

            {data: 'in1', name: 'in1'},

            {data: 'out2', name: 'out2'},

            {data: 'hours_work', name: 'hours_work'},

            {data: 'working_hour', name: 'working_hour'},

            {data: 'late_hr', name: 'late_hr'},

            {data: 'late_min', name: 'late_min'}, 

            {data: 'halfday', name: 'halfday'},

            {data: 'undertimer', name: 'undertimer'},

            {data: 'absent', name: 'absent'},

            {data: 'night_dif', name: 'night_dif'},

    ]

    });
});

</script>

