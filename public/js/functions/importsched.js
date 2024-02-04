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

  var table = $('#importsched').DataTable({

  processing: true,
  language: {
    processing: '<img width="80" height="80" src="/images/coffee-cup.webp" alt="spinner-frame-5"/>',
    },

  scrollX: true,
  scrollY: "400px",
  scrollcollapse: true,

  serverSide: true,
  

  /* dom: 'Bfrtp',

  buttons: [ 'csv', 'excel', 'pdf', 'print' ], */

  ajax: "import-employee-schedule",

  columns: [

          {data: 'employee_no', name: 'employee_no'},

          {data: 'employee_name', name: 'employee_name'},

          {data: 'department', name: 'department'},

          {data: 'line', name: 'line'},

          {data: 'date_sched', name: 'date_sched'},

          {data: 'time', name: 'time'},

  ]

  });
});