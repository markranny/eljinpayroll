

<div class="card table-header">
        <div class="card-body">
            <!-- Retro -->
            <div class="float-right">
                <div class="row">
                <div class="col-2">
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">ADD RETRO</button>

                    </div>
                </div>
            </div>
        </div>
    </div>


     <div class="card">
        <div class="card-body">
            <div class="material-datatables">
                <table id="overtime" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                    <thead>
                        <tr>
                        <th>ID</th>
                        <th>Employee_No</th>
                        <th>Employee_Name</th>
                        <th>Date</th>
                        <th>Active_Date</th>
                        <th>status</th>
                        <th>Remarks</th>
                        <th>Month</th>
                        <th>Year</th>
                        <th>Period</th>
                        <!-- <th>Action</th> -->
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

        </div>
    </div>
</div>
        
@include('modals.retro');

<script type="text/javascript">

  $(function () {
      /*------------------------------------------
     --------------------------------------------
     Pass Header Token
     --------------------------------------------
     --------------------------------------------*/ 
     $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });

    var table = $('#overtime').DataTable({

    processing: true,
    language: {
    processing: '<img width="80" height="80" src="/images/coffee-cup.webp" alt="spinner-frame-5"/>',
    },

    serverSide: true,

    dom: 'lBfrtp',

    buttons: [ 'csv', 'excel', 'pdf', 'print' ],

    ajax: "{{ route('retrodata') }}",

    columns: [
            {data: 'id', name: 'id'},

            {data: 'employee_no', name: 'employee_no'},

            {data: 'firstname', name: 'firstname'},

            {data: 'working_schedule', name: 'working_schedule'},

            {data: 'active_date', name: 'active_date'},

            {data: 'remarks', name: 'remarks'},

            {data: 'status', name: 'status'},

            {data: 'month', name: 'month'},

            {data: 'year', name: 'year'},

            {data: 'period', name: 'period'}


    ]

    });
});

</script>



