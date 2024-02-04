<!-- Bootstrap Basic Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="modal-title" style="font-weight: bold">UPDATE</h3>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>


			<div class="modal-body">
                <form method="POST" action="{{ route('addoffset') }}" enctype="multipart/form-data" >
                @csrf  

                <div class="row">

                <input type="text" name="employee_no" id="employee_no">

                </div>
                </div>

                <button type="submit" class="btn btn-primary">
                                    UPDATE
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