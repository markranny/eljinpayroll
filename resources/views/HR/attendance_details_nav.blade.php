<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    BW PAYROLL SYSTEM - Attendance Details
  </title>
  <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
  <link rel="stylesheet" type="text/css" href="css/MaterialPlugins/googleapis.css" />
  <link rel="stylesheet" href="css/MaterialPlugins/font-awesome.min.css">
  <link href="../../assets/css/material-dashboard.css?v=2.1.2" rel="stylesheet" />

</head>

<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-color="rose" data-background-color="black" data-image="../../assets/img/sidebar-1.jpg">

    <div class="logo"><a href="#" class="simple-text logo-mini">
          BW
        </a>
        <a href="#" class="simple-text logo-normal">
          PAYROLL SYSTEM
        </a></div>
      <div class="sidebar-wrapper">
        <div class="user">
          <div class="photo">
          <img src="../../assets/img/faces/eljin.jpg" />
          </div>
          <div class="user-info">
            <a data-toggle="collapse" href="#collapseExample" class="username">
              <span>
              Welcome back, {{ Auth::user()->username }}!, </br> Have A Nice Day!
                <b class="caret"></b>
              </span>
            </a>
            <div class="collapse" id="collapseExample">
              <ul class="nav">
                <li class="nav-item">
                  <a class="nav-link" href="#">
                    <span class="sidebar-mini"> MY </span>
                    <span class="sidebar-normal"> My Profile </span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">
                    <span class="sidebar-mini"> ED </span>
                    <span class="sidebar-normal"> Edit Profile </span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#">
                    <span class="sidebar-mini"> SE </span>
                    <span class="sidebar-normal"> Settings </span>
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <span class="sidebar-mini"> LO </span>
                    <span class="sidebar-normal"> Logout </span>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                    </form>
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>

        <ul class="nav">
          <li class="nav-item ">
            <a class="nav-link" href="{{ route('home') }}">
              <i class="material-icons">dashboard</i>
              <p> Dashboard </p>
            </a>
          </li>

          @if (Auth::user()->role == 'HR' || Auth::user()->role == 'ADMIN')
          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#pagesExamples">
              <i class="material-icons">group</i>
              <p> Employees
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="pagesExamples">
              <ul class="nav">
              <li class="nav-item ">
                  <a class="nav-link" href="{{ route('employeeinfonav') }}">
                    <span class="sidebar-mini"> EL </span>
                    <span class="sidebar-normal"> Employee's List </span>
                  </a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link" href="{{ route('ienav') }}">
                    <span class="sidebar-mini"> EL </span>
                    <span class="sidebar-normal"> View Inactive Employees </span>
                  </a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link" href="{{ route('importdEmpnav') }}">
                    <span class="sidebar-mini"> ID </span>
                    <span class="sidebar-normal"> Import Data </span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
          @endif

          @if (Auth::user()->role == 'HR' || Auth::user()->role == 'ADMIN')
          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#formsExamples">
              <i class="material-icons">fingerprint</i>
              <p> Attendance
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="formsExamples">
              <ul class="nav">
                <li class="nav-item ">
                  <a class="nav-link" href="{{ route('attpostsnav') }}">
                    <span class="sidebar-mini"> AI </span>
                    <span class="sidebar-normal"> Attendance</span>
                  </a>
                </li>
                <li class="nav-item ">
                  <!-- <a class="nav-link" href="{{ route('attreport') }}"> -->
                  <a class="nav-link" href="{{ route('attendancepostsplugin') }}">
                    <span class="sidebar-mini"> EC </span>
                    <span class="sidebar-normal"> DTR CHECKER </span>
                  </a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link" href="{{ route('importdatanav') }}">
                    <span class="sidebar-mini"> ID </span>
                    <span class="sidebar-normal"> Import Data </span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
          @endif

          @if (Auth::user()->role == 'FINANCE' || Auth::user()->role == 'ADMIN')
          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#tablesExamples">
              <i class="material-icons">touch_app</i>
              <p> Payroll
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="tablesExamples">
              <ul class="nav">
              <li class="nav-item ">
                  <a class="nav-link" href="{{ route('payrolllistnav') }}">
                    <span class="sidebar-mini"> PR </span>
                    <span class="sidebar-normal"> Payroll </span>
                  </a>
                </li>
                <!-- <li class="nav-item ">
                  <a class="nav-link" href="{{ route('payrolllistnav') }}">
                    <span class="sidebar-mini"> SC </span>
                    <span class="sidebar-normal"> Set Salary </span>
                  </a>
                </li> -->
              </ul>
            </div>
          </li>
          @endif

          @if (Auth::user()->role == 'HR' || Auth::user()->role == 'ADMIN')
          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#componentsExamples">
              <i class="material-icons">date_range</i>
              <p> Schedule
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="componentsExamples">
              <ul class="nav">
                <!-- <li class="nav-item ">
                  <a class="nav-link" href="{{ route('holidaynav') }}">
                    <span class="sidebar-mini"> SH </span>
                    <span class="sidebar-normal"> Set Holidays (HR) </span>
                  </a>
                </li> -->
                <li class="nav-item ">
                  <a class="nav-link" href="{{ route('schedlistnav') }}"> 
                    <!-- <a class="nav-link" href="404/dist/index.html"> -->
                    <span class="sidebar-mini"> SL </span>
                    <span class="sidebar-normal"> Schedule List </span>
                  </a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link" href="{{ route('importdEmpSchednav')}}"> 
                    <span class="sidebar-mini"> IS </span>
                    <span class="sidebar-normal"> Import Schedule </span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
          @endif

          @if (Auth::user()->role == 'HR' || Auth::user()->role == 'ADMIN')
          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#oe">
              <i class="material-icons">payments</i>
              <p> FILE
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="oe">
              <ul class="nav">
              <li class="nav-item ">
                <a class="nav-link" href="{{ route('overtimenav') }}">
                  <i class="material-icons">work_history</i>
                  <p> Overtime </p>
                </a>
              </li>
                <!-- <li class="nav-item ">
                  <a class="nav-link" href="{{ route('offsetnav') }}">
                    <i class="material-icons">schedule</i>
                    <p> Offset (PER HOUR) </p>
                  </a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link" href="{{ route('offset2nav') }}">
                    <i class="material-icons">schedule</i>
                    <p> Offset (WHOLE DAY) </p>
                  </a>
                </li> -->
                <li class="nav-item ">
                  <a class="nav-link" href="{{ route('changeoffnav') }}">
                    <i class="material-icons">pending_actions</i>
                    <p> Change Schedule </p>
                  </a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link" href="{{ route('changetimenav') }}">
                    <i class="material-icons">pending_actions</i>
                    <p> Change Time Sched</p>
                  </a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link" href="{{ route('slvlnav') }}">
                    <i class="material-icons">turned_in_not</i>
                    <p> SLVL </p>
                  </a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link" href="{{ route('tonav') }}">
                    <i class="material-icons">TO</i>
                    <p> Travel Order </p>
                  </a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link" href="{{ route('retronav') }}">
                    <i class="material-icons">R</i>
                    <p> Retro </p>
                  </a>
                </li>
              </ul>
            </div>
          </li>   
          @endif

          @if (Auth::user()->role == 'HR' || Auth::user()->role == 'ADMIN')
          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#formsExampless">
              <i class="material-icons">add</i>
              <p> Add
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="formsExampless">
              <ul class="nav">
                <li class="nav-item ">
                  <a class="nav-link" href="{{ route('linenav') }}">
                    <span class="sidebar-mini"> LS </span>
                    <span class="sidebar-normal"> Line/Section</span>
                  </a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link" href="{{ route('rankfilenav') }}">
                    <span class="sidebar-mini"> RF </span>
                    <span class="sidebar-normal"> Rank File </span>
                  </a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link" href="{{ route('depnav') }}">
                    <span class="sidebar-mini"> DP </span>
                    <span class="sidebar-normal"> Department</span>
                  </a>
                </li>
              </ul>
            </div>
          </li>
          @endif
              

          @if (Auth::user()->role == 'FINANCE' || Auth::user()->role == 'ADMIN')
          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#reports123">
              <i class="material-icons">loyalty</i>
              <p> Contributions
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="reports123">
              <ul class="nav">
              <li class="nav-item ">
                <a class="nav-link" href="{{ route('benefits') }}">
                  <i class="material-icons">summarize</i>
                  <p> Contribution </p>
                </a>
              </li>
              <li class="nav-item ">
                <a class="nav-link" href="#">
                  <i class="material-icons">summarize</i>
                  <p> Contribution List </p>
                </a>
              </li>
              </ul>
            </div>
          </li> 
          @endif  

          @if (Auth::user()->role == 'FINANCE' || Auth::user()->role == 'ADMIN')
          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#reports101">
              <i class="material-icons">trending_down</i>
              <p> Deductions
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="reports101">
              <ul class="nav">
              <li class="nav-item ">
                <a class="nav-link" href="{{ route('deductions') }}">
                  <i class="material-icons">summarize</i>
                  <p> Deductions </p>
                </a>
              </li>
              <li class="nav-item ">
                <a class="nav-link" href="#">
                  <i class="material-icons">summarize</i>
                  <p> Deduction List </p>
                </a>
              </li>
              </ul>
            </div>
          </li> 
          @endif  

          @if (Auth::user()->role == 'FINANCE' || Auth::user()->role == 'ADMIN')
          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#reports">
              <i class="material-icons">summarize</i>
              <p> Summary/List
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="reports">
              <ul class="nav">
              <!-- <li class="nav-item ">
                <a class="nav-link" href="#">
                  <i class="material-icons">summarize</i>
                  <p> PAYROLL ENTRY </p>
                </a>
              </li>
              <li class="nav-item ">
                <a class="nav-link" href="#">
                  <i class="material-icons">summarize</i>
                  <p> VALE </p>
                </a>
              </li>
              <li class="nav-item ">
                <a class="nav-link" href="#">
                  <i class="material-icons">summarize</i>
                  <p> EMPLOYEE CHARGE </p>
                </a>
              </li>
              <li class="nav-item ">
                <a class="nav-link" href="#">
                  <i class="material-icons">summarize</i>
                  <p> MEAL CHARGE </p>
                </a>
              </li>
              <li class="nav-item ">
                <a class="nav-link" href="#">
                  <i class="material-icons">summarize</i>
                  <p> UNIFORM CHARGE </p>
                </a>
              </li>
              <li class="nav-item ">
                <a class="nav-link" href="#">
                  <i class="material-icons">summarize</i>
                  <p> SSS Loan </p>
                </a>
              </li>
              <li class="nav-item ">
                <a class="nav-link" href="#">
                  <i class="material-icons">summarize</i>
                  <p> HDMF Loan </p>
                </a>
              </li>
              <li class="nav-item ">
                <a class="nav-link" href="#">
                  <i class="material-icons">summarize</i>
                  <p> SSS PREM </p>
                </a>
              </li>
              <li class="nav-item ">
                <a class="nav-link" href="#">
                  <i class="material-icons">summarize</i>
                  <p> HDMF PREM </p>
                </a>
              </li>
              <li class="nav-item ">
                <a class="nav-link" href="#">
                  <i class="material-icons">summarize</i>
                  <p> PHILHELATH </p>
                </a>
              </li>
              <li class="nav-item ">
                <a class="nav-link" href="#">
                  <i class="material-icons">summarize</i>
                  <p> UNIONS </p>
                </a>
              </li> -->
              </ul>
            </div>
          </li> 
          @endif  

          
          @if (Auth::user()->role == 'FINANCE' || Auth::user()->role == 'ADMIN')
          <li class="nav-item ">
            <a class="nav-link" href="404/dist/index.html">
              <i class="material-icons">account_balance</i>
              <p> 13th Month </p>
            </a>
          </li>
          @endif

          @if (Auth::user()->role == 'ADMIN')
          <li class="nav-item ">
            <a class="nav-link" href="404/dist/index.html">
              <i class="material-icons">settings</i>
              <p> Configuration </p>
            </a>
          </li>
          @endif

          <li class="nav-item ">
            <a class="nav-link" href="https://mammoth-capable-broadly.ngrok-free.app/">
              <i class="material-icons">contact_support</i>
              <p> Service </p>
            </a>
          </li>

        </ul>
      </div>
    </div>

    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-minimize">
              <button id="minimizeSidebar" class="btn btn-just-icon btn-white btn-fab btn-round">
                <i class="material-icons text_align-center visible-on-sidebar-regular">more_vert</i>
                <i class="material-icons design_bullet-list-67 visible-on-sidebar-mini">view_list</i>
              </button>
            </div>
            <a class="navbar-brand" href="javascript:;">Attendance details</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="sr-only">Toggle navigation</span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
            <span class="navbar-toggler-icon icon-bar"></span>
          </button>
          <div class="collapse navbar-collapse justify-content-end">
            <form class="navbar-form">
              <div class="input-group no-border">
                <input type="text" value="" class="form-control" placeholder="Search...">
                <button type="submit" class="btn btn-white btn-round btn-just-icon">
                  <i class="material-icons">search</i>
                  <div class="ripple-container"></div>
                </button>
              </div>
            </form>
            <ul class="navbar-nav">
              <li class="nav-item dropdown">
                <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" id="navbarDropdownProfile" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <i class="material-icons">logout</i>
                  <p class="d-lg-none d-md-block">
                    Account
                  </p>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      @csrf
                </form>
              </li>
            </ul>
          </div>
        </div>
      </nav>

      <div class="content">
        <div class="content">
          <div class="container-fluid">

    <div class="card">
        <div class="card-body">
            Details
            <div class="float-right">
                <div class="row">
                <div class="col-2">
                        <a class="btn btn-success btn-sm" href="{{ route('attpostsnav') }}">BACK</a>
                    </div>
                </div>
            </div>
        </div>
    </div>


     <div class="card">
        <div class="card-body">
            <div class="material-datatables">
                <!-- <table id="importatt" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%"> -->
                <table id="importatt" class="table table-striped table-no-bordered table-hover">
                    <thead>
                        <tr>
                        <th class="flex" style="width: 200px !important;">ID</th>
                        <th class="flex" style="width: 200px !important;">Employee_No</th>
                        <th class="flex" style="width: 200px !important;">Employee_Name</th>
                        <th class="flex" style="width: 200px !important;">Date</th>
                        <th class="flex" style="width: 200px !important;">Day</th>
                        <th class="flex" style="width: 200px !important;">IN</th>
                        <th class="flex" style="width: 200px !important;">OUT</th>
                        <th class="flex" style="width: 200px !important;">IMPORTED_HRS</th>
                        <th class="flex" style="width: 200px !important;">WORKING_HRS</th>
                        <th class="flex" style="width: 200px !important;">MINS_LATE</th>
                        <th class="flex" style="width: 200px !important;">UDT_HALFDAY</th>
                        <th class="flex" style="width: 200px !important;">NIGHTDIF</th>
                        <th class="flex" style="width: 200px !important;">HOLIDAYTYPE</th>
                        <th class="flex" style="width: 200px !important;">HOLIDAYPERCENT</th>
                        <th class="flex" style="width: 200px !important;">SLVL</th>
                        <th class="flex" style="width: 200px !important;">SLVLTYPE</th>
                        <th class="flex" style="width: 200px !important;">OVERTIME</th>
                        <th class="flex" style="width: 200px !important;">OFFSETHRS</th>
                        <th class="flex" style="width: 200px !important;">OB</th>
                        <th class="flex" style="width: 200px !important;">PERIOD</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

        </div>
    </div>
