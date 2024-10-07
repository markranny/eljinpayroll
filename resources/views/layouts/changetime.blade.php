
<div class="container-fluid" id="message"></div>

<div class="card table-header">
        <div class="card-body">
            <div class="float-right">
                <div class="row">
                <div class="col-2">
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">Change Time Schedule</button>

                    </div>
                </div>
            </div>
        </div>
    </div>


     <div class="card">
        <div class="card-body">
            <div class="material-datatables">
                <table id="changetime" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                    <thead>
                        <tr>
                        <th>Employeeattendanceid</th>
                        <th>Employee_no</th>
                        <th>Employee_name</th>
                        <th>IN</th>
                        <th>OUT</th>
                        <th>Date</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
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


<!-- Bootstrap Basic Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content" id="iddetector">
			<div class="modal-header">
				<h3 class="modal-title" style="font-weight: bold">CHANGE TIME SCHEDULE</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>


			<div class="modal-body">
                <form method="POST" action="{{ route('changetime') }}" enctype="multipart/form-data">
                @csrf  

                <div class="row">

                <div class="col-6">
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
                    @foreach ($empposts as $empposts)
                    <input type="text" name="employeeattendanceid" class="form-control" placeholder="Input Employeeattendanceid" max="10" value="{{ $empposts->employeeattendanceid }}" readonly><br>
                    @endforeach
                </div>
                </div>

                <div class="col-12">
                <div class="form-group">
                    <input type="text" name="datesched" class="form-control datepicker" placeholder="Select Date"><br>
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
                    <br>
                </div>
                </div>
    
                <div class="col-12">
                <div class="form-group">
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



<script type="text/javascript">
$(document).ready(function(){
    loadData();
});


function loadData() {
        if ($.fn.dataTable.isDataTable('#changetime')) {
            $('#changetime').DataTable().destroy();
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#changetime').DataTable({

        processing: true,
        language: {
        processing: '<img width="80" height="80" src="/images/coffee-cup.webp" alt="spinner-frame-5"/>',
        },

        serverSide: true,

        dom: 'lBfrtp',

        buttons: [ 'csv', 'excel', 'pdf', 'print' ],

        ajax: "{{ route('changetimedata') }}",

        columns: [

                {data: 'employeeattendanceid', name: 'employeeattendanceid'},

                {data: 'employee_no', name: 'employee_no'},

                {data: 'employee_name', name: 'employee_name'},

                {data: 'in1', name: 'in1'},

                {data: 'out1', name: 'out1'},

                {data: 'date', name: 'date'},

                {
                data: 'id',
                name: 'id',
                orderable: false,
                searchable: false,
                render: function (data, type, full, meta) {
                    return `
                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#deleteModal" onclick="setDeleteButton(${data})">DELETE</button>    
                    `;

                }
            } 

        ]

        });
    }
 
    function setDeleteButton(id){
        $("#delete-footer").html(`
        <button class="btn btn-danger btn-sm mr-1" data-dismiss="modal" onclick="deleteFunction(${id})">Delete</button>   
        <button class="btn btn-primary btn-sm" data-dismiss="modal">Cancel</button>
        `);
    } 

    /* function setDeleteButton(id){
        $("#delete-footer").html(` 
        <button class="btn btn-primary btn-sm" data-dismiss="modal">Cancel</button>
        `);
    }  */

    function deleteFunction(id){
    $.ajax({
            url: "/delete/changetime/"+id, 
            type: "GET",
            dataType: "json",
            success: function(response) {
                if (response.message == 'success') {
                    $("#message").html(`<div class="alert alert-success alert-dismissible" id="disappearingAlert">
                    Deletion success
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>`);
                    $(loadData);
                } else {
                    $("#message").html(`<div class="alert alert-danger alert-dismissible" id="disappearingAlert">
                    Deletion failed
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>`);
                }
            },
            error: function() {
                $("#message").html(`<div class="alert alert-danger alert-dismissible" id="disappearingAlert">
                    There is an unexpected error. Please try again later.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>`);
            }
        });
    }




</script>



