<style>
    body {
        font-family: 'Poppins', sans-serif;
    }

    .bg-gradient-dark {
        background: linear-gradient(45deg, #000000, #3c3c3c);
    }

    .bg-gradient-primary {
        background: linear-gradient(45deg, #ff4b2b, #ff1c1c);
    }

    .bg-gradient-success {
        background: linear-gradient(45deg, #28a745, #218838);
    }

    .bg-gradient-info {
        background: linear-gradient(45deg, #17a2b8, #117a8b);
    }

    .text-white {
        color: #ffffff !important;
    }

    .nav-link.active {
        background-color: #ff4b2b;
        border-radius: 0.375rem;
    }

    .sidenav .nav-link {
        border-radius: 0.375rem;
        padding: 1rem;
        font-family: 'Poppins', sans-serif; 
        font-weight: 400; 
    }

    .sidenav-header {
        padding: 1rem;
        font-family: 'Poppins', sans-serif; 
        font-weight: 600; 
    }

    .sidenav .nav-item .nav-link {
        color: #ffffff;
        font-weight: 400;
    }

    .sidenav .nav-item .nav-link:hover {
        background-color: #ff6f00; 
        border-radius: 0.375rem;
    }

    .sidenav .nav-link .material-icons {
        font-size: 1.5rem;
    }

    .sidenav .nav-link-text {
        margin-left: 0.5rem;
        font-family: 'Poppins', sans-serif;
    }

    .horizontal.light {
        border-color: #ffffff;
    }

    .icon {
            font-size: 2rem;
            color: #ffffff;
            border-radius: 50%;
            padding: 0.5rem;
            margin-top: -1.5rem;
        }
</style>



<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gradient-dark" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="">
        <span class="ms-1 font-weight-bold text-white">CASHIER</span>
      </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link text-white {{ request()->is('cashier') ? 'active' : '' }}" href="{{route('cashier.index')}}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">store</i>
            </div>
            <span class="nav-link-text ms-1">Cashier</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white {{ request()->is('cashier/order') ? 'active' : '' }}" href="{{ route('cashier.order') }}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">add_shopping_cart</i>
            </div>
            <span class="nav-link-text ms-1">Add Order</span>
          </a>
        </li>
        <li class="nav-item">
            <a class="nav-link text-white {{ request()->is('cashier/payment') ? 'active' : '' }}" href="{{ route('cashier.payment') }}">
              <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                <i class="material-icons opacity-10">payments</i>
              </div>
              <span class="nav-link-text ms-1">Payment</span>
            </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white {{ request()->is('membercashier') ? 'active' : '' }}" href="{{ route('membercashier.membercash') }}">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">groups</i>
            </div>
            <span class="nav-link-text ms-1">Member</span>
          </a>
        </li>
        
      </ul>
    </div>
  </aside>