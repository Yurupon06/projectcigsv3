<main class="main-content position-relative max-height-vh-100 h-100">
    <style>
        body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        .navbar-main {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            width: 100%;
            z-index: 1030;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand img {
            height: 45px;
            width: auto;
        }

        .navbar-title {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 1rem;
        }

        .menu-mobile {
            display: none;
        }

        /* Gaya untuk menu mobile */
        .main-menu-m {
            background-color: #fff;
            color: #000;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .main-menu-m li a {
            color: #000;
            text-decoration: none;
            display: block;
            padding: 5px;
        }

        /* Tampilan menu untuk layar besar (desktop) */
        @media (min-width: 992px) {
            .navbar-nav-desktop {
                display: flex;
                justify-content: flex-end;
            }

            .navbar-nav-desktop .nav-item {
                margin-left: 1rem;
            }

            /* Sembunyikan menu hamburger di desktop */
            .hamburger {
                display: none;
            }

            .menu-mobile {
                display: none !important;
            }

            .main-menu-m {
                display: none !important;
            }
        }

        /* Menu mobile */
        @media (max-width: 992px) {
            .navbar-nav-desktop {
                display: none;
            }

            .hamburger {
                display: block;
                cursor: pointer;
            }
        }
    </style>

    <!-- Navbar -->
    <nav class="navbar navbar-main navbar-expand-lg px-0 shadow-none d-flex flex-column justify-content-center" id="navbarBlur" data-scroll="true">
        <div class="container-fluid">
            <div class="navbar-title">
                <a class="navbar-brand" href="#">
                    <img src="{{ isset($setting) && $setting->app_logo ? asset('storage/' . $setting->app_logo) : asset('assets/images/logo_gym.png') }}" alt="logo" class="img-fluid">
                </a>
            </div>

            <!-- Tombol hamburger untuk mobile -->
            <div class="btn-show-menu-mobile hamburger hamburger--squeeze">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </div>

            <!-- Menu di desktop -->
            <div class="navbar-nav-desktop">
                <ul class="navbar-nav d-flex align-items-center">
                    <li class="nav-item">
                        <a href="{{ route('landing.index') }}" class="nav-link text-black font-weight-bold px-3">HOME</a>
                    </li>
                    @guest
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="nav-link text-black font-weight-bold px-3">LOGIN</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('register') }}" class="nav-link text-black font-weight-bold px-3">REGISTER</a>
                    </li>
                    @endguest
                </ul>
            </div>
        </div>

        <!-- Menu mobile -->
        <div class="menu-mobile">
            <ul class="main-menu-m d-flex flex-column align-items-center ps-0">
                <li>
                    <a href="{{ route('landing.index') }}">HOME</a>
                </li>
                <li>
                    <a href="{{ route('login') }}">LOGIN</a>
                </li>
                <li>
                    <a href="{{ route('register') }}">REGISTER</a>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</main>