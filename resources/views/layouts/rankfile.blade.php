

<div class="card">
        <div class="card-body">
            RANK FILE LISTS
            <div class="float-right">
                <div class="row">
                <div class="col-2">
                        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal">ADD RANKFILE</button>

                    </div>
                </div>
            </div>
        </div>
    </div>


     <div class="card">
        <div class="card-body">
            <div class="material-datatables">
                <table id="rankfile" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                    <thead>
                        <tr>
                        <th>ID</th>
                        <th>RANKFILECODE</th>
                        <th>RANKFILE</th>
                        <th>CREATEDDATE</th>
                        <th>ACTIONS</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

        </div>
    </div>
</div>

<!-- Bootstrap Basic Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title">ADD RANK FILE</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>


			<div class="modal-body">
                <form method="POST" action="{{ route('addrankfile') }}" enctype="multipart/form-data" >
                @csrf  

            <div class="row">

                <div class="col-12">
                <div class="form-group">
                    <input type="text" name="rank_file_code" class="form-control" placeholder="ENTER RANK FILECODE" style='text-transform:uppercase'><br>
                </div>
                </div>

                <div class="col-12">
                <div class="form-group">
                    <input type="text" name="rank_file" class="form-control" placeholder="ENTER RANK FILE" style='text-transform:uppercase'><br>
                </div>
                </div>

            
            </div>

                

                <button type="submit" class="btn btn-primary">
                                    {{ __('SUBMIT') }}
                                </button>
                                {{ csrf_field() }}
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>

                </form>
			</div>


			    <div class="modal-footer">
                    
			</div>
		</div>
	</div>
</div>

<!-- Bootstrap Basic Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
                <span class="modal-title font-weight-bold">UPDATE?</span>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
            <div class="container" id="messageUpdate">
            </div>
                <form id="updateRankFile">
                    @csrf  

                    <div id="updateData" class="row">
                        
                    </div>
                </form>
			</div>
		</div>
	</div>
</div>

<!-- Bootstrap Basic Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<span class="modal-title font-weight-bold">DELETE?</span>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>


			<div class="modal-body">
                Are you sure you want to delete this?
			</div>


			<div class="modal-footer" id="delete-footer">
                 
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">

function loadData() {
    if ($.fn.dataTable.isDataTable('#rankfile')) {
        $('#rankfile').DataTable().destroy();
    }

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

    var table = $('#rankfile').DataTable({

    processing: true,

    serverSide: true,

    dom: 'Bfrtp',

    buttons: [ 'csv', 'excel', 'pdf', 'print' ],

    ajax: "{{ route('rankfiledata') }}",

    columns: [

            {data: 'id', name: 'id'},

            {data: 'rank_file_code', name: 'rank_file_code'},

            {data: 'rank_file', name: 'rank_file'},

            {data: 'created_at', name: 'created_at'},

            {
                data: 'id',
                name: 'id',
                orderable: false,
                searchable: false,
                render: function (data, type, full, meta) {
                    return `
                    <button class="btn btn-sm btn-primary" onclick="setUpdateForm(${data}, '${full.rank_file_code}', '${full.rank_file}')" data-toggle="modal" data-target="#updateModal" >EDIT</button>
                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#deleteModal" onclick="setDeleteButton(${data})">DELETE</button>    
                    `;
                }
            } 
    ]

    });
}

function setDeleteButton(id){
    $("#delete-footer").html(`
    <button class="btn btn-danger btn-sm mr-1" data-dismiss="modal" onclick="deleteRankFile(${id})">Delete</button>   
    <button class="btn btn-primary btn-sm" data-dismiss="modal">Cancel</button>
    `);
}

function setUpdateForm(id, rank_file_code, rank_file){
    $("#updateData").html(`
    <div class="col-12">
        <div class="form-group">
            <input type="hidden" name="id" class="form-control" value="${id}"><br>
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <input type="text" name="rank_file_code" class="form-control" required placeholder="ENTER LINECODE" style='text-transform:uppercase' value="${rank_file_code}"><br>
        </div>
    </div>

    <div class="col-12">
        <div class="form-group">
            <input type="text" name="rank_file" class="form-control" required placeholder="ENTER LINE/SECTION" style='text-transform:uppercase' value="${rank_file}"><br>
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

$(document).ready(function() {
        $("#updateRankFile").submit(function(e) {
        e.preventDefault();

        var formData = new FormData(this);

        $.ajax({
                url: "/update/rankfile/", 
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

function deleteRankFile(id){
    $.ajax({
            url: "/delete/rankfile/"+id, 
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
</script>

</script>



