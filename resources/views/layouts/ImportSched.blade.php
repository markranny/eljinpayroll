

<div class="card table-header">
    <div class="card-body">
        <!-- Import Employee's Schedule -->
        <div class="float-right">

            <div class="row">
        
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
            </div>

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
                        </tr>
                    </thead>
                </table>
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



