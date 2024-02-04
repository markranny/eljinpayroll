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
        float: right;
      padding-left: 20px;
      }
      .table-csv{
        background: #00700a !important;
        color: #ffff !important;
        margin-top: 50px !important;
      }
      table.dataTable thead tr {
          background-color: darkblue;
          color: #ffff;
          font-family:"Calibri", sans-serif;
          font-weight: 900;
          font-size: 12px;
      }
    tr {
      font-family:"Calibri", sans-serif;
      font-size: 12px;
      }
        .msg-container{
        position:absolute;
        bottom:0;
        right:20px;
      }
      .navbar > .container, .navbar > .container-fluid{
        background-color: #000 !important;
        color: #fff !important;
      }
      .LayoutTable{
        margin-top: -30px !important;
      }
      .table-header{
        background: url('{{URL::asset('/images/table-header.png')}}')
      }

      div.dataTables_wrapper div.dataTables_filter{
        margin-top: -10px !important;
      }
      .btn-group, .btn-group-vertical {
          position: absolute !important;
          margin: -10px 1px !important;
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
                <li class="nav-item ">
                  <a class="nav-link" href="{{ route('payrolllistnav') }}">
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
                <!-- <li class="nav-item ">
                  <a class="nav-link" href="#">
                    <span class="sidebar-mini"> HH </span>
                    <span class="sidebar-normal"> View Holiday101 (HR) </span>
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
            <a class="nav-link" href="404/dist/index.html">
              <i class="material-icons">settings</i>
              <p> Configuration </p>
            </a>
          </li>
          @endif

          <li class="nav-item ">
            <a class="nav-link" href="404/dist/index.html">
              <i class="material-icons">contact_support</i>
              <p> Service </p>
            </a>
          </li>

        </ul>
      </div>
    </div>