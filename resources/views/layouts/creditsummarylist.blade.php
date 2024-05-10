

<div class="card">
        <div class="card-body">
                <table id="credit" class="table table-striped table-no-bordered table-hover">
                    <thead>
                        <tr>
                        <th class="flex" style="width: 200px !important;">CostCenter</th>
                        <th class="flex" style="width: 200px !important;">SSS_Loan</th>
                        <th class="flex" style="width: 200px !important;">HDMF_Loan</th>
                        <th class="flex" style="width: 200px !important;">Mutual_Loan</th>
                        <th class="flex" style="width: 200px !important;">Mutual_Share</th>
                        <th class="flex" style="width: 200px !important;">SSS_Prem</th>
                        <th class="flex" style="width: 200px !important;">HDMF_Prem</th>
                        <th class="flex" style="width: 200px !important;">PhilHealth</th>
                        <th class="flex" style="width: 200px !important;">Unions</th>
                        <th class="flex" style="width: 200px !important;">Advanced</th>
                        <th class="flex" style="width: 200px !important;">Deposit</th>
                        <th class="flex" style="width: 200px !important;">Charge</th>
                        <th class="flex" style="width: 200px !important;">Meal</th>
                        <th class="flex" style="width: 200px !important;">Misc</th>
                        <th class="flex" style="width: 200px !important;">Uniform</th>
                        <th class="flex" style="width: 200px !important;">BondDeposit</th>
                        <th class="flex" style="width: 200px !important;">MutualCharge</th>
                        </tr>
                    </thead>
                        <tfoot class="table-footer">
                        <th class="flex" style="width: 200px !important;">TOTAL</th>
                        <th class="flex" style="width: 200px !important;"></th>
                        <th class="flex" style="width: 200px !important;"></th>
                        <th class="flex" style="width: 200px !important;"></th>
                        <th class="flex" style="width: 200px !important;"></th>
                        <th class="flex" style="width: 200px !important;"></th>
                        <th class="flex" style="width: 200px !important;"></th>
                        <th class="flex" style="width: 200px !important;"></th>
                        <th class="flex" style="width: 200px !important;"></th>
                        <th class="flex" style="width: 200px !important;"></th>
                        <th class="flex" style="width: 200px !important;"></th>
                        <th class="flex" style="width: 200px !important;"></th>
                        <th class="flex" style="width: 200px !important;"></th>
                        <th class="flex" style="width: 200px !important;"></th>
                        <th class="flex" style="width: 200px !important;"></th>
                        <th class="flex" style="width: 200px !important;"></th>
                        <th class="flex" style="width: 200px !important;"></th>
                        </tfoot>
                </table>
        </div>
    </div>

<!-- <script type="text/javascript" src="{{asset('js/functions/debit.js')}}">
</script> -->

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

  var table = $('#credit').DataTable({

      processing: true,
language: {
    processing: '<img width="80" height="80" src="/images/coffee-cup.webp" alt="spinner-frame-5"/>',
},

scrollX: true,
scrollY: "400px",
scrollcollapse: true,

"lengthMenu": [[10, 20, 100,  -1], [10, 20, 100, "All"]],

 dom: '<"top"fl<"clear">>rt<"bottom"ip<"clear">>',

 dom: 'lBfrtp',

buttons: [ 'csv', 'excel', 'pdf', 'print' ],

  

  ajax: "{{ route('creditsummarydata') }}",

  columns: [

      {data: 'CostCenter', name: 'CostCenter'},
      {data: 'sss_loan', name: 'sss_loan'},
      {data: 'pag_ibig_loan', name: 'pag_ibig_loan'},
      {data: 'mutual_loan', name: 'mutual_loan'},
      {data: 'mutual_share', name: 'mutual_share'},
      {data: 'sss_prem', name: 'sss_prem'},
      {data: 'pag_ibig_prem', name: 'pag_ibig_prem'},
      {data: 'philhealth', name: 'philhealth'},
      {data: 'unions', name: 'unions'},
      {data: 'advance', name: 'advance'},
      {data: 'bond_deposit', name: 'bond_deposit'},
      {data: 'charge', name: 'charge'},
      {data: 'meal', name: 'meal'},
      {data: 'misc', name: 'misc'},
      {data: 'uniform', name: 'uniform'},
      {data: 'bond_deposit', name: 'bond_deposit'},
      {data: 'mutual_charge', name: 'mutual_charge'}


  ],

  footerCallback: function (row, data, start, end, display) {
    var api = this.api();

    // Define columns to sum
    var sumColumns = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15]; // Column indices of columns to sum

    // Calculate sum for each column
    sumColumns.forEach(function (colIndex) {
        var sum = api.column(colIndex, { search: 'applied' }).data().reduce(function (a, b) {
            return parseFloat(a) + parseFloat(b); // Use parseFloat to handle decimal values
        }, 0);

        // Update footer with sum
        $(api.column(colIndex).footer()).html('P' + sum.toFixed(2)); // Display sum with two decimal places
    });

}

  });
});
</script>



