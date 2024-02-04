

    <div class="card">
        <div class="card-body">
            OFFSET
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
                <table id="offset" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                    <thead>
                        <tr>
                        <th>ID</th>
                        <th>Employee_No</th>
                        <th>Employee_Name</th>
                        <th>Working_Schedule</th>
                        <th>Date</th>
                        <th>Offset(IN)</th>
                        <th>Offset(OUT)</th>
                        <th>Month</th>
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
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title" style="font-weight: bold">ADD OFFSET</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>


			<div class="modal-body">
                <form method="POST" action="{{ route('addoffset') }}" enctype="multipart/form-data" target="_blank">
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
                    <input type="text" name="workingsched" class="form-control datepicker" placeholder="Select Working Schedule"><br>
                </div>
                </div>

                <div class="col-6">
                <div class="form-group">
                    <input type="text" name="datesched" class="form-control datepicker" placeholder="Select OFFSET Date"><br>
                </div>
                </div>

                <div class="col-6">
                <div class="form-group">
                    <input type="text" name="offsetin" id="datetimepicker1" class="form-control datepicker" placeholder="INSERT OFFSET (IN)"><br>
                </div>
                </div>

                <div class="col-6">
                <div class="form-group">
                    <input type="text" name="offsetout" id="datetimepicker2" class="form-control datepicker" placeholder="INSERT OFFSET (OUT)">
                </div>
                </div>

                <div class="col-12">
                <div class="form-group">
                <textarea class="form-control textarea-autosize" name="remarks" id="textareaExample" rows="4" placeholder="Remarks"></textarea>
                </div>
                </div>
                </div>
                </div>

                <!-- <div class="row">
                    <div class = "col-6">
                    <div class="form-group">
                        <select class="selectpicker" data-style="select-with-transition" multiple title="Choose Month">
                            <option disabled>This Field is Required!</option>
                            <option value="January">January</option>
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
                    </div></div>
                
                    <div class = "col-6">
                        <div class="form-group">
                            <select class="selectpicker" data-style="select-with-transition" multiple title="Choose Period">
                                <option disabled>This Field is Required!</option>
                                <option value="1st Period">1st Period</option>
                                <option value="2nd Period">2nd Period</option>
                            </select>
                        </div>
                    </div>
                </div> -->

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

    var table = $('#offset').DataTable({

    processing: true,

    serverSide: true,

    dom: 'Bfrtp',

    buttons: [ 'csv', 'excel', 'pdf', 'print' ],

    ajax: "{{ route('offsetdata') }}",

    columns: [
            {data: 'id', name: 'id'},

            {data: 'employee_no', name: 'employee_no'},

            {data: 'firstname', name: 'firstname'},

            {data: 'date_sched', name: 'date_sched'},

            {data: 'working_schedule', name: 'working_schedule'},

            {data: 'osphs_in', name: 'osphs_in'},

            {data: 'osphs_out', name: 'osphs_out'},
            
            {data: 'month', name: 'month'},

            {data: 'period', name: 'period'}
            /* {data: 'action', name: 'action', orderable: false, searchable: false}, */

    ]

    });
});

</script>



