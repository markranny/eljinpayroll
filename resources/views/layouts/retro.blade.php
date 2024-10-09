
    <div class="float-right">
        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">ADD RETRO</button>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="material-datatables">
                <table id="retro" 
                       class="table table-striped table-hover w-100">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Employee No</th>
                            <th>Employee Name</th>
                            <th>Date</th>
                            <th>Active Date</th>
                            <th>Retro Hours</th>
                            <th>Status</th>
                            <th>Remarks</th>
                            <th>Month</th>
                            <th>Year</th>
                            <th>Period</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
        
@include('modals.retro');

<script type="text/javascript" src="{{asset('js/functions/retro.js')}}">
</script>



