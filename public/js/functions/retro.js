// retro.js
function loadData() {
    // Destroy existing table if it exists
    if ($.fn.dataTable.isDataTable('#retro')) {
        $('#retro').DataTable().destroy();
    }
    
    // Setup CSRF token for all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Initialize DataTable
    const table = $('#retro').DataTable({
        processing: true,
        language: {
            processing: '<img width="80" height="80" src="/images/coffee-cup.webp" alt="loading"/>'
        },
        serverSide: true,
        scrollX: true,
        scrollY: "55vh",
        dom: 'lBfrtp',
        buttons: ['csv', 'excel', 'pdf', 'print'],
        ajax: "retro-list",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'employee_no', name: 'employee_no'},
            {data: 'firstname', name: 'firstname'},
            {data: 'working_schedule', name: 'working_schedule'},
            {data: 'active_date', name: 'active_date'},
            {data: 'retrohrs', name: 'retrohrs'},
            {data: 'remarks', name: 'remarks'},
            {data: 'status', name: 'status'},
            {data: 'month', name: 'month'},
            {data: 'year', name: 'year'},
            {data: 'period', name: 'period'},
            {
                data: 'id',
                name: 'actions',
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    // Escape potentially dangerous characters
                    const safeEmployeeNo = row.employee_no.replace(/['"\\]/g, '\\$&');
                    const safeWorkingSchedule = row.working_schedule.replace(/['"\\]/g, '\\$&');
                    
                    return `
                        <button class="btn btn-sm btn-primary" 
                                data-toggle="modal" 
                                data-target="#deleteModal" 
                                onclick="setDeleteButton(${data})"
                        >
                            DELETE
                        </button>    
                    `;
                }
            }
        ]
    });
}

function setDeleteButton(id) {
    const deleteFooter = $("#delete-footer");
    deleteFooter.empty().append(`
        <button class="btn btn-danger btn-sm" 
                onclick="deleteRetro('${id}')" 
                data-dismiss="modal" style="margin-top:10px;margin-right:10px;">
            Delete
        </button>   

        <button class="btn btn-primary btn-sm" 
                data-dismiss="modal" style="margin-top:10px;">
            Cancel
        </button>
    `);
}

function showAlert(type, message) {
    $("#message").html(`
        <div class="alert alert-${type} alert-dismissible fade show" id="disappearingAlert">
            ${message}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    `);
    
    // Auto-dismiss alert after 5 seconds
    setTimeout(() => {
        $("#disappearingAlert").alert('close');
    }, 5000);
}

function deleteRetro(id) {
    $.ajax({
        url: `/delete/retro/${id}`,
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

// Initialize on document ready
$(document).ready(function() {
    loadData();
});