</div>

                        
    @foreach ($employee_attendance_posts as $data)
    <?php $empid = $data->employeeattendanceid ?>
    <?php $employee_no = $data->employee_no ?>
    @endforeach
        
            
          </div>
        </div>
      </div>
      <footer class="footer">
        <div class="container-fluid">
          <nav class="float-left">
            <ul>
              
            </ul>
          </nav>
          <div class="copyright float-right">
            &copy;
            <script>
              document.write(new Date().getFullYear())
            </script>, made with <i class="material-icons">favorite</i> by
            <a href="#" target="_blank">ProGen</a>.
          </div>
        </div>
      </footer>
    </div>
  </div>
  
  <!--   Core JS Files   -->
  <script src="../../assets/js/core/jquery.min.js"></script>
  <script src="../../assets/js/core/popper.min.js"></script>
  <script src="../../assets/js/core/bootstrap-material-design.min.js"></script>
  <script src="../../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <script src="../../assets/js/plugins/moment.min.js"></script>
  <script src="../../assets/js/plugins/sweetalert2.js"></script>
  <script src="../../assets/js/plugins/jquery.validate.min.js"></script>
  <script src="../../assets/js/plugins/jquery.bootstrap-wizard.js"></script>
  <script src="../../assets/js/plugins/bootstrap-selectpicker.js"></script>
  <script src="../../assets/js/plugins/bootstrap-datetimepicker.min.js"></script>
  <script src="../../assets/js/plugins/jquery.dataTables.min.js"></script>
  <script src="../../assets/js/plugins/bootstrap-tagsinput.js"></script>
  <script src="../../assets/js/plugins/jasny-bootstrap.min.js"></script>
  <script src="../../assets/js/plugins/fullcalendar.min.js"></script>
  <script src="../../assets/js/plugins/jquery-jvectormap.js"></script>
  <script src="../../assets/js/plugins/nouislider.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
  <script src="../../assets/js/plugins/arrive.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
  <script src="../../assets/js/plugins/chartist.min.js"></script>
  <script src="../../assets/js/plugins/bootstrap-notify.js"></script>
  <script src="../../assets/js/material-dashboard.js?v=2.1.2" type="text/javascript"></script>

  <script>
    $(document).ready(function() {
      $().ready(function() {
        $sidebar = $('.sidebar');

        $sidebar_img_container = $sidebar.find('.sidebar-background');

        $full_page = $('.full-page');

        $sidebar_responsive = $('body > .navbar-collapse');

        window_width = $(window).width();

        fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();

        if (window_width > 767 && fixed_plugin_open == 'Dashboard') {
          if ($('.fixed-plugin .dropdown').hasClass('show-dropdown')) {
            $('.fixed-plugin .dropdown').addClass('open');
          }

        }

        $('.fixed-plugin a').click(function(event) {
          if ($(this).hasClass('switch-trigger')) {
            if (event.stopPropagation) {
              event.stopPropagation();
            } else if (window.event) {
              window.event.cancelBubble = true;
            }
          }
        });

        $('.fixed-plugin .active-color span').click(function() {
          $full_page_background = $('.full-page-background');

          $(this).siblings().removeClass('active');
          $(this).addClass('active');

          var new_color = $(this).data('color');

          if ($sidebar.length != 0) {
            $sidebar.attr('data-color', new_color);
          }

          if ($full_page.length != 0) {
            $full_page.attr('filter-color', new_color);
          }

          if ($sidebar_responsive.length != 0) {
            $sidebar_responsive.attr('data-color', new_color);
          }
        });

        $('.fixed-plugin .background-color .badge').click(function() {
          $(this).siblings().removeClass('active');
          $(this).addClass('active');

          var new_color = $(this).data('background-color');

          if ($sidebar.length != 0) {
            $sidebar.attr('data-background-color', new_color);
          }
        });

        $('.fixed-plugin .img-holder').click(function() {
          $full_page_background = $('.full-page-background');

          $(this).parent('li').siblings().removeClass('active');
          $(this).parent('li').addClass('active');


          var new_image = $(this).find("img").attr('src');

          if ($sidebar_img_container.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
            $sidebar_img_container.fadeOut('fast', function() {
              $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
              $sidebar_img_container.fadeIn('fast');
            });
          }

          if ($full_page_background.length != 0 && $('.switch-sidebar-image input:checked').length != 0) {
            var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

            $full_page_background.fadeOut('fast', function() {
              $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
              $full_page_background.fadeIn('fast');
            });
          }

          if ($('.switch-sidebar-image input:checked').length == 0) {
            var new_image = $('.fixed-plugin li.active .img-holder').find("img").attr('src');
            var new_image_full_page = $('.fixed-plugin li.active .img-holder').find('img').data('src');

            $sidebar_img_container.css('background-image', 'url("' + new_image + '")');
            $full_page_background.css('background-image', 'url("' + new_image_full_page + '")');
          }

          if ($sidebar_responsive.length != 0) {
            $sidebar_responsive.css('background-image', 'url("' + new_image + '")');
          }
        });

        $('.switch-sidebar-image input').change(function() {
          $full_page_background = $('.full-page-background');

          $input = $(this);

          if ($input.is(':checked')) {
            if ($sidebar_img_container.length != 0) {
              $sidebar_img_container.fadeIn('fast');
              $sidebar.attr('data-image', '#');
            }

            if ($full_page_background.length != 0) {
              $full_page_background.fadeIn('fast');
              $full_page.attr('data-image', '#');
            }

            background_image = true;
          } else {
            if ($sidebar_img_container.length != 0) {
              $sidebar.removeAttr('data-image');
              $sidebar_img_container.fadeOut('fast');
            }

            if ($full_page_background.length != 0) {
              $full_page.removeAttr('data-image', '#');
              $full_page_background.fadeOut('fast');
            }

            background_image = false;
          }
        });

        $('.switch-sidebar-mini input').change(function() {
          $body = $('body');

          $input = $(this);

          if (md.misc.sidebar_mini_active == true) {
            $('body').removeClass('sidebar-mini');
            md.misc.sidebar_mini_active = false;

            $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar();

          } else {

            $('.sidebar .sidebar-wrapper, .main-panel').perfectScrollbar('destroy');

            setTimeout(function() {
              $('body').addClass('sidebar-mini');

              md.misc.sidebar_mini_active = true;
            }, 300);
          }

          // we simulate the window Resize so the charts will get updated in realtime.
          var simulateWindowResize = setInterval(function() {
            window.dispatchEvent(new Event('resize'));
          }, 180);

          // we stop the simulation of Window Resize after the animations are completed
          setTimeout(function() {
            clearInterval(simulateWindowResize);
          }, 1000);

        });
      });
    });
  </script>
  <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      md.initDashboardPageCharts();

      md.initVectorMap();

    });
  </script>
