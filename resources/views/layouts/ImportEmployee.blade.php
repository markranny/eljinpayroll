
<div class="LayoutTable">
<div class="card table-header">
    <div class="card-body">
        <!-- Import Employee's Data -->
        <!--<div class="float-right">-->
		<div style="float: right;">

            <div class="row">
        
                <div class="col-4">
                <form id="importE-form" action="{{ route('importE') }}" method="POST">
                @csrf
                    <input type="file" class="form-control" name="file" id="file" />
                </form>
                </div>

                <div class="col-2">
                    <a class="btn btn-primary btn-sm" href="importE" onclick="event.preventDefault(); document.getElementById('importE-form').submit();">Import</a>
                </div>

                <div class="col-2">
                    <a class="btn btn-danger btn-sm" href="{{ route('clearE') }}">Clear</a>
                </div>
                
                <div class="col-2">
                    <a class="btn btn-primary btn-sm" href="{{ route('palE') }}">Post All Lines</a>
                </div>

              </div>
           </div>
        </div>
    </div>
</div>


<div class="card">
        <div class="card-body">
            <div class="material-datatables">
                <table id="importatt" class="table table-striped table-no-bordered table-hover">
                    <thead>
                        <tr>
                        <th style="width: 200px !important;">Employee_No</th>
                        <th style="width: 200px !important;">Lastname</th>
                        <th style="width: 200px !important;">Firstname</th>
                        <th style="width: 200px !important;">MiddleName</th>
                        <th style="width: 200px !important;">Suffix</th>
                        <th style="width: 200px !important;">Gender</th>
                        <th style="width: 200px !important;">Educational_Attainment</th>
                        <th style="width: 200px !important;">Degree</th>
                        <th style="width: 200px !important;">Civil_Status</th>
                        <th style="width: 200px !important;">Birthdate</th>
                        <th style="width: 200px !important;">Contact_No</th>
                        <th style="width: 200px !important;">Email</th>
                        <th style="width: 200px !important;">Present_Address</th>
                        <th style="width: 200px !important;">Permanent_Address</th>
                        <th style="width: 200px !important;">Emergency_Contact_Name</th>
                        <th style="width: 200px !important;">Emergency_Contact_No</th>
                        <th style="width: 200px !important;">Emergency_Relationship</th>
                        <th style="width: 200px !important;">Employee_Status</th>
                        <th style="width: 200px !important;">Job_Status</th>
                        <th style="width: 200px !important;">Rank_File</th>
                        <th style="width: 200px !important;">Department</th>
                        <th style="width: 200px !important;">Line</th>
                        <th style="width: 200px !important;">Job_title</th>
                        <th style="width: 200px !important;">Hired_Date</th>
                        <th style="width: 200px !important;">SSS_NO</th>
                        <th style="width: 200px !important;">PHILHEALTH_No</th>
                        <th style="width: 200px !important;">HDMF_No</th>
                        <th style="width: 200px !important;">Tax_No</th>
                        <th style="width: 200px !important;">Taxable</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
        
<script type="text/javascript" src="{{asset('js/functions/import_employee.js')}}">
</script>



