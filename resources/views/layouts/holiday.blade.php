<div class="LayoutTable">
    <div class="card table-header">
        <div class="card-body">
            <div class="float-right">
                <div class="row">
                    <div class="col-2">
                        <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#exampleModal">Set Holiday</button>
                    </div>
                </div>
            </div>
        </div>
    </div>    
</div>
        
    <div class="card">
        <div class="card-body">
            <div class="material-datatables">
                <table id="holiday" class="table table-striped table-no-bordered table-hover">
                    <thead>
                        <tr>
                        <th>HolidayID</th>
                        <th>Holiday_Type</th>
                        <th>Date</th>
                        <!-- <th>Action</th> -->
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

<!-- Bootstrap Basic Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content modal-lg">
			<div class="modal-header">
				<h3 class="modal-title">Add Holiday</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>


			<div class="modal-body">
                <form method="POST" action="{{ route('addholiday') }}" enctype="multipart/form-data" >
                @csrf  

                <div class="row">

                <!-- <div class="col-6">
                <div class="form-group">
                <select class="selectpicker" name="employee_no" id="employee_no" data-style="select-with-transition" title="EmployeeNo" data-size="7">
                    <option disabled>SELECT EMPLOYEENO</option>
                        @foreach ($employees as $data)
                            <option value="{{$data->employee_no}}" > {{$data->lastname}} {{$data->firstname}} - {{$data->employee_no}}</option>
                        @endforeach
                </select>
                </div>
                </div><br><br> -->

            <!-- <div class="col-6">
            <div class="form-group">
                <select class="selectpicker" name="employee_name" id="employee_name" data-style="select-with-transition" title="EmployeeName" data-size="7">
                    <option disabled>BW EMPLOYEES</option>
                        @foreach ($employees as $data)
                            <option value="{{$data->lastname}} {{$data->firstname}}" >{{$data->lastname}} {{$data->firstname}}</option>
                        @endforeach
                </select>
            </div>
            </div><br><br> -->

            <!-- <div class="col-5">
                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal2" style="float: right !important;">GET EMPLOYEENO</button>
            </div> -->
                <div class="col-12">
                <div class="form-group">
                    <!-- <label>EMPLOYEE ATTENDANCE ID</label><br> -->
                    @foreach ($empposts as $empposts)
                    <input type="text" name="employeeattendanceid" class="form-control" placeholder="Input Employeeattendanceid" max="10" value="{{ $empposts->employeeattendanceid }}"><br>
                    @endforeach
                </div>
                </div>

                <div class="col-6">
                <div class="form-group">
                    <input type="text" name="datesched" class="form-control datepicker" placeholder="Select Date">
                </div>
                </div>

                <div class="col-6">
                <div class="form-group">
                <select class="selectpicker" name="holidaytype" data-style="select-with-transition" >
                    <option disabled>HOLIDAY TYPE</option>
                            <option value="Regular Holiday" >Regular Holiday</option>
                            <option value="Legal Holiday" >Legal Holiday</option>
                            <option value="Special Working Holiday" >Special Working Holiday</option>
                            <option value="Special Non-Working Holiday" >Special Non-Working Holiday</option>
                </select>
                </div>
                </div>

            </div>

                <button type="submit" class="btn btn-primary">
                                    {{ __('SUBMIT') }}
                                </button>
                                {{ csrf_field() }}
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                </form>
			</div>


			    <div class="modal-footer">
                    
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

    var table = $('#holiday').DataTable({

    processing: true,

    serverSide: true,

    dom: 'lBfrtp',

    buttons: [ 'csv', 'excel', 'pdf', 'print' ],

    ajax: "{{ route('holidaydata') }}",

    columns: [

            {data: 'employeeattendanceid', name: 'employeeattendanceid'},

            {data: 'type', name: 'type'},

            {data: 'date_sched', name: 'date_sched'},

            /* {data: 'action', name: 'action', orderable: false, searchable: false}, */

    ]

    });
});

</script>



