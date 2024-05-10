

<div class="card table-header">
        <div class="card-body">
            <div class="float-right">
                <div class="row">
                    <div class="col-2">
                        <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal" href="">EXECUTE PAYROLL CODE</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

     <div class="card">
        <div class="card-body">
            <!-- <div class="material-datatables"> -->
                <table id="importatt" class="table table-striped table-no-bordered table-hover">
                    <thead>
                        <tr>
                        <th style="width: 200px !important;">ACTIONS</th>
                        <th style="width: 100px !important;">ID</th>
                        <th style="width: 100px !important;">Employee_No</th>
                        <th style="width: 200px !important;">Employee_Name</th>
                        <th style="width: 200px !important;">Department</th>
                        <th style="width: 100px !important;">Job_Status</th>
                        <th style="width: 100px !important;">NETSALARY</th>
                        <th style="width: 100px !important;">BONDDEPO</th>
                        <th style="width: 100px !important;">MUTUALSHARE</th>
                        <th style="width: 100px !important;">MONTH</th>
                        <th style="width: 100px !important;">YEAR</th>
                        <th style="width: 100px !important;">PERIOD</th>
                        </tr>
                    </thead>
                    <tfoot class="table-footer">
                    <th style="width: 200px !important;">TOTAL</th>
                        <th style="width: 100px !important;">-</th>
                        <th style="width: 100px !important;">-</th>
                        <th style="width: 200px !important;">-</th>
                        <th style="width: 200px !important;">-</th>
                        <th style="width: 100px !important;">-</th>
                        <th style="width: 100px !important;">NETSALARY</th>
                        <th style="width: 100px !important;">BONDDEPO</th>
                        <th style="width: 100px !important;">MUTUALSHARE</th>
                        <th style="width: 100px !important;">-</th>
                        <th style="width: 100px !important;">-</th>
                        <th style="width: 100px !important;">-</th>
                    </tfoot>
                </table>
            <!-- </div> -->
        </div>
    </div>

        </div>
    </div>
</div>
        

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title" style="font-weight: bold">Payroll Master</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>


			<div class="modal-body">
                <form method="POST" action="{{ route('sentpayrollmaster') }}" enctype="multipart/form-data" >
                @csrf  

                <div class="row">

                <div class="col-6">
                <div class="form-group">
                    <a style="color: red;">CURRENT PAYROLL CODE</a>
                </div>
                </div>
                
                
                </div>
                </div>

                <button type="submit" class="btn btn-primary">
                                    {{ __('PROCESS') }}
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


<script type="text/javascript" src="{{asset('js/functions/payrolldata.js')}}">
</script>



