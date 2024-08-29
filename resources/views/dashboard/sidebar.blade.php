<style>
    body {
        font-family: 'Poppins', sans-serif;
    }

    .bg-gradient-dark {
        backgr  ound: linear-gradient(45deg, #000000, #3c3c3c);
    }

    .bg-gradient-primary {
        background: linear-gradient(45deg, #2bf8ff, #1c60ff);
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
      <img src="{{ isset($setting) && $setting->app_logo ? asset('storage/' . $setting->app_logo) : asset('assets/images/logo_gym.png') }}" alt="logo" height="80px">
      <span class="ms-1 font-weight-bold text-white">{{ isset ($setting) ? $setting->app_name : 'Faybaal GYM' }}</span>
    </a>
  </div>
  <hr class="horizontal light mt-0 mb-2">
  <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link text-white {{ request()->is('dashboard') ? 'active' : '' }}" href="dashboard">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">dashboard</i>
          </div>
          <span class="nav-link-text ms-1">Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white {{ request()->is('productcategories') ? 'active' : '' }}" href="{{ route('productcategories.index') }}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">category</i>
          </div>
          <span class="nav-link-text ms-1">Product Category</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white {{ request()->is('product') ? 'active' : '' }}" href="{{ route('product.index') }}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">inventory_2</i>
          </div>
          <span class="nav-link-text ms-1">Product</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white {{ request()->is('member') ? 'active' : '' }}" href="{{ route('member.index') }}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">groups</i>
          </div>
          <span class="nav-link-text ms-1">Member</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white {{ request()->is('order') ? 'active' : '' }}" href="{{ route('order.index') }}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">receipt_long</i>
          </div>
          <span class="nav-link-text ms-1">Order</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white {{ request()->is('payment') ? 'active' : '' }}" href="{{ route('payment.index') }}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">payments</i>
          </div>
          <span class="nav-link-text ms-1">Payment</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white {{ request()->is('user') ? 'active' : '' }}" href="{{ route('user.index') }}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">person</i>
          </div>
          <span class="nav-link-text ms-1">User</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white {{ request()->is('customer') ? 'active' : '' }}" href="{{ route('customer.index') }}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">person</i>
          </div>
          <span class="nav-link-text ms-1">Customer</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link text-white {{ request()->is('application-setting') ? 'active' : '' }}" href="{{ route('application-setting.index') }}">
          <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
            <i class="material-icons opacity-10">settings</i>
          </div>
          <span class="nav-link-text ms-1">App Setting</span>
        </a>
      </li>
    </ul>
  </div>
</aside>
