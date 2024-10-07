$(function () {
    // Set up AJAX headers
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    var table = $('#att').DataTable({
        processing: true,
        scrollX: true,
        scrollY: "55vh",
        scrollCollapse: true,
        lengthMenu: [[10, 20, 100, -1], [10, 20, 100, "All"]],
        dom: 'lBfrtip',
        buttons: ['csv', 'excel', 'pdf', 'print'],
        ajax: "employee-data",
        columns: [
            {
                data: null,
                render: function(data, type, row) {
                    return `
                        <button class="btn btn-primary btn-sm edit-btn" data-empno="${row.employee_no}">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                    `;
                }
            },
            {data: 'employee_no', name: 'employee_no'},
            {data: 'lastname', name: 'lastname'},
            {data: 'firstname', name: 'firstname'},
            {data: 'middlename', name: 'middlename'},
            {data: 'suffix', name: 'suffix'},
            {data: 'gender', name: 'gender'},
            {data: 'educational_attainment', name: 'educational_attainment'},
            {data: 'degree', name: 'degree'},
            {data: 'civil_status', name: 'civil_status'},
            {data: 'birthdate', name: 'birthdate'},
            {data: 'contact_no', name: 'contact_no'},
            {data: 'email', name: 'email'},
            {data: 'present_address', name: 'present_address'},
            {data: 'permanent_address', name: 'permanent_address'},
            {data: 'emergency_contact_name', name: 'emergency_contact_name'},
            {data: 'emergency_contact', name: 'emergency_contact'},
            {data: 'emergency_relationship', name: 'emergency_relationship'},
            {data: 'employee_status', name: 'employee_status'},
            {data: 'job_status', name: 'job_status'},
            {data: 'rank_file', name: 'rank_file'},
            {data: 'department', name: 'department'},
            {data: 'line', name: 'line'},
            {data: 'job_title', name: 'job_title'},
            {data: 'hired_date', name: 'hired_date'},
            {data: 'endcontract', name: 'endcontract'},
            {data: 'pay_type', name: 'pay_type'},
            {data: 'pay_rate', name: 'pay_rate'},
            {data: 'allowance', name: 'allowance'},
            {data: 'sss_no', name: 'sss_no'},
            {data: 'philhealth_no', name: 'philhealth_no'},
            {data: 'hdmf_no', name: 'hdmf_no'},
            {data: 'tax_no', name: 'tax_no'},
            {data: 'taxable', name: 'taxable'},
            {data: 'costcenter', name: 'costcenter'}
        ]
    });

    // Add Employee button click handler
    $('#addEmployeeBtn').click(function() {
        $('#addEmployeeForm')[0].reset();
        $('#addEmployeeModal').modal('show');
    });

    // Save new employee handler
    $('#saveNewEmployee').click(function() {
        if (!$('#addEmployeeForm')[0].checkValidity()) {
            $('#addEmployeeForm')[0].reportValidity();
            return;
        }

        var formData = $('#addEmployeeForm').serialize();
        
        $.ajax({
            url: '/add-employee',
            type: 'POST',
            data: formData,
            success: function(response) {
                $('#addEmployeeModal').modal('hide');
                table.ajax.reload();
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Employee added successfully!'
                });
            },
            error: function(xhr) {
                console.error('Error adding employee:', xhr);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error adding employee. Please try again.'
                });
            }
        });
    });

    // Edit button click handler
$('#att').on('click', '.edit-btn', function() {
    var empNo = $(this).data('empno');
    
    $.ajax({
        url: '/get-employee/' + empNo,
        type: 'GET',
        dataType: 'json', // Expect JSON response
        success: function(response) {
            // Populate modal with employee data
            $('#edit_empno').val(response.employee_no);
            $('#edit_lname').val(response.lastname);
            $('#edit_fname').val(response.firstname);
            $('#edit_mname').val(response.middlename);
            $('#edit_suffix').val(response.suffix);
            $('#edit_gender').val(response.gender);
            $('#edit_educational_attainment').val(response.educational_attainment);
            $('#edit_degree').val(response.degree);
            $('#edit_civil_status').val(response.civil_status);
            $('#edit_birthdate').val(response.birthdate);
            $('#edit_contact_no').val(response.contact_no);
            $('#edit_email').val(response.email);
            $('#edit_present_address').val(response.present_address);
            $('#edit_permanent_address').val(response.permanent_address);
            $('#edit_emergency_contact_name').val(response.emergency_contact_name);
            $('#edit_emergency_contact').val(response.emergency_contact);
            $('#edit_emergency_relationship').val(response.emergency_relationship);
            $('#edit_employee_status').val(response.employee_status);
            $('#edit_job_status').val(response.job_status);
            $('#edit_rank_file').val(response.rank_file);
            $('#edit_department').val(response.department);
            $('#edit_line').val(response.line);
            $('#edit_job_title').val(response.job_title);
            $('#edit_hired_date').val(response.hired_date);
            $('#edit_endcontract').val(response.endcontract);
            $('#edit_pay_type').val(response.pay_type);
            $('#edit_pay_rate').val(response.pay_rate);
            $('#edit_allowance').val(response.allowance);
            $('#edit_costcenter').val(response.costcenter);
            $('#edit_sss_no').val(response.sss_no);
            $('#edit_philhealth_no').val(response.philhealth_no);
            $('#edit_hdmf_no').val(response.hdmf_no);
            $('#edit_tax_no').val(response.tax_no);
            $('#edit_taxable').val(response.taxable);
            
            // Show the modal
            $('#editEmployeeModal').modal('show');
        },
        error: function(xhr, status, error) {
            console.error('Error fetching employee data:', status, error);
            var errorMessage = xhr.responseJSON && xhr.responseJSON.message 
                ? xhr.responseJSON.message 
                : 'Error fetching employee data. Please try again.';
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: errorMessage
            });
        }
    });
});

    // Save changes button click handler
    $('#saveEmployeeChanges').click(function() {
        if (!$('#editEmployeeForm')[0].checkValidity()) {
            $('#editEmployeeForm')[0].reportValidity();
            return;
        }

        var formData = $('#editEmployeeForm').serialize();
        
        $.ajax({
            url: '/update-employee',
            type: 'POST',
            data: formData,
            success: function(response) {
                $('#editEmployeeModal').modal('hide');
                table.ajax.reload();
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: 'Employee information updated successfully!'
                });
            },
            error: function(xhr) {
                console.error('Error updating employee:', xhr);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Error updating employee information. Please try again.'
                });
            }
        });
    });
});