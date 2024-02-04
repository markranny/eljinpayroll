

<div class="card">
        <div class="card-body">
            OFFSET (WHOLE DAY)
            <div class="float-right">
                <div class="row">
                <div class="col-2">
                        <!-- <a class="btn btn-success btn-sm" href="{{ route('attendancepostsplugin') }}">Add</a> -->

                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal">ADD OFFSET</button>

                    </div>
                </div>
            </div>
        </div>
    </div>


     <div class="card">
        <div class="card-body">
            <div class="material-datatables">
                <table id="off" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                    <thead>
                        <tr>
                        <th>ID</th>
                        <th>Employee_No</th>
                        <th>Employee_Name</th>
                        <th>Working_Schedule</th>
                        <th>Inclusive_Date</th>
                        <th>Purpose</th>
                        <th>Month</th>
                        <th>Year</th>
                        <th>Period</th>
                        <!-- <th>Action</th> -->
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

        </div>
    </div>
</div>
        

<!-- Bootstrap Basic Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title">OFFSET</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>


			<div class="modal-body">
                <form method="POST" action="{{ route('addoffset2') }}" enctype="multipart/form-data" >
                @csrf  

                <div class="row">

                <div class="col-6">
                <div class="form-group">
                <!-- <select class="selectpicker" name="employee_no" data-style="select-with-transition" multiple title="Choose Employee"> -->
                <select class="selectpicker" name="employee_no" id="employee_no" data-style="select-with-transition" title="EmployeeNo" data-size="7">
                    <option disabled>SELECT EMPLOYEENO</option>
                        @foreach ($employees as $data)
                            <option value="{{$data->employee_no}}" > {{$data->lastname}} {{$data->firstname}} - {{$data->employee_no}}</option>
                        @endforeach
                </select>
                </div>
            </div><br><br>

            <div class="col-6">
            <div class="form-group">
                <select class="selectpicker" name="employee_name" id="employee_name" data-style="select-with-transition" title="EmployeeName" data-size="7">
                    <option disabled>BW EMPLOYEES</option>
                        @foreach ($employees as $data)
                            <option value="{{$data->lastname}} {{$data->firstname}}" >{{$data->lastname}} {{$data->firstname}}</option>
                        @endforeach
                </select>
            </div>
            </div><br><br>

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
                    <label>Working Schedule</label><br>
                    <input type="text" name="worksched" class="form-control datepicker" placeholder="Select Date"><br>
                </div>
            </div>
                
            <div class="col-6">
                <div class="form-group">
                    <label>Inclusive DATE</label><br>
                    <input type="text" name="datesched" class="form-control datepicker" placeholder="Select Date"><br>
                </div>
            </div>

            <div class="col-12">
                <div class="form-group">
                <label>REMARKS</label><br>
                <textarea class="form-control textarea-autosize" name="remarks" id="textareaExample" rows="4" placeholder="REMARKS"></textarea>
                </div>
                </div></div>

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

    var table = $('#off').DataTable({

    processing: true,

    serverSide: true,

    dom: 'Bfrtp',

    buttons: [ 'csv', 'excel', 'pdf', 'print' ],

    ajax: "{{ route('offdata') }}",

    columns: [
            {data: 'id', name: 'id'},

            {data: 'employee_no', name: 'employee_no'},

            {data: 'firstname', name: 'firstname'},

            {data: 'working_sched', name: 'working_sched'},

            {data: 'date_sched', name: 'date_sched'},

            {data: 'remarks', name: 'remarks'},

            {data: 'month', name: 'month'},

            {data: 'year', name: 'year'},

            {data: 'period', name: 'period'}

            /* {data: 'action', name: 'action', orderable: false, searchable: false}, */

    ]

    });
});

</script>



