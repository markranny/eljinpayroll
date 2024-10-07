<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content " id="iddetector">
			<div class="modal-header">
				<h3 class="modal-title" style="font-weight: bold">ADD CHANGE SCHEDULE</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body">
                <form method="POST" action="{{ route('addsched') }}" enctype="multipart/form-data" >
                    @csrf  
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <select class="selectpicker" data-live-search="true" name="employee_name" id="employee_name" data-style="select-with-transition" title="EmployeeName" data-size="7">
                                    <option disabled>BW EMPLOYEES</option>
                                        @foreach ($employees as $data)
                                            <option value="{{$data->employee_no}}" >{{$data->lastname}} {{$data->firstname}}</option>
                                        @endforeach
                                </select>
                            </div>
                        </div><br><br>

                        <div class="col-12">
                            <div class="form-group">
                                <input type="text" name="employeeattendanceid" class="form-control" placeholder="Input Employeeattendanceid" max="10" value="{{ $emppost }}" readonly><br>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <input type="text" name="datesched" class="form-control datepicker" placeholder="WORKING SCHEDULE"><br>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <input type="text" name="newdatesched" class="form-control datepicker" placeholder="NEW WORKING SCHEDULE"><br>
                            </div>
                        </div>

                        <div class="col-6">
                            <div class="form-group">
                                <div class="form-outline mb-4">
                                    <input type="text" id="datetimepicker1" name="timein" class="form-control">
                                    <label class="form-label" for="datetimepicker1">Time In</label>
                                </div>
                                <br>
                            </div>
                        </div>
                        
                        <div class="col-6">
                            <div class="form-group">
                                <div class="form-outline mb-4">
                                <input type="text" id="datetimepicker2" name="timeout" class="form-control">
                                <label class="form-label" for="datetimepicker1">Time Out</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <textarea class="form-control textarea-autosize" name="remarks" id="textareaExample" rows="4" placeholder="REMARKS"></textarea>
                            </div>
                        </div>
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
                <form id="updateChangeOff">
                    @csrf  

                    <div id="updateData" class="row">
                        
                    </div>
                </form>
			</div>
		</div>
	</div>
</div>

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

<script>
    function hideButtonIfValueIsNull() {
        var iddetector = document.getElementById('iddetector');
        var iddetector2 = document.getElementById('iddetector2');
        var employeeattendanceidInputs = document.getElementsByName('employeeattendanceid');
        
        var hide = true;
        for (var i = 0; i < employeeattendanceidInputs.length; i++) {
            if (employeeattendanceidInputs[i].value) {
                hide = false;
                break;
            }
        }

        if (hide) {
            iddetector.style.display = 'none';
            iddetector2.style.display = 'block';
        }
    }

    document.addEventListener('DOMContentLoaded', hideButtonIfValueIsNull);
</script>