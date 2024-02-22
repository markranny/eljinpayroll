

<div class="card">
        <div class="card-body">
            Payroll List
            <div class="float-right">
                <div class="row">
                    <div class="col-2">
                        <a class="btn btn-success btn-sm" href="{{ route('edtrplugin') }}">PAYROLL PLUGIN</a>
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
                        <th style="width: 100px !important;">Rank_File</th>
                        <th style="width: 100px !important;">RegularDays</th>
                        <th style="width: 100px !important;">DaysEarned</th>
                        <th style="width: 100px !important;">GrossAmount</th>
                        <th style="width: 100px !important;">NetAmount</th>
                        <th style="width: 100px !important;">TotalDeduction</th>
                        <th style="width: 100px !important;">TotalContribution</th>
                        <th style="width: 100px !important;">TotalOtherDeductions</th>
                        <th style="width: 100px !important;">month</th>
                        <th style="width: 100px !important;">year</th>
                        <th style="width: 100px !important;">period</th>
                        </tr>
                    </thead>
                    <tfoot class="table-footer">
                    <th style="width: 200px !important;">TOTAL</th>
                        <th style="width: 100px !important;">-</th>
                        <th style="width: 100px !important;">-</th>
                        <th style="width: 200px !important;">-</th>
                        <th style="width: 200px !important;">-</th>
                        <th style="width: 100px !important;">-</th>
                        <th style="width: 100px !important;">-</th>
                        <th style="width: 100px !important;">RegularDays</th>
                        <th style="width: 100px !important;">DaysEarned</th>
                        <th style="width: 100px !important;">GrossAmount</th>
                        <th style="width: 100px !important;">NetAmount</th>
                        <th style="width: 100px !important;">TotalDeduction</th>
                        <th style="width: 100px !important;">TotalContribution</th>
                        <th style="width: 100px !important;">TotalOtherDeductions</th>
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
        
<script type="text/javascript" src="{{asset('js/functions/payrolldata.js')}}">
</script>



