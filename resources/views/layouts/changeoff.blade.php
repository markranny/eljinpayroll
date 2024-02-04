
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    
    
    <div class="card table-header">
        <div class="card-body">
            <!-- CHANGE SCHEDULE -->
            <div class="float-right">
                <div class="row">
                <div class="col-2">
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal">ADD CHANGE SCHEDULE</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

     <div class="card">
        <div class="card-body">
            <div class="material-datatables">
                <table id="changeoff" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                    <thead>
                        <tr>
                        <th>ID</th>
                        <th>Employee_No</th>
                        <th>Employee_Name</th>
                        <th>Working_Schedule</th>
                        <th>New_Working_Schedule</th>
                        <th>TIME (IN)</th>
                        <th>TIME (OUT)</th>
                        <th>Month</th>
                        <th>Period</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

        </div>
    </div>
</div>
        

@include('modals.changeoff');

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
    <script type='text/javascript'>
    $(document).ready(function(){

        // Department Change
        $('#employee_no').change(function(){

             // Employee id
             var employee_no = $(this).val();

             // Empty the dropdown
             $('#subemployeeno').find('option').not(':first').remove();

             // AJAX request 
             $.ajax({
                 url: '/changeoff-page/'+employee_no,
                 type: 'get',
                 dataType: 'json',
                 success: function(response){

                     var len = 0;
                     if(response['data'] != null){
                          len = response['data'].length;
                     }

                     if(len > 0){
                          // Read data and create <option >
                          for(var i=0; i<len; i++){

                               var employee_no = response['data'][i].employee_no;

                               var option = "<option value='"+employee_no+"'>"+employee_no+"</option>";

                               $("#subemployeeno").append(option); 
                          }
                     }

                 }
             });
        });
    });
</script>

<script type="text/javascript" src="{{asset('js/functions/changeoff.js')}}">
</script>


