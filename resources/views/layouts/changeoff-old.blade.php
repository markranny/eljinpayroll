    <div class="float-right">
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">ADD CHANGE OFF</button>
    </div>

            <div class="card marginTop5px">
                <div class="card-body resize-table">
                    <div class="material-datatables">
                        <table id="changeoff" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                            <thead>
                                <tr>
                                <th>ID</th>
                                <th>Employee_No</th>
                                <th>Employee_Name</th>
                                <th>Working_Schedule</th>
                                <th>New_Working_Schedule</th>
                                <th>TIME (IN)</th>
                                <th>TIME (OUT)</th>
                                <th>Month</th>
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


@include('modals.changeoff');

<script type="text/javascript" src="{{asset('js/functions/changeoff.js')}}">
</script>


