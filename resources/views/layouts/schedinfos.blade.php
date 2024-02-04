<div class="card table-header">
        <div class="card-body">
            <!-- Schedule Info's -->
            <div class="float-right">
                <div class="row">
                    <div class="col-2">
                        <a class="btn btn-primary btn-sm" href="{{ route('schedlistnav') }}">Back</a>
                    </div>
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
                                <th>Employee_No</th>
                                <th>Employee_Name</th>
                                <th>Department</th>
                                <th>Line</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Change_Schedule</th>
                                <th>Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>

            @foreach ($employee_schedule_posts as $data)
            <?php $sched_no = $data->sched_no ?>
            <?php $employee_no = $data->employee_no ?>
            @endforeach


            @include('modals.schedinfo');

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

    ajax: "{{ route('schedinfosdata',['id'=>$sched_no]) }}",

    columns: [

            {data: 'employee_no', name: 'employee_no'},

            {data: 'employee_name', name: 'employee_name'},

            {data: 'department', name: 'department'},

            {data: 'line', name: 'line'},

            {data: 'date_sched', name: 'date_sched'},

            {data: 'timess', name: 'timess'},

            {data: 'change_sched', name: 'change_sched'},

            {
                data: 'id',
                name: 'id',
                orderable: false,
                searchable: false,
                render: function (data, type, full, meta) {
                    return `
                    <button class="btn btn-sm btn-primary" onclick="setUpdateForm(${data}, '${full.dept_code}', '${full.department}')" data-toggle="modal" data-target="#updateModal" >EDIT</button>
                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#deleteModal" onclick="setDeleteButton(${data})">DELETE</button>    
                    `;
                }
            } 

    ]

    });
});


function setDeleteButton(id){
    $("#delete-footer").html(`
    <button class="btn btn-danger btn-sm mr-1" data-dismiss="modal" onclick="deleteDepartment(${id})">Delete</button>   
    <button class="btn btn-primary btn-sm" data-dismiss="modal">Cancel</button>
    `);
}

function setUpdateForm(id, dept_code, department){
    $("#updateData").html(`
    <div class="col-12">
        <div class="form-group">
            <input type="hidden" name="id" class="form-control" value="${id}"><br>
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <input type="text" name="dept_code" class="form-control" required placeholder="ENTER DEP CODE" style='text-transform:uppercase' value="${dept_code}"><br>
        </div>
    </div>

    <div class="col-12">
        <div class="form-group">
            <input type="text" name="department" class="form-control" required placeholder="ENTER DEPARTMENT" style='text-transform:uppercase' value="${department}"><br>
        </div>
    </div>
    <div class="col-12">
        <div class="form-group text-right">
                <button class="btn btn-danger btn-sm mr-1" type="submit">Update</button>   
                <button class="btn btn-primary btn-sm" data-dismiss="modal">Close</button>
        </div>
    </div>
    `);
}

</script>

    
