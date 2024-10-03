<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title">SELECT DATE</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>


			<div class="modal-body">
                <form method="POST" action="{{ route('palA') }}" enctype="multipart/form-data" >
                @csrf

                <div class="form-group">
                    <label>DATE (from)</label><br>
                    <input type="text" name="fromdate" id="fromdate" class="form-control datepicker" placeholder="Select Date"><br>
                </div>

                <div class="form-group">
                    <label>DATE (to)</label><br>
                    <input type="text" name="todate" id="todate" class="form-control datepicker" placeholder="Select Date"><br>
                </div>
			</div>

                <button type="submit" class="btn btn-primary">
                                    {{ __('SUBMIT') }}
                                </button>
                                {{ csrf_field() }}
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                </form>


			    <div class="modal-footer">
                    
			</div>
		</div>
	</div>
</div>









<div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title">Add Manually</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>


			<div class="modal-body">
                <form method="POST" action="{{ route('Amanual') }}" enctype="multipart/form-data" >
                @csrf

                <div class="form-group">
                <select class="selectpicker" data-live-search="true" name="employee_name" id="employee_name" data-style="select-with-transition" title="EmployeeName" data-size="7">
                    <option disabled>BW EMPLOYEES</option>
                        @foreach ($employees as $data)
                            <option value="{{$data->employee_no}}" >{{$data->lastname}} {{$data->firstname}}</option>
                        @endforeach
                </select>
                </div></br>

                <div class="form-group">
                    <input type="text" name="datesched" class="form-control datepicker" placeholder="Select Date"><br>
                </div>

                <div class="form-group">
                    <label>Time In</label><br>
                    <input type="text" name="timein" id="datetimepicker1" class="form-control"><br>
                </div>

                <div class="form-group">
                    <label>Time Out</label><br>
                    <input type="text" name="timeout" id="datetimepicker2" class="form-control"><br>
                </div>
			</div>

                <button type="submit" class="btn btn-primary">
                                    {{ __('SUBMIT') }}
                                </button>
                                {{ csrf_field() }}
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                </form>


			    <div class="modal-footer">
                    
			</div>
		</div>
	</div>
</div>