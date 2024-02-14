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

  var table = $('#attendance').DataTable({

    processing: true,
    language: {
        processing: '<img width="80" height="80" src="/images/coffee-cup.webp" alt="spinner-frame-5"/>',
    },

  scrollX: true,

  ajax: "attendance-report-data",

  columns: [

      {data: 'action', name: 'action', orderable: false, searchable: false},

      {data: 'id', name: 'id'},

      {data: 'employeeattendanceid', name: 'employeeattendanceid'},

      {data: 'employee_no', name: 'employee_no'},

      {data: 'employee_name', name: 'employee_name'},

      {data: 'days', name: 'days'},

      {data: 'working_hours', name: 'working_hours'},

      {data: 'absent', name: 'absent'},

      {data: 'minutes_late', name: 'minutes_late'},

      {data: 'udt_hrs', name: 'udt_hrs'},

      {data: 'nightdif', name: 'nightdif'},

      {data: 'holiday_hrs', name: 'holiday_hrs'},

      {data: 'holiday_percent', name: 'holiday_percent'},

      {data: 'offdays', name: 'offdays'},

      {data: 'ot_hrs', name: 'ot_hrs'},

      {data: 'offset_hrs', name: 'offset_hrs'},

      {data: 'ob', name: 'ob'},

      {data: 'slvl_hrs', name: 'slvl_hrs'},

      {data: 'month', name: 'month'},

      {data: 'year', name: 'year'},

      {data: 'period', name: 'period'},


  ]

  });
});