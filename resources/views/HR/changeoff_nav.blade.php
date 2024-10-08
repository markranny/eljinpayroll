@include('HR/firstpace')

    <div class="main-panel">
      <nav class="navbar navbar-expand-lg navbar-transparent navbar-absolute fixed-top ">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-minimize">
              <button id="minimizeSidebar" class="btn btn-just-icon btn-white btn-fab btn-round">
                <i class="material-icons text_align-center visible-on-sidebar-regular">more_vert</i>
                <i class="material-icons design_bullet-list-67 visible-on-sidebar-mini">view_list</i>
              </button>
            </div>
            <a class="navbar-brand" href="javascript:;">Change Schedule</a>
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
          @if ($message = Session::get('error'))
          <div class="msg-container" id="errorbtn">
            <div class="alert alert-danger alert-block">
	            <button type="button" class="close" data-dismiss="alert">&nbsp&nbsp&nbsp&nbsp&nbsp ×</button>	
                <strong>{{ $message }}</strong>
            </div>
          </div>
          @endif
          @if ($message = Session::get('exception'))
            <div class="alert alert-danger alert-block">
	            <button type="button" class="close" data-dismiss="alert">&nbsp&nbsp&nbsp&nbsp&nbsp ×</button>	
                <strong>{{ $message }}</strong>
            </div>
          @endif
          @if ($message = Session::get('success'))
          <div class="msg-container" id="successbtn">
            <div class="alert alert-success alert-block">
	            <button type="button" class="close" data-dismiss="alert">&nbsp&nbsp&nbsp&nbsp&nbsp ×</button>	
                <strong>{{ $message }}</strong>
            </div>
        </div>
          @endif
          
          @include('layouts.changeOff') 
            
          </div>
        </div>
      </div>
      
      @include('HR/lastpace')