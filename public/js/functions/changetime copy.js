
function loadData() {
        if ($.fn.dataTable.isDataTable('#changetime')) {
            $('#changetime').DataTable().destroy();
        }
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('#changetime').DataTable({

        processing: true,
        language: {
        processing: '<img width="80" height="80" src="/images/coffee-cup.webp" alt="spinner-frame-5"/>',
        },

        serverSide: true,

        dom: 'lBfrtp',

        buttons: [ 'csv', 'excel', 'pdf', 'print' ],

        ajax: "{{ route('changetimedata') }}",

        columns: [

                {data: 'employeeattendanceid', name: 'employeeattendanceid'},

                {data: 'employee_no', name: 'employee_no'},

                {data: 'fullname', name: 'fullname'},

                {data: 'in1', name: 'in1'},

                {data: 'out1', name: 'out1'},

                {data: 'date', name: 'date'},

                {
                data: 'id',
                name: 'id',
                orderable: false,
                searchable: false,
                render: function (data, type, full, meta) {
                    return `
                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#deleteModal" onclick="setDeleteButton(${data})">DELETE</button>    
                    `;

                }
            } 

        ]

        });
    }
 
    function setDeleteButton(id){
        $("#delete-footer").html(`
        <button class="btn btn-danger btn-sm mr-1" data-dismiss="modal" onclick="deleteFunction(${id})">Delete</button>   
        <button class="btn btn-primary btn-sm" data-dismiss="modal">Cancel</button>
        `);
    } 

    function deleteFunction(id){
    $.ajax({
            url: "/delete/changetime/"+id, 
            type: "GET",
            dataType: "json",
            success: function(response) {
                if (response.message == 'success') {
                    $("#message").html(`<div class="alert alert-success alert-dismissible" id="disappearingAlert">
                    Deletion success
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>`);
                    $(loadData);
                } else {
                    $("#message").html(`<div class="alert alert-danger alert-dismissible" id="disappearingAlert">
                    Deletion failed
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>`);
                }
            },
            error: function() {
                $("#message").html(`<div class="alert alert-danger alert-dismissible" id="disappearingAlert">
                    There is an unexpected error. Please try again later.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>`);
            }
        });
    }