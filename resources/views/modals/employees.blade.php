<div class="modal fade" id="addEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="addEmployeeModalLabel"><b>ADD EMPLOYEE</b></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body fixedModal">
                <form id="addEmployeeForm">
                    @csrf
                    
                    <div class="highlightstxt">
                        <h6>Personal Information</h6>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="lname">Last Name*</label>
                            <input type="text" class="form-control" id="lname" name="lname" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="fname">First Name*</label>
                            <input type="text" class="form-control" id="fname" name="fname" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="mname">Middle Name</label>
                            <input type="text" class="form-control" id="mname" name="mname">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="suffix">Suffix</label>
                            <input type="text" class="form-control" id="suffix" name="suffix">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="gender">Gender*</label>
                            <select class="form-control editMargin20px" id="gender" name="gender" required>
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="civil_status">Civil Status*</label>
                            <select class="form-control editMargin20px" id="civil_status" name="civil_status" required>
                                <option value="">Select Civil Status</option>
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                                <option value="Divorced">Divorced</option>
                                <option value="Widowed">Widowed</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="birthdate">Birthdate*</label>
                            <input type="date" class="form-control editMargin20px" id="birthdate" name="birthdate" required>
                        </div>
                    </div>

                    <h6 class="text-muted mb-3 mt-4">Contact Information</h6>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="contact_no">Contact No*</label>
                            <input type="tel" class="form-control" id="contact_no" name="contact_no" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="email">Email*</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="present_address">Present Address*</label>
                            <textarea class="form-control" id="present_address" name="present_address" rows="3" required></textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="permanent_address">Permanent Address*</label>
                            <textarea class="form-control" id="permanent_address" name="permanent_address" rows="3" required></textarea>
                        </div>
                    </div>

                    <div class="highlightstxt">
                        <h6>EMERGENCY CONTACT</h6>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="emergency_contact_name">Emergency Contact Name*</label>
                            <input type="text" class="form-control" id="emergency_contact_name" name="emergency_contact_name" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="emergency_contact">Emergency Contact No*</label>
                            <input type="tel" class="form-control" id="emergency_contact" name="emergency_contact" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="emergency_relationship">Emergency Relationship*</label>
                            <input type="text" class="form-control" id="emergency_relationship" name="emergency_relationship" required>
                        </div>
                    </div>

                    <div class="highlightstxt">
                        <h6>EMPLOYMENT Information</h6>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="employee_status">Employee Status*</label>
                            <select class="form-control editMargin20px" id="employee_status" name="employee_status" required>
                                <option value="">Select Employee Status</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                                <option value="On Leave">On Leave</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="job_status">Job Status*</label>
                            <select class="form-control editMargin20px" id="job_status" name="job_status" required>
                                <option value="">Select Job Status</option>
                                <option value="Full-time">Full-time</option>
                                <option value="Part-time">Part-time</option>
                                <option value="Contract">Contract</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="rank_file">Rank/File*</label>
                            <input type="text" class="form-control editMargin20px" id="rank_file" name="rank_file" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="department">Department*</label>
                            <input type="text" class="form-control" id="department" name="department" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="line">Line</label>
                            <input type="text" class="form-control" id="line" name="line">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="job_title">Job Title*</label>
                            <input type="text" class="form-control" id="job_title" name="job_title" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="hired_date">Hired Date*</label>
                            <input type="date" class="form-control" id="hired_date" name="hired_date" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="endcontract">End Contract</label>
                            <input type="date" class="form-control" id="endcontract" name="endcontract">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="educational_attainment">Educational Attainment*</label>
                            <input type="text" class="form-control" id="educational_attainment" name="educational_attainment" required>
                        </div>
                    </div>

                    <div class="highlightstxt">
                        <h6>COMPENSATION Information</h6>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="pay_type">Pay Type*</label>
                            <select class="form-control " id="pay_type" name="pay_type" required>
                                <option value="">Select Pay Type</option>
                                <option value="Hourly">Hourly</option>
                                <option value="Salary">Salary</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="pay_rate">Pay Rate*</label>
                            <input type="number" step="0.01" class="form-control" id="pay_rate" name="pay_rate" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="allowance">Allowance</label>
                            <input type="number" step="0.01" class="form-control" id="allowance" name="allowance">
                        </div>
                    </div>

                    <div class="highlightstxt">
                        <h6>GOVERNMENT ID's</h6>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="sss_no">SSS No</label>
                            <input type="text" class="form-control" id="sss_no" name="sss_no">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="philhealth_no">PhilHealth No</label>
                            <input type="text" class="form-control" id="philhealth_no" name="philhealth_no">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="hdmf_no">HDMF No</label>
                            <input type="text" class="form-control" id="hdmf_no" name="hdmf_no">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="tax_no">Tax No</label>
                            <input type="text" class="form-control" id="tax_no" name="tax_no">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="taxable">Taxable*</label>
                            <select class="form-control editMargin20px" id="taxable" name="taxable" required>
                                <option value="">Select Taxable Status</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="costcenter">Cost Center*</label>
                            <input type="text" class="form-control editMargin20px" id="costcenter" name="costcenter" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" style="margin-top:10px;margin-right:10px;">Close</button>
                <button type="button" class="btn btn-primary" id="addEmployee" style="margin-top:10px;">Add Employee</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="editEmployeeModal" tabindex="-1" role="dialog" aria-labelledby="editEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="editEmployeeModalLabel"><b>EDIT EMPLOYEE</b></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body fixedModal">
                <form id="editEmployeeForm">
                    @csrf
                    <input type="hidden" id="edit_empno" name="empno">
                    
                    <div class="highlightstxt">
                        <h6>Personal Information</h6>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="edit_lname">Last Name*</label>
                            <input type="text" class="form-control" id="edit_lname" name="lname" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="edit_fname">First Name*</label>
                            <input type="text" class="form-control" id="edit_fname" name="fname" required>
                        </div>
                        <div class="form-group col-md-3">
                            <label for="edit_mname">Middle Name</label>
                            <input type="text" class="form-control" id="edit_mname" name="mname">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="edit_suffix">Suffix</label>
                            <input type="text" class="form-control" id="edit_suffix" name="suffix">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="edit_gender">Gender*</label>
                            <select class="form-control editMargin20px" id="edit_gender" name="gender" required>
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="edit_civil_status">Civil Status*</label>
                            <select class="form-control editMargin20px" id="edit_civil_status" name="civil_status" required>
                                <option value="">Select Civil Status</option>
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                                <option value="Divorced">Divorced</option>
                                <option value="Widowed">Widowed</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="edit_birthdate">Birthdate*</label>
                            <input type="date" class="form-control editMargin20px" id="edit_birthdate" name="birthdate" required>
                        </div>
                    </div>

                    <h6 class="text-muted mb-3 mt-4">Contact Information</h6>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="edit_contact_no">Contact No*</label>
                            <input type="tel" class="form-control" id="edit_contact_no" name="contact_no" required>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="edit_email">Email*</label>
                            <input type="email" class="form-control" id="edit_email" name="email" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="edit_present_address">Present Address*</label>
                            <textarea class="form-control" id="edit_present_address" name="present_address" rows="3" required></textarea>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="edit_permanent_address">Permanent Address*</label>
                            <textarea class="form-control" id="edit_permanent_address" name="permanent_address" rows="3" required></textarea>
                        </div>
                    </div>

                    <div class="highlightstxt">
                        <h6>EMERGENCY CONTACT</h6>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="edit_emergency_contact_name">Emergency Contact Name*</label>
                            <input type="text" class="form-control" id="edit_emergency_contact_name" name="emergency_contact_name" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="edit_emergency_contact">Emergency Contact No*</label>
                            <input type="tel" class="form-control" id="edit_emergency_contact" name="emergency_contact" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="edit_emergency_relationship">Emergency Relationship*</label>
                            <input type="text" class="form-control" id="edit_emergency_relationship" name="emergency_relationship" required>
                        </div>
                    </div>

                    <div class="highlightstxt">
                        <h6>EMPLOYMENT Information</h6>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="edit_employee_status">Employee Status*</label>
                            <select class="form-control editMargin20px" id="edit_employee_status" name="employee_status" required>
                                <option value="">Select Employee Status</option>
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                                <option value="On Leave">On Leave</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="edit_job_status">Job Status*</label>
                            <select class="form-control editMargin20px" id="edit_job_status" name="job_status" required>
                                <option value="">Select Job Status</option>
                                <option value="Full-time">Full-time</option>
                                <option value="Part-time">Part-time</option>
                                <option value="Contract">Contract</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="edit_rank_file">Rank/File*</label>
                            <input type="text" class="form-control editMargin20px" id="edit_rank_file" name="rank_file" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="edit_department">Department*</label>
                            <input type="text" class="form-control" id="edit_department" name="department" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="edit_line">Line</label>
                            <input type="text" class="form-control" id="edit_line" name="line">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="edit_job_title">Job Title*</label>
                            <input type="text" class="form-control" id="edit_job_title" name="job_title" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="edit_hired_date">Hired Date*</label>
                            <input type="date" class="form-control" id="edit_hired_date" name="hired_date" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="edit_endcontract">End Contract</label>
                            <input type="date" class="form-control" id="edit_endcontract" name="endcontract">
                        </div>
                        <div class="form-group col-md-4">
                            <label for="edit_educational_attainment">Educational Attainment*</label>
                            <input type="text" class="form-control" id="edit_educational_attainment" name="educational_attainment" required>
                        </div>
                    </div>

                    <div class="highlightstxt">
                        <h6>COMPENSATION Information</h6>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="edit_pay_type">Pay Type*</label>
                            <select class="form-control editMargin20px" id="edit_pay_type" name="pay_type" required>
                                <option value="">Select Pay Type</option>
                                <option value="Hourly">Hourly</option>
                                <option value="Salary">Salary</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="edit_pay_rate">Pay Rate*</label>
                            <input type="number" step="0.01" class="form-control editMargin20px" id="edit_pay_rate" name="pay_rate" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="edit_allowance">Allowance</label>
                            <input type="number" step="0.01" class="form-control editMargin20px" id="edit_allowance" name="allowance">
                        </div>
                    </div>

                    <div class="highlightstxt">
                        <h6>GOVERNMENT ID's</h6>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label for="edit_sss_no">SSS No</label>
                            <input type="text" class="form-control" id="edit_sss_no" name="sss_no">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="edit_philhealth_no">PhilHealth No</label>
                            <input type="text" class="form-control" id="edit_philhealth_no" name="philhealth_no">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="edit_hdmf_no">HDMF No</label>
                            <input type="text" class="form-control" id="edit_hdmf_no" name="hdmf_no">
                        </div>
                        <div class="form-group col-md-3">
                            <label for="edit_tax_no">Tax No</label>
                            <input type="text" class="form-control" id="edit_tax_no" name="tax_no">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="edit_taxable">Taxable*</label>
                            <select class="form-control editMargin20px" id="edit_taxable" name="taxable" required>
                                <option value="">Select Taxable Status</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="edit_costcenter">Cost Center*</label>
                            <input type="text" class="form-control editMargin20px" id="edit_costcenter" name="costcenter" required>
                        </div>
                    </div>

                    
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" style="margin-top:10px;margin-right:10px;">Close</button>
                <button type="button" class="btn btn-primary" id="saveEmployeeChanges" style="margin-top:10px;">Save changes</button>
            </div>
        </div>
    </div>
</div>