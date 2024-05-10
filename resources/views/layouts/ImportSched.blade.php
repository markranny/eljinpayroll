

<div class="card table-header">
    <div class="card-body">
        <!-- Import Employee's Schedule -->
        <div class="float-right">

            <div class="row">
        
                <div class="col-4">
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">ADD SCHEDULE</button>
                </div>

                <form id="dept-form" action="{{ route('palS') }}" method="POST">
                            @csrf
                </form>

                <div class="col-3">
                    <a class="btn btn-danger btn-sm" href="{{ route('clearS') }}">Clear</a>
                </div>
                
                <div class="col-2">
                    <a class="btn btn-primary btn-sm" id="pal" href="palS" onclick="event.preventDefault(); document.getElementById('dept-form').submit();" disabled="disabled">Post All Lines</a>
                </div>

              </div>
            </div>

            <!-- <div class="row">
        
                <div class="col-4">
                <form id="importS-form" action="{{ route('importS') }}" method="POST">
                @csrf
                    <input type="file" class="form-control" name="file" id="file" />
                </form>
                </div>

                <div class="col-2">
                    <a class="btn btn-primary btn-sm" href="importS" onclick="event.preventDefault(); document.getElementById('importS-form').submit();">Import</a>
                </div>

                <form id="dept-form" action="{{ route('palS') }}" method="POST">
                            @csrf
                </form>

                <div class="col-2">
                    <a class="btn btn-danger btn-sm" href="{{ route('clearS') }}">Clear</a>
                </div>
                
                <div class="col-2">
                    <a class="btn btn-primary btn-sm" id="pal" href="palS" onclick="event.preventDefault(); document.getElementById('dept-form').submit();" disabled="disabled">Post All Lines</a>
                </div>

              </div>
            </div> -->

        </div>
    </div>
</div>

<div class="container-fluid">
<div class="card">
        <div class="card-body">
            <div class="material-datatables">
                <table id="importsched" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                    <thead>
                        <tr>
                        <th>Employee_No</th>
                        <th>Employee_Name</th>
                        <th>Department</th>
                        <th>Line</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>

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
                            <option value="{{$data->employee_no}}" >{{$data->lastname}} {{$data->firstname}}</option>
                        @endforeach
                </select>
                </div>
            </div><br><br>

                <div class="col-6">
                <div class="form-group">
                    <input type="text" name="datesched" class="form-control datepicker" placeholder="Select StartDate"><br>
                </div>
                </div>

                <div class="col-6">
                <div class="form-group">
                    <input type="text" name="enddatesched" class="form-control datepicker" placeholder="Select EndDate"><br>
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



<div class="modal fade" id="deleteModal123" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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



<script type="text/javascript" src="{{asset('js/functions/importsched.js')}}">
</script>


<script>
$(document).ready(function() {
    $('#department').on('change', function() {
        if($(this).val() != '') {
            document.getElementById("myBtn").disabled = false;
        } else {
            document.getElementById("myBtn").disabled = true;
        }
    });
});
</script>



