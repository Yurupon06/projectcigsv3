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
                        {{-- <a href="{{route('cart.index')}}" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti" data-notify="{{ $cartCount }}">
							<i class="zmdi zmdi-shopping-cart"></i>
						</a> --}}
                    @auth
                        @if(auth()->user()->role == 'cashier')
                            <a href="{{ route('cashier.profile') }}" class="flex-c-m trans-04 p-lr-25 link-black {{ request()->routeIs('landing.profile') ? 'active' : '' }}">
                                {{ Auth::user()->name }}
                            </a>
                            <a href="{{ route('cashier.index') }}" class="flex-c-m trans-04 p-lr-25 link-black {{ request()->routeIs('cashier.index') ? 'active' : '' }}">
                                {{ Auth::user()->role }}
                            </a>
                            <a href="{{ route('logout') }}" class="flex-c-m trans-04 p-lr-25 link-black"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                        @elseif(auth()->user()->role == 'admin')
                            <a href="{{ route('dashboard.profile') }}" class="flex-c-m trans-04 p-lr-25 link-black {{ request()->routeIs('landing.profile') ? 'active' : '' }}">
                                {{ Auth::user()->name }}
                            </a>
                            <a href="{{ route('dashboard.index') }}" class="flex-c-m trans-04 p-lr-25 link-black {{ request()->routeIs('cashier.index') ? 'active' : '' }}">
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
                    <a href="{{ route('login') }}" class="flex-c-m trans-04 p-lr-25 link-black">
                        Login
                    </a>
                    <a href="{{ route('register') }}" class="flex-c-m trans-04 p-lr-25 link-black">
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
            <div class="wrap-icon-header flex-w flex-r-m m-r-15">
				{{-- <a href="#" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti" data-notify="{{ $cartCount }}">
					<i class="zmdi zmdi-shopping-cart"></i>
				</a> --}}
			</div>
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