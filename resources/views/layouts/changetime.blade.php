
    <div class="float-right">
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">Change Time Schedule</button>
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
       
<!-- <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
</div> -->

@include('modals.changetime');


<!-- <script>
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
</script> -->

<script type="text/javascript" src="{{asset('js/functions/changetime.js')}}">
</script>