</body>

</html>

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

    var table = $('#importatt').DataTable({

   processing: true,

    serverSide: true,

    scrollCollapse: true,

    scrollY: true,

    scrollX: true,

    dom: 'Bfrtp',

    buttons: [ 'csv', 'excel', 'pdf', 'print' ],

    ajax: " {{ route('attdetailsdata',['id'=>$empid, 'employee_no'=>$employee_no])}} ",

    columns: [


            {data: 'employeeattendanceid', name: 'employeeattendanceid'},
            {data: 'employee_no', name: 'employee_no'},
            {data: 'employee_name', name: 'employee_name'},
            {data: 'date', name: 'date'},
            {data: 'day', name: 'day'},
            {data: 'in1', name: 'in1'},
            {data: 'out2', name: 'out2'},
            {data: 'hours_work', name: 'hours_work'},
            {data: 'working_hour', name: 'working_hour'},
            {data: 'minutes_late', name: 'minutes_late'},
            {data: 'udt_hrs', name: 'udt_hrs'},
            {data: 'nightdif', name: 'nightdif'},
            {data: 'holiday_type', name: 'holiday_type'},
            {data: 'holiday_percent', name: 'holiday_percent'},
            {data: 'slvl', name: 'slvl'},
            {data: 'slvl_type', name: 'slvl_type'},
            {data: 'overtime', name: 'overtime'},
            {data: 'offsethrs', name: 'offsethrs'},
            {data: 'ob', name: 'ob'},
            {data: 'period', name: 'period'}
    ]

    });
});

</script>