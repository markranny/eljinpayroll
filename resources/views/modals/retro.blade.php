<!-- Bootstrap Basic Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
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
                <select class="selectpicker" name="employee_no" data-style="select-with-transition" multiple title="Choose Employee">
                    <option disabled>BW EMPLOYEES</option>
                        @foreach ($employees as $data)
                            <option value="{{$data->employee_no}}" >{{$data->lastname}} {{$data->firstname}}</option>
                        @endforeach
                </select>
                </div>

                <div class="form-group">
                    <label>DATE</label><br>
                    <input type="text" name="date" class="form-control datepicker" placeholder="Select Date"><br>
                </div>

                <div class="form-group">
                    <label>ACTIVE DATE</label><br>
                    <input type="text" name="activedate" class="form-control datepicker" placeholder="Select Date"><br>
                </div>
    
                <div class="form-group">
                <label>REMARKS</label><br>
                <textarea class="form-control textarea-autosize" name="remarks" id="textareaExample" rows="4" placeholder="Remarks"></textarea>
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