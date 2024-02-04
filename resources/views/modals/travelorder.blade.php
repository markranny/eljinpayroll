<!-- Bootstrap Basic Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title">OFFICIAL BUSINESS</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>


			<div class="modal-body">
                <form method="POST" action="{{ route('addto') }}" enctype="multipart/form-data" >
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
                    <input type="text" name="datesched" class="form-control datepicker" placeholder="Inclusive DATE"><br>
                </div>
                </div>

                <div class="col-12">
                <div class="form-group">
                <textarea class="form-control textarea-autosize" name="location" id="textareaExample" rows="2" placeholder="location"></textarea>
                </div>
                </div>

                <div class="col-12">
                <div class="form-group">
                <textarea class="form-control textarea-autosize" name="remarks" id="textareaExample" rows="4" placeholder="Time and Purposes"></textarea>
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

<!-- Bootstrap Basic Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
                <span class="modal-title font-weight-bold">UPDATE?</span>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
            <div class="container" id="messageUpdate">
            </div>
                <form id="updateTravelOrder">
                    @csrf  

                    <div id="updateData" class="row">
                        
                    </div>
                </form>
			</div>
		</div>
	</div>
</div>

<!-- Bootstrap Basic Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<span class="modal-title font-weight-bold">DELETE?</span>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>


			<div class="modal-body">
                Are you sure you want to delete this?
			</div>


			<div class="modal-footer" id="delete-footer">
                 
			</div>
		</div>
	</div>
</div>
