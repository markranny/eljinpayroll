

<div class="LayoutTable">

<div class="float-right">
    <button id="addEmployeeBtn" class="btn btn-sm btn-primary mb-3">
        <i class="fas fa-plus"></i> Add Employee
    </button>
</div>

     <div class="card marginTop5px ">
        <div class="card-body">
            <div class="material-datatables">
                <table id="att" class="table table-striped table-no-bordered table-hover">
                    <thead>
                        <tr>
                        <th style="width: 100px !important;">Actions</th>
                        <th style="width: 200px !important;">EmpNo</th>
                        <th style="width: 200px !important;">Lname</th>
                        <th style="width: 200px !important;">Fname</th>
                        <th style="width: 200px !important;">MName</th>
                        <th style="width: 200px !important;">Suffix</th>
                        <th style="width: 200px !important;">Gender</th>
                        <th style="width: 200px !important;">EducationalAttainment</th>
                        <th style="width: 200px !important;">Degree</th>
                        <th style="width: 200px !important;">CivilStatus</th>
                        <th style="width: 200px !important;">Birthdate</th>
                        <th style="width: 200px !important;">ContactNo</th>
                        <th style="width: 200px !important;">Email</th>
                        <th style="width: 200px !important;">PresentAddress</th>
                        <th style="width: 200px !important;">PermanentAddress</th>
                        <th style="width: 200px !important;">EmerContactName</th>
                        <th style="width: 200px !important;">EmerContactNo</th>
                        <th style="width: 200px !important;">EmerRelationship</th>
                        <th style="width: 200px !important;">EmpStatus</th>
                        <th style="width: 200px !important;">JobStatus</th>
                        <th style="width: 200px !important;">RankFile</th>
                        <th style="width: 200px !important;">Department</th>
                        <th style="width: 200px !important;">Line</th>
                        <th style="width: 200px !important;">Jobtitle</th>
                        <th style="width: 200px !important;">HiredDate</th>
                        <th style="width: 200px !important;">EndOfContract</th>
                        <th style="width: 200px !important;">PayType</th>
                        <th style="width: 200px !important;">PayRate</th>
                        <th style="width: 200px !important;">Allowance</th>
                        <th style="width: 200px !important;">SSSNO</th>
                        <th style="width: 200px !important;">PHILHEALTHNo</th>
                        <th style="width: 200px !important;">HDMFNo</th>
                        <th style="width: 200px !important;">TaxNo</th>
                        <th style="width: 200px !important;">Taxable</th>
						<th style="width: 200px !important;">CostCenter</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

        </div>
    </div>
</div>
</div>

@include('modals.employees')
        
<script type="text/javascript" src="{{asset('js/functions/employee_infos.js')}}">
</script>



