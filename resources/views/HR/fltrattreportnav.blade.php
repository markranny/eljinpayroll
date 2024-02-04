<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    BW PAYROLL SYSTEM
  </title>
  <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <link href="assets/css/material-dashboard.css?v=2.1.2" rel="stylesheet" />
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

        <style>
          .float-right{
            width: 70%;
          }
          .table-csv{
            background: #00700a !important;
            color: #ffff !important;
            margin-top: 50px !important;
          }
          table.dataTable thead tr {
              background-color: green;
              color: #ffff;
            }
            .msg-container{
            position:absolute;
            bottom:0;
            right:20px;
          }
        </style>
</head>

<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-color="rose" data-background-color="black" data-image="assets/img/sidebar-1.jpg">

    <div class="logo"><a href="#" class="simple-text logo-mini">
          BW
        </a>
        <a href="#" class="simple-text logo-normal">
          PAYROLL SYSTEM
        </a></div>
      <div class="sidebar-wrapper">
        <div class="user">
          <div class="photo">
          <img src="assets/img/faces/eljin.jpg" />
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
                <!-- <li class="nav-item ">
                  <a class="nav-link" href="{{ route('attreport') }}">
                    <span class="sidebar-mini"> AZ </span>
                    <span class="sidebar-normal"> Analyze </span>
                  </a>
                </li> -->
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
                <li class="nav-item ">
                  <a class="nav-link" href="{{ route('payrolllistnav') }}">
                    <span class="sidebar-mini"> PP </span>
                    <span class="sidebar-normal"> Payroll Post</span>
                  </a>
                </li>
                
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
                <li class="nav-item ">
                  <a class="nav-link" href="{{ route('holidaynav') }}">
                    <span class="sidebar-mini"> SH </span>
                    <span class="sidebar-normal"> Set Holidays (HR) </span>
                  </a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link" href="{{ route('schedlistnav') }}"> 
                    <!-- <a class="nav-link" href="404/dist/index.html"> -->
                    <span class="sidebar-mini"> SL </span>
                    <span class="sidebar-normal"> Schedule List </span>
                  </a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link" href="{{ route('importdEmpSchednav')}}"> 
                  <!-- <a class="nav-link" href="404/dist/index.html"> -->
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
              <p> Other Earnings
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
                  <a class="nav-link" href="#">
                    <i class="material-icons">today</i>
                    <p> Holidays </p>
                  </a>
                </li> --> 
                <li class="nav-item ">
                  <a class="nav-link" href="{{ route('offsetnav') }}">
                    <!-- <a class="nav-link" href="404/dist/index.html"> -->
                    <i class="material-icons">schedule</i>
                    <p> Offset (PER HOUR) </p>
                  </a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link" href="{{ route('offset2nav') }}">
                    <!-- <a class="nav-link" href="404/dist/index.html"> -->
                    <i class="material-icons">schedule</i>
                    <p> Offset (WHOLE DAY) </p>
                  </a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link" href="{{ route('changeoffnav') }}">
                    <i class="material-icons">pending_actions</i>
                    <p> Change Schedule </p>
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

          @if (Auth::user()->role == 'FINANCE' || Auth::user()->role == 'ADMIN')
          <li class="nav-item ">
            <a class="nav-link" data-toggle="collapse" href="#reports">
              <i class="material-icons">summarize</i>
              <p> Reports
                <b class="caret"></b>
              </p>
            </a>
            <div class="collapse" id="reports">
              <ul class="nav">
              <li class="nav-item ">
                <a class="nav-link" href="#">
                  <i class="material-icons">summarize</i>
                  <p> Deductions </p>
                </a>
              </li>
              <li class="nav-item ">
                <a class="nav-link" href="#">
                  <i class="material-icons">summarize</i>
                  <p> Contributions </p>
                </a>
              </li>
              </ul>
            </div>
          </li> 
          @endif  
              
          @if (Auth::user()->role == 'FINANCE' || Auth::user()->role == 'ADMIN')
          <li class="nav-item ">
            <a class="nav-link" href="{{ route('benefits') }}">
              <i class="material-icons">loyalty</i>
              <p> Contributions </p>
            </a>
          </li>
          @endif

          @if (Auth::user()->role == 'FINANCE' || Auth::user()->role == 'ADMIN')
          <li class="nav-item ">
            <a class="nav-link" href="{{ route('deductions') }}">
              <i class="material-icons">trending_down</i>
              <p> Deductions </p>
            </a>
          </li>
          @endif

          
          @if (Auth::user()->role == 'FINANCE' || Auth::user()->role == 'ADMIN')
          <li class="nav-item ">
            <!-- <a class="nav-link" href="404/dist/index.html"> -->
            <a class="nav-link" href="404/dist/index.html">
              <i class="material-icons">account_balance</i>
              <p> 13th Month </p>
            </a>
          </li>
          @endif

          <!-- <li class="nav-item ">
            <a class="nav-link" href="404/dist/index.html">
              <i class="material-icons">receipt</i>
              <p> Payslip </p>
            </a>
          </li> -->

          <!-- <li class="nav-item ">
            <a class="nav-link" href="#">
              <i class="material-icons">storage</i>
              <p> Database </p>
            </a>
          </li> -->

          <li class="nav-item ">
            <!-- <a class="nav-link" href="404/dist/index.html"> -->
            <a class="nav-link" href="404/dist/index.html">
              <i class="material-icons">transform</i>
              <p> Adjustment </p>
            </a>
          </li>

          @if (Auth::user()->role == 'ADMIN')
          <li class="nav-item ">
            <!-- <a class="nav-link" href="404/dist/index.html"> -->
            <a class="nav-link" href="404/dist/index.html">
              <i class="material-icons">settings</i>
              <p> Configuration </p>
            </a>
          </li>
          @endif

          <li class="nav-item ">
            <!-- <a class="nav-link" href="404/dist/index.html"> -->
            <a class="nav-link" href="404/dist/index.html">
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
            <a class="navbar-brand" href="javascript:;">Attendance</a>
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
      <!-- End Navbar -->
      <div class="content">
        <div class="content">
          <div class="container-fluid">
          
          @include('layouts.fltrattreportdata') 
            
          </div>
        </div>
      </div>
    </div>
  </div>
  
  
  <!--   Core JS Files   -->
  <script src="assets/js/core/jquery.min.js"></script>
  <script src="assets/js/core/popper.min.js"></script>
  <script src="assets/js/core/bootstrap-material-design.min.js"></script>
  <script src="assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <script src="assets/js/plugins/moment.min.js"></script>
  <script src="assets/js/plugins/sweetalert2.js"></script>
  <script src="assets/js/plugins/jquery.validate.min.js"></script>
  <script src="assets/js/plugins/jquery.bootstrap-wizard.js"></script>
  <script src="assets/js/plugins/bootstrap-selectpicker.js"></script>
  <script src="assets/js/plugins/bootstrap-datetimepicker.min.js"></script>
  <script src="assets/js/plugins/jquery.dataTables.min.js"></script>
  <script src="assets/js/plugins/bootstrap-tagsinput.js"></script>
  <script src="assets/js/plugins/jasny-bootstrap.min.js"></script>
  <script src="assets/js/plugins/fullcalendar.min.js"></script>
  <script src="assets/js/plugins/jquery-jvectormap.js"></script>
  <script src="assets/js/plugins/nouislider.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/core-js/2.4.1/core.js"></script>
  <script src="assets/js/plugins/arrive.min.js"></script>
  <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
  <script src="assets/js/plugins/chartist.min.js"></script>
  <script src="assets/js/plugins/bootstrap-notify.js"></script>
  <script src="assets/js/material-dashboard.js?v=2.1.2" type="text/javascript"></script>

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
          // Alex if we click on switch, stop propagation of the event, so the dropdown will not be hide, otherwise we set the  section active
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

  <script>
    $(function() {
    $('#successbtn')
    .delay(5000)
    .fadeOut(function() {
      $(this).remove(); 
    });
    });

    $(function() {
    $('#errorbtn')
    .delay(5000)
    .fadeOut(function() {
      $(this).remove(); 
    });
    });

    $(function() {
    $('#warningbtn')
    .delay(5000)
    .fadeOut(function() {
      $(this).remove(); 
    });
    });

    $(function() {
    $('#errorpost')
    .delay(5000)
    .fadeOut(function() {
      $(this).remove(); 
    });
    });

    $(function() {
    $('#successpost')
    .delay(5000)
    .fadeOut(function() {
      $(this).remove(); 
    });
    });
  </script>
</body>

</html>