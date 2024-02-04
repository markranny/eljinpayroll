<!-- /*--------------------------------------------------------------
        # AUTHOR: MARK RANNY AGLAPAY
        # CODENAME: PROGEN
        # LICENSE: PROGENLICENSE
--------------------------------------------------------------*/ -->


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="assets/img/progen.png">
  <link rel="icon" type="image/png" href="assets/img/progen.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    BW PAYROLL SYSTEM
  </title>
  <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Roboto+Slab:400,700|Material+Icons" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css">
  <link href="assets/css/material-dashboard.css?v=2.1.2" rel="stylesheet" />
  <style>
    body{
      background: url('images/eljin4.jpg')
    }

    @media screen and (max-width: 1024px) {
      body{
      background: url('images/eljin2-resize.jpg')
    } 
    }
    @media screen and (max-width: 1366px) {
      body{
      background: url('images/eljin2-resize-2.jpg')
    } 
    }
  </style>
</head>

<body class="">
  <div class="wrapper ">
    <div class="sidebar" data-color="rose" data-background-color="black" data-image="assets/img/sidebar-3.jpg">

    <div class="logo"><a href="#" class="simple-text logo-mini">
          BW
        </a>
        <a href="{{ route('home') }}" class="simple-text logo-normal">
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
                  <!-- <a class="nav-link" href="#"> -->
                  <a class="nav-link" href="404/dist/index.html">
                    <span class="sidebar-mini"> ED </span>
                    <span class="sidebar-normal"> Edit Profile </span>
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
                  <a class="nav-link" href="#">
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
                    <span class="sidebar-normal"> EARP CHECKER </span>
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
                <li class="nav-item ">
                  <!-- <a class="nav-link" href="{{ route('payrolllistnav') }}"> -->
                  <a class="nav-link" href="{{ route('saccplugin') }}">
                    <span class="sidebar-mini"> SC </span>
                    <span class="sidebar-normal"> Set Salary </span>
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
                  <a class="nav-link" href="#">
                    <span class="sidebar-mini"> HH </span>
                    <span class="sidebar-normal"> View Holiday101 (HR) </span>
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
                  <a class="nav-link" href="#">
                    <i class="material-icons">today</i>
                    <p> Holidays </p>
                  </a>
                </li> --> 
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
                  <a class="nav-link" href="{{ route('changetimenav') }}">
                    <i class="material-icons">schedule</i>
                    <p> Change Time </p>
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
                <!-- <li class="nav-item ">
                  <a class="nav-link" href="{{ route('retronav') }}">
                    <i class="material-icons">R</i>
                    <p> Retro </p>
                  </a>
                </li> -->
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
                  <a class="nav-link" href="#">
                    <span class="sidebar-mini"> LS </span>
                    <span class="sidebar-normal"> Line/Section</span>
                  </a>
                </li>
                <li class="nav-item ">
                  <a class="nav-link" href="{{ route('attreport') }}">
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
                <!-- <a class="nav-link" href="#"> -->
                <a class="nav-link" href="{{ route('contributionlists') }}">
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
                <!-- <a class="nav-link" href="{{ route('deductionlists') }}"> -->
                <a class="nav-link" href="{{ route('deductionlists') }}">
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
              <li class="nav-item ">
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
              </li>
              </ul>
            </div>
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

          <!-- <li class="nav-item ">
            <a class="nav-link" href="404/dist/index.html">
              <i class="material-icons">transform</i>
              <p> Adjustment </p>
            </a>
          </li> -->

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
      

      <div class="content">
        <div class="content">
          <div class="container-fluid">
            
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
            </script>, made with <!-- <i class="material-icons">favorite</i> --> by
            <a href="#" >ProgenX V1.02</a>.
          </div>
        </div>
      </footer>
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

          var simulateWindowResize = setInterval(function() {
            window.dispatchEvent(new Event('resize'));
          }, 180);

          setTimeout(function() {
            clearInterval(simulateWindowResize);
          }, 1000);

        });
      });
    });
  </script>
  <script>
    $(document).ready(function() {
      md.initDashboardPageCharts();

      md.initVectorMap();

    });
  </script>
</body>

</html>