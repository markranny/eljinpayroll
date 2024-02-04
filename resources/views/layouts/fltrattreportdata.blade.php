

<div class="card">
    <div class="card-body">
        Employee's Attendance
        <form id="fltrattreportnav" action="{{ route('fltrattreportnav') }}" method="POST">
        {{csrf_field()}} 
        <div class="float-right">

            <div class="row">
                
                    <div class="col-md-3">
                        <select class="selectpicker" name="name" data-style="select-with-transition" multiple title="Choose Employee" data-size="7">
                            <option disabled> This Field is require!</option>
                                @foreach ($employees as $data)
                                <option value="{{$data->id}}" >{{$data->firstname}} {{$data->lastname}}</option>
                                @endforeach
                        </select>
                    </div>
            
                    <div class="col-md-3">
                        <select class="selectpicker" name="month" data-style="select-with-transition" multiple title="Choose Month" data-size="7">
                            <option disabled> This Field is require!</option>
                            <option value="January">January </option>
                            <option value="February">February</option>
                            <option value="March">March</option>
                            <option value="April">April</option>
                            <option value="May">May</option>
                            <option value="June">June</option>
                            <option value="July">July</option>
                            <option value="August">August</option>
                            <option value="September">September</option>
                            <option value="October">October</option>
                            <option value="November">November</option>
                            <option value="December">December</option>
                        </select>
                    </div>

                    <div class="col-3">
                        <select class="selectpicker" name="period" data-style="select-with-transition" multiple title="Choose Period" data-size="7">
                            <option disabled> This Field is require!</option>
                            <option value="1st Period">1st Period</option>
                            <option value="2nd Period">2nd Period</option>
                        </select>
                    </div>

                    <div class="col-2">
                        <a class="btn btn-success btn-sm" href="{{ route('fltrattreportnav') }}" onclick="event.preventDefault(); document.getElementById('fltrattreportnav').submit();">Submit</a>
                    </div>
                
              </div>
            </div>
            </form>

     <div class="card">
        <div class="card-body">
            <div class="material-datatables">
                <table id="importatt" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                    <thead>
                        <tr>
                        <th>ID</th>
                        <th>AttendanceID</th>
                        <th>Employee_No</th>
                        <th>Employee_Name</th>
                        <th>Days</th>
                        <th>Working_Hours</th>
                        <th>Total_Late_Hours.</th>
                        <th>Total_Late_minutes</th>
                        <th>Month</th>
                        <th>Period</th>
                        <th>Action</th>
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

    /* dom: 'Bfrtp',

    buttons: [ 'csv', 'excel', 'pdf', 'print' ], */

    ajax: "{{ route('fltrattreportdata') }}",

    columns: [

            {data: 'id', name: 'id'},

            {data: 'employeeattendanceid', name: 'employeeattendanceid'},

            {data: 'employee_no', name: 'employee_no'},

            {data: 'employee_name', name: 'employee_name'},

            {data: 'days', name: 'days'},

            {data: 'working_hours', name: 'working_hours'},

            {data: 'total_late_hours', name: 'total_late_hours'},

            {data: 'total_late_minutes', name: 'total_late_minutes'},

            {data: 'month', name: 'month'},

            {data: 'period', name: 'period'},

            {data: 'action', name: 'action', orderable: false, searchable: false},

    ]

    });
});

</script>



