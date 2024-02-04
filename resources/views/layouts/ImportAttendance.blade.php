<div class="LayoutTable">

<div class="card table-header">
    <div class="card-body">
        <!-- Import Attendance -->
        <div class="float-right">

            <div class="row">
                <div class="col-4">
                <form id="importA-form" action="{{ route('importA') }}" method="POST">
                @csrf
                    <input type="file" class="form-control" name="file" id="file" />
                </form>
                </div>

                <div class="col-2">
                    <a class="btn btn-primary btn-sm" href="{{ route('importA') }}" onclick="event.preventDefault(); document.getElementById('importA-form').submit();">Import</a>
                </div>

                <div class="col-2">
                    <a class="btn btn-danger btn-sm" href="{{ route('clearA') }}">Clear</a>
                </div>
                
                <div class="col-2">
                    <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal" style="color: #ffff !important">Save</a>
                </div>

                <div class="col-2">
                    <a class="btn btn-primary btn-sm" href="{{ route('attlist') }}">EAC</a>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
        <div class="card-body">
            <div class="material-datatables">
                <table id="importattendance" class="table table-striped table-no-bordered table-hover">
                    <thead>
                        <tr>
                        <th class="flex" style="width: 200px !important;">Employee_No</th>
                        <th class="flex" style="width: 200px !important;">Date</th>
                        <th class="flex" style="width: 200px !important;">Day</th>
                        <th class="flex" style="width: 200px !important;">IN</th>
                        <th class="flex" style="width: 200px !important;">OUT</th>
                        <th class="flex" style="width: 200px !important;">IN</th>
                        <th class="flex" style="width: 200px !important;">OUT</th>
                        <th class="flex" style="width: 200px !important;">Next_Day</th>
                        <th class="flex" style="width: 200px !important;">Working_Hrs</th>
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
