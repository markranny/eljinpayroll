$(function () {
    $.ajaxSetup({
         headers: {
             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
         }
   });

   var table = $('#importattendance').DataTable({

   processing: true,
   language: {
    processing: '<img width="80" height="80" src="/images/coffee-cup.webp" alt="spinner-frame-5"/>',
    },

   scrollX: true,

   /* dom: 'Bfrtp',

   buttons: [ 'csv', 'excel', 'pdf', 'print' ], */

   ajax: "import-data",

   columns: [
           {data: 'employee_no', name: 'employee_no'},

           {data: 'date', name: 'date'},

           {data: 'day', name: 'day'},

           {data: 'in1', name: 'in1'},

           {data: 'out1', name: 'out1'},

           {data: 'in2', name: 'in2'},

           {data: 'out2', name: 'out2'},

           {data: 'nextday', name: 'nextday'},

           {data: 'hours_work', name: 'hours_work'},
   ]

   });
});