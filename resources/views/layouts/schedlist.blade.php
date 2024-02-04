<div class="card table-header">
        <div class="card-body">
            <!-- Schedule List -->
            <div class="float-right">
                <div class="row">
                </div>
            </div>
        </div>
    </div>


            <div class="card">
                <div class="card-body">
                    <div class="material-datatables">
                        <table id="sched" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                            <thead>
                                <tr>
                                <th>Schedule_No</th>
                                <th>Date</th>
                                <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

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

    var table = $('#sched').DataTable({

    processing: true,
    language: {
    processing: '<img width="80" height="80" src="/images/coffee-cup.webp" alt="spinner-frame-5"/>',
    },

    serverSide: true,

    "lengthMenu": [[5, 10, 20, -1], [5, 10, 20, "All"]],

     dom: 'lBfrtp',

    buttons: [ 'csv', 'excel', 'pdf', 'print' ],

    ajax: "{{ route('Scheddata') }}",

    columns: [

            {data: 'sched_no', name: 'sched_no'},

            {data: 'created_at', name: 'created_at'},

            {data: 'action', name: 'action', orderable: false, searchable: false}

    ]

    });
});

</script>
