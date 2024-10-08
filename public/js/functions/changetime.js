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

    scrollX: true,
    scrollY: "55vh",

    dom: 'lBfrtp',

    buttons: [ 'csv', 'excel', 'pdf', 'print' ],

    ajax: "changetime-list",

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
                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#deleteModal" onclick="setDeleteButton(${data}, ${full.employee_no}, '${full.date}')">DELETE</button>    
                    `;

                }
            } 

    ]

    });
}


function setDeleteButton(id, employee_no, date){
    $("#delete-footer").html(`
    <button class="btn btn-danger btn-sm mr-1 " data-dismiss="modal" onclick="deleteChangetime(${id}, '${employee_no}', '${date}')" style="margin-top:10px;margin-right:10px;">Delete</button>   
    <button class="btn btn-primary btn-sm" data-dismiss="modal" style="margin-top:10px;margin-right:10px;">Cancel</button>
    `);
}

function setUpdateForm(id, employee_no,  fullname,  working_schedule, new_working_schedule, time_in,  time_out, remarks = ''){
    $("#updateData").html(`
    <div class="col-12">
        <div class="form-group">
            <input type="hidden" name="id" class="form-control" value="${id}"><br>
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <input type="text" name="employee_name" class="form-control" placeholder="Employee Name" disabled value="${fullname}"><br>
            <input type="text" name="employee_no" class="form-control" placeholder="Employee Number" disabled value="${employee_no}"><br>
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <input type="text" id="datetimepicker5" name="datesched" class="form-control datepicker" placeholder="WORKING SCHEDULE">
        </div>
    </div>
    <div class="col-6">
        <div class="form-group">
            <input type="text" id="datetimepicker6"  name="newdatesched" class="form-control datepicker" placeholder="NEW WORKING SCHEDULE">
        </div>
    </div>

    <div class="col-6">
        <div class="form-group">
            <input type="text" name="timein" id="datetimepicker3" class="form-control datepicker" placeholder=" Insert Time In" value="${time_in}">
        </div>
    </div>

    <div class="col-6">
        <div class="form-group">
            <input type="text" name="timeout" id="datetimepicker4" class="form-control datepicker" placeholder="Insert Time Out" value="${time_out}">
        </div>
    </div>

    <div class="col-12">
        <div class="form-group">
            <textarea class="form-control textarea-autosize" name="remarks" id="textareaExample" rows="4" placeholder="Remarks">${remarks}</textarea>
        </div>
    </div>
    <div class="col-12">
        <div class="form-group text-right">
                <button class="btn btn-danger btn-sm mr-1" type="submit">Update</button>   
                <button class="btn btn-primary btn-sm" data-dismiss="modal">Close</button>
        </div>
    </div>

    `);

    $('#datetimepicker3').datetimepicker({
		format: 'HH:mm'
	});
    $('#datetimepicker4').datetimepicker({
		format: 'HH:mm'
	});

    $('#datetimepicker5').datetimepicker({
        format: 'MM/DD/YYYY',
        defaultDate: working_schedule
    });
    $('#datetimepicker6').datetimepicker({
        format: 'MM/DD/YYYY',
        defaultDate: new_working_schedule
    });
}


$(document).ready(function() {
        $("#updateChangeOff").submit(function(e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
                url: "/update/changeoff/", 
                type: "POST",
                data: formData,
                processData: false,
                contentType: false, 
                success: function(response) {
                    if (response.message == 'success') {
                        $("#messageUpdate").html(`<div class="alert alert-success alert-dismissible" id="disappearingAlert">
                        Update success
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>`);
                        $(loadData);
                    } else {
                        $("#messageUpdate").html(`<div class="alert alert-danger alert-dismissible" id="disappearingAlert">
                        ${response.message}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>`);
                    }
                },
                error: function() {
                    $("#messageUpdate").html(`<div class="alert alert-danger alert-dismissible" id="disappearingAlert">
                        There is an unexpected error. Please try again later.
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>`);
                }
            });
        });
});

function deleteChangetime(id, employee_no, date){
    $.ajax({
            url: "/delete/changetime/"+id+'/'+employee_no+'/'+date, 
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

$(loadData);