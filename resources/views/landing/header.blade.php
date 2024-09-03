<style>
    .wrap-header-mobile {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
    }

    .btn-show-menu-mobile {
        display: flex;
        align-items: center;
        position: relative;
    }

    .btn-auth-mobile {
        display: none;
        margin-left: auto;
        /* Align to the right */
        padding: 0 15px;
        color: #007BFF;
        font-weight: bold;
        text-decoration: none;
    }
    
/* Gaya default untuk menu */
.main-menu li a {
    color: #000;
    border-radius: 10px;
    padding: 6px 12px;
    text-decoration: none;
}

/* Gaya untuk menu yang aktif */
.main-menu li.active a {
    color: #000000;
    border-radius: 10px;
}

/* Jika ingin menggunakan background */
.main-menu li.active {
    background-color: #FFA500;
    border-radius: 10px;
    padding: 6px 12px;
}

/* Gaya untuk menu mobile */
.main-menu-m li.active a {
    color: #000000;
    border-radius: 10px;
    display: block;
}

.link-black {
    color: black;
    text-decoration: none;
    transition: color 0.3s ease;
}

.link-black:hover, .link-black.active{
    color: #FF8C00; 
}


.main-menu-m {
    background-color: #000;
    color: #fff;
}

/* Adjust position and visibility for mobile */
@media (max-width: 768px) {
    .btn-auth-mobile {
        display: block;
        padding-right: 15px;
    }

    @media (max-width: 768px) {
        .btn-auth-mobile {
            display: block;
            padding-right: 15px;
            /* Align to the right */
        }
        .menu-mobile {
            display: none;
        }
    }
    .main-menu-m li a {
        font-size: 16px; /* Atur ukuran teks untuk mobile */
    }
}
    @media (min-width: 769px) {
        .btn-show-menu-mobile,
        .wrap-header-mobile {
            display: none;
        }
    }
</style>

<header class="header-v2">
    <!-- Header desktop -->
    <div class="container-menu-desktop trans-03">
        <div class="wrap-menu-desktop">
            <nav class="limiter-menu-desktop p-l-45">
                <!-- Menu desktop -->
                <div class="menu-desktop">
                    <ul class="main-menu">
                        <li>
                            <img src="{{ isset($setting) && $setting->app_logo ? asset('storage/' . $setting->app_logo) : asset('assets/images/logo_gym.png') }}" alt="logo" width="50px" height="50px">
                        </li>
                        <li class="{{ request()->routeIs('landing.index') ? 'active' : ''}}">
                            <a href="{{ route('landing.index') }}">Home</a>
                        </li>
                        <li class="{{ request()->routeIs('yourorder.index') ? 'active' : '' }}">
                            <a href="{{ route('yourorder.index') }}">My Order</a>
                        </li>
                        <li class="{{ request()->routeIs('customer.membership') ? 'active' : '' }}">
                            @auth
                                @if($member)
                                    <a href="{{ route('customer.membership', ['id' => $member->id]) }}">View Membership</a>
                                @endif
                            @endauth
                        </li>
                    </ul>
                </div>


                <div class="wrap-icon-header flex-w flex-r-m h-full">
                @auth
                    @if(auth()->user()->role == 'admin')
                    <a href="{{ route('dashboard.profile') }}" class="flex-c-m trans-04 p-lr-25 link-black">
                        {{ Auth::user()->name }}
                    </a>
                    <a href="{{ route('dashboard.index') }}" class="flex-c-m trans-04 p-lr-25 link-black text-capitalize">
                        dashboard
                    </a>
                    <a href="{{ route('logout') }}" class="flex-c-m trans-04 p-lr-25 link-black"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                    @elseif(auth()->user()->role == 'cashier')
                        <a href="{{ route('cashier.profile') }}" class="flex-c-m trans-04 p-lr-25 link-black">
                            {{ Auth::user()->name }}
                        </a>
                        <a href="{{ route('cashier.index') }}" class="flex-c-m trans-04 p-lr-25 link-black text-capitalize">
                            {{ Auth::user()->role }}
                        </a>
                        <a href="{{ route('logout') }}" class="flex-c-m trans-04 p-lr-25 link-black"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                    @else
                        <a href="{{ route('landing.profile') }}" class="flex-c-m trans-04 p-lr-25 link-black {{ request()->routeIs('landing.profile') ? 'active' : '' }}">
                            {{ Auth::user()->name }}
                        </a>
                        <a href="{{ route('logout') }}" class="flex-c-m trans-04 p-lr-25 link-black"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                    @endif

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                @else
                    <a href="{{ route('login') }}" class="flex-c-m trans-04 p-lr-25 link-black {{ request()->routeIs('login') ? 'active' : '' }}">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="flex-c-m trans-04 p-lr-25 link-black {{ request()->routeIs('register') ? 'active' : '' }}">
                        Register
                    </a>
                @endauth
                </div>
            </nav>
        </div>
    </div>

    <!-- Header Mobile -->
    <div class="wrap-header-mobile">
        <div class="logo-mobile">
            <img src="{{ isset($setting) && $setting->app_logo ? asset('storage/' . $setting->app_logo) : asset('assets/images/logo_gym.png') }}" alt="logo">
        </div>

        @auth
            <!-- Hide logout button on mobile -->
        @else
            <a href="{{ route('login') }}" class="btn-auth-mobile link-black">Login</a>
        @endauth
        <!-- Button show menu -->
        <div class="btn-show-menu-mobile hamburger hamburger--squeeze">
            <span class="hamburger-box">
                <span class="hamburger-inner"></span>
            </span>
        </div>
    </div>

    <!-- Menu Mobile -->
    <div class="menu-mobile">
        <ul class="main-menu-m">
            @auth
            <li>
                <a href="{{ route('landing.profile') }}">
                    {{ Auth::user()->name }}
                </a>
            </li>
            @else
            
            @endauth
            <li>
                <a href="{{ route('landing.index') }}">Home</a>
            </li>
            <li>
                <a href="{{ route('yourorder.index') }}">My Order</a>
            </li>
            @auth
                @if($member)
                    <li>
                        <a href="{{ route('customer.membership', ['id' => $member->id]) }}">View Membership</a>
                    </li>
                @else
                @endif
            @endauth
        </ul>
    </div>
</header>