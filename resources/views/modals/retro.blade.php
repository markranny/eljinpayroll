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


<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">

			<div class="modal-header">
				<h3 class="modal-title">ADD RETRO</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body">
                <form method="POST" action="{{ route('addretro') }}" enctype="multipart/form-data" >
                    @csrf  

                    <div class="form-group">
                        <select class="selectpicker" data-live-search="true" name="employee_name" id="employee_name" data-style="select-with-transition" title="EmployeeName" data-size="7">
                            <option disabled>BW EMPLOYEES</option>
                                @foreach ($employees as $data)
                                    <option value="{{$data->employee_no}}" >{{$data->lastname}} {{$data->firstname}}</option>
                                @endforeach
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label>DATE</label><br>
                                <input type="text" name="date" class="form-control datepicker" placeholder="Select Date"><br>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group">
                                <label>ACTIVE DATE</label><br>
                                <input type="text" name="activedate" class="form-control datepicker" placeholder="Select Date"><br>
                            </div>
                        </div>

                        <div class="col-4">
                            <div class="form-group">
                                <label>RETRO HRS</label><br>
                                <input type="text" name="retrohrs" class="form-control" placeholder="Input Retro Hrs"><br>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                            <label>REMARKS</label><br>
                            <textarea class="form-control textarea-autosize" name="remarks" id="textareaExample" rows="4" placeholder="Remarks"></textarea>
                        </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" style="margin-top:10px;margin-right:10px;">
                            {{ __('SUBMIT') }}
                        </button>
                            {{ csrf_field() }}
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" style="margin-top:10px;">
                            Close
                        </button>
                    </div>
                </form>
			</div>
		</div>
	</div>
</div>