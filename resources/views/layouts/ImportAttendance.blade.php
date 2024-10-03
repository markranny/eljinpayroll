                <div class="LayoutTable">

                    <div class="card table-header">
                        <div class="card-body">
                            <!-- Import Attendance -->
                            <div class="float-right">

                            <div class="row d-flex align-items-center">
                                <div class="col-4">
                                    <form id="importA-form" action="{{ route('importA') }}" method="POST">
                                        @csrf
                                        <input type="file" class="form-control" name="file" id="file" style="visibility: hidden;"/>
                                        
                                        <div class="d-flex" style="position: absolute; margin-top: -30px; margin-right: 20px;">
                                            <input type="text" name="fromdate" id="fromdate" class="form-control datepicker" placeholder="Start Date">
                                            <input type="text" name="todate" id="todate" class="form-control datepicker ml-2" placeholder="End Date">
                                        </div>
                                    </form>
                                </div>

                    <div class="col-2">
                        <a class="btn btn-primary btn-sm" href="{{ route('importA') }}" onclick="event.preventDefault(); document.getElementById('importA-form').submit();">Generate</a>
                    </div>

                    <div class="col-2">
                        <a class="btn btn-danger btn-sm" href="{{ route('clearA') }}">Clear</a>
                    </div>

                    <div class="col-2">
                        <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal2" style="color: #ffff !important">Add</a>
                    </div>
                    
                    <div class="col-2">
                        <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal" style="color: #ffff !important">Save</a>
                    </div>

                    <!-- <div class="col-2">
                        <a class="btn btn-primary btn-sm" href="http://10.151.5.55:5555/virtual/wflogin.html?l=0" target="_blank">EAC</a>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card marginTop10px">
        <div class="card-body resize-table">
            <div class="material-datatables">
                <table id="importattendance" class="table table-striped table-no-bordered table-hover">
                    <thead>
                        <tr>
                        <th class="flex" style="width: visibility: hidden; 100px;!important;">Employee_No</th>
                        <th class="flex" style="width: 250px !important;">Fullname</th>
                        <th class="flex" style="width: 150px !important;">Date</th>
                        <th class="flex" style="width: 150px !important;">Day</th>
                        <th class="flex" style="width: 150px !important;">IN</th>
                        <th class="flex" style="width: 150px !important;">OUT</th>
                        <th class="flex" style="width: 150px !important;">IN</th>
                        <th class="flex" style="width: 150px !important;">OUT</th>
                        <th class="flex" style="width: 150px !important;">Next_Day</th>
                        <th class="flex" style="width: 150px !important;">Working_Hrs</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    </div>


    @include('modals.iamodal')
        

    <script type="text/javascript" src="{{asset('js/functions/importattendance.js')}}">
</script>
