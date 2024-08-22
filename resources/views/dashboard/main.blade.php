<main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <h6 class="font-weight-bolder mb-0">@yield('page-title')</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div class="ms-md-auto pe-md-3 d-flex align-items-center">
          </div>
          <ul class="navbar-nav  justify-content-end">
            
            @auth
            <li class="nav-item d-flex align-items-center">
              <a href="{{route('dashboard.profil')}}" class="nav-link text-body font-weight-bold px-0">
                <span>
                  {{ Auth::user()->role }} - {{ Auth::user()->name }}  
                </span>
                <style>
                  a:hove span {
                    color: #ff8800
                  }
                </style>
              </a>
              <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="nav-link text-body font-weight-bold px-0 ms-4">
                <i class="fa fa-sign-out me-1"></i>
                <span class="d-sm-inline d-none">Sign Out</span>
                <style>
                    a:hover .fa-sign-out {
                        color: #D81B60; 
                    }
                    a:hover span {
                        color: #D81B60; 
                    }
                </style>
              </a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
              </form>
            </li>
            @else
            <li class="nav-item d-flex align-items-center">
              <a href="{{ route('login') }}" class="nav-link text-body font-weight-bold px-0">
                <i class="fa fa-user me-sm-1"></i>
                <span class="d-sm-inline d-none">Sign In</span>
              </a>
            </li>
            @endauth            
          </ul>
          <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                </div>
              </a>
            </li>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->

    