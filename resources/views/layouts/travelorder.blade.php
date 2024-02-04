

<div class="card table-header">
        <div class="card-body">
            <!-- Travel Order -->
            <div class="float-right">
                <div class="row">
                <div class="col-2">
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">ADD TRAVEL ORDER</button>

                    </div>
                </div>
            </div>
        </div>
    </div>


     <div class="card">
        <div class="card-body">
            <div class="material-datatables">
                <table id="to" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                    <thead>
                        <tr>
                        <th>ID</th>
                        <th>Employee_No</th>
                        <th>Employee_Name</th>
                        <th>Inclusive_Date</th>
                        <th>Location</th>
                        <th>Purpose</th>
                        <th>Month</th>
                        <th>Year</th>
                        <th>Period</th>
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

@include('modals.travelorder');

<script type="text/javascript" src="{{asset('js/functions/travelorder.js')}}">
</script>



