<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title" style="font-weight: bold">ADD SCHEDULE</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>


			<div class="modal-body">
                <form method="POST" action="{{ route('ecaddsched') }}" enctype="multipart/form-data" >
                @csrf  

                <div class="row">

            <div class="col-12">
                <div class="form-group">
                <select class="selectpicker" data-live-search="true" name="employee_name" id="employee_name" data-style="select-with-transition" title="EmployeeName" data-size="7">
                    <option disabled>BW EMPLOYEES</option>
                        @foreach ($employees as $data)
                            <option value="{{$data->lastname}} {{$data->firstname}}" >{{$data->lastname}} {{$data->firstname}}</option>
                        @endforeach
                </select>
                </div>
            </div><br><br>

            <div class="col-6">
                <div class="form-group">
                    <!-- <label>EMPLOYEE ATTENDANCE ID</label><br> -->
                    @foreach ($empposts as $empposts)
                    <input type="text" name="employeeattendanceid" class="form-control" placeholder="Input Employeeattendanceid" max="10" value="{{ $empposts->employeeattendanceid }}" readonly><br>
                    @endforeach
                </div>
                </div>

                <div class="col-6">
                <div class="form-group">
                    <input type="text" name="datesched" class="form-control datepicker" placeholder="Select Date"><br>
                </div>
                </div>

                <div class="col-6">
                <div class="form-group">
                    <input type="text" name="timein" id="datetimepicker1" class="form-control datepicker" placeholder="TIME IN"><br>
                </div>
                </div>

                <div class="col-6">
                <div class="form-group">
                    <input type="text" name="timeout" id="datetimepicker2" class="form-control datepicker" placeholder="TIME OUT">
                </div>
                </div>
    
                <div class="col-12">
                <div class="form-group">
                <textarea class="form-control textarea-autosize" name="remarks" id="textareaExample" rows="4" placeholder="Remarks"></textarea>
                </div>
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