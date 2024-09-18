<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png"
        href="{{ isset($setting) && $setting->app_logo ? asset('storage/' . $setting->app_logo) : asset('assets/images/logo_gym.png') }}">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../../assets/vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../../assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../../assets/fonts/iconic/css/material-design-iconic-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../../assets/fonts/linearicons-v1.0.0/icon-font.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../../assets/vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../../assets/vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../../assets/vendor/animsition/css/animsition.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../../assets/vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../../assets/vendor/daterangepicker/daterangepicker.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../../assets/vendor/slick/slick.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../../assets/vendor/MagnificPopup/magnific-popup.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../../assets/vendor/perfect-scrollbar/perfect-scrollbar.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="../../assets/css/util.css">
    <link rel="stylesheet" type="text/css" href="../../assets/css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        a {
            text-decoration: none;
        }

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
            padding: 0 15px;
            color: #007BFF;
            font-weight: bold;
            text-decoration: none;
        }

        .main-menu li a {
            color: #000;
            border-radius: 10px;
            padding: 6px 12px;
            text-decoration: none;
        }

        .main-menu li.active a {
            color: #000000;
            border-radius: 10px;
        }

        .main-menu li.active {
            background-color: #FFA500;
            border-radius: 10px;
            padding: 6px 12px;
        }

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

        .link-black:hover,
        .link-black.active {
            color: #FF8C00;
        }

        .main-menu-m {
            background-color: #000;
            color: #fff;
        }

        .contains, .header-v2, .nav-bottom {
            max-width: 576px;
        }

        .nav-bottom {
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            box-shadow: 0 0 8px 0 rgba(0, 0, 0, 0.2);
        }
        
        .active {
            color: #FF8C00;
        }

        /* @media (max-width: 992px) {
            .contains {
                max-width: 100%;
            }
        } */

    </style>



</head>

<body>

    <div class="contains m-auto">
        <header class="header-v2 fixed-top m-auto">
            <div class="wrap-header-mobile">
                <div class="logo-mobile">
                    <img src="{{ isset($setting) && $setting->app_logo ? asset('storage/' . $setting->app_logo) : asset('assets/images/logo_gym.png') }}"
                        alt="logo">
                </div>
                @auth
                    <a href="{{ route('logout') }}" class="link-black me-2"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                @else
                    <a href="{{ route('login') }}" class="link-black me-2">Login</a>
                @endauth
                {{-- @guest
                    <a href="{{ route('login') }}" class="link-black me-2">Login</a>
                @endguest --}}
                {{-- <div class="wrap-icon-header flex-w flex-r-m m-r-15"> --}}
                {{-- <a href="#" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti" data-notify="{{ $cartCount }}">
								<i class="zmdi zmdi-shopping-cart"></i>
							</a> --}}
                {{-- </div> --}}
            </div>
        </header>
        @yield('main')
    </div>
    <div class="nav-bottom fixed-bottom bg-white m-auto text-center">
        <div class="row">
            <div class="nav-bottom-item col-3">
                <a href="{{ route('landing.index') }}" class="{{ request()->routeIs('landing.index') || request()->is('checking') ? 'active' : 'text-dark'}}">
                    <i class="bi bi-house-fill fs-3"></i>
                    <p>Home</p>
                </a>
            </div>
            <div class="nav-bottom-item col-3">
                <a href="{{ route('yourorder.index') }}" class="{{ request()->routeIs('yourorder.index') || request()->is('checkout*') ? 'active' : 'text-dark'}}">
                    <i class="bi bi-cart-fill fs-3"></i>
                    <p>My Order</p>
                </a>
            </div>
            <div class="nav-bottom-item col-3">
                @if($member)
                <a href="{{route('landing.history')}}" class="{{ request()->routeIs('landing.history') || request()->is('history') ? 'active' : 'text-dark'}}">
                    <i class="bi bi-clock-history fs-3"></i>
                    <p>History</p>
                </a>
                @else
                <a href="#product-section" class="{{ request()->routeIs('customer.membership') || request()->is('history') ? 'active' : 'text-dark'}}">
                    <i class="bi bi-person-vcard fs-3"></i>
                    <p>Membership</p>
                </a>
                @endif
            </div>
            <div class="nav-bottom-item col-3">
                <a href="{{ route('landing.profile') }}" class="{{ request()->routeIs('landing.profile') ? 'active' : 'text-dark'}}">
                    <i class="bi bi-person-fill fs-3"></i>
                    <p>Profile</p>
                </a>
            </div>
        </div>
    </div>
    @yield('script')

    <!-- JQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <!--===============================================================================================-->
    <script src="../../assets/vendor/jquery/jquery-3.2.1.min.js"></script>
    <!--===============================================================================================-->
    <script src="../../assets/vendor/animsition/js/animsition.min.js"></script>
    <!--===============================================================================================-->
    <script src="../../assets/vendor/bootstrap/js/popper.js"></script>
    <script src="../../assets/vendor/bootstrap/js/bootstrap.min.js"></script>
    <!--===============================================================================================-->
    <script src="../../assets/vendor/select2/select2.min.js"></script>
    <script>
        $(".js-select2").each(function() {
            $(this).select2({
                minimumResultsForSearch: 20,
                dropdownParent: $(this).next('.dropDownSelect2')
            });
        })
    </script>
    <!--===============================================================================================-->
    <script src="../../assets/vendor/daterangepicker/moment.min.js"></script>
    <script src="../../assets/vendor/daterangepicker/daterangepicker.js"></script>
    <!--===============================================================================================-->
    <script src="../../assets/vendor/slick/slick.min.js"></script>
    <script src="../../assets/js/slick-custom.js"></script>
    <!--===============================================================================================-->
    <script src="../../assets/vendor/parallax100/parallax100.js"></script>
    <script>
        $('.parallax100').parallax100();
    </script>
    <!--===============================================================================================-->
    <script src="../../assets/vendor/MagnificPopup/jquery.magnific-popup.min.js"></script>
    <script>
        $('.gallery-lb').each(function() { // the containers for all your galleries
            $(this).magnificPopup({
                delegate: 'a', // the selector for gallery item
                type: 'image',
                gallery: {
                    enabled: true
                },
                mainClass: 'mfp-fade'
            });
        });
    </script>
    <!--===============================================================================================-->
    <script src="../../assets/vendor/isotope/isotope.pkgd.min.js"></script>
    <!--===============================================================================================-->
    <script src="../../assets/vendor/sweetalert/sweetalert.min.js"></script>

    <script>
        $('.js-addwish-b2').on('click', function(e) {
            e.preventDefault();
        });

        $('.js-addwish-b2').each(function() {
            var nameProduct = $(this).parent().parent().find('.js-name-b2').html();
            $(this).on('click', function() {
                swal(nameProduct, "is added to wishlist !", "success");

                $(this).addClass('js-addedwish-b2');
                $(this).off('click');
            });
        });

        $('.js-addwish-detail').each(function() {
            var nameProduct = $(this).parent().parent().parent().find('.js-name-detail').html();

            $(this).on('click', function() {
                swal(nameProduct, "is added to wishlist !", "success");

                $(this).addClass('js-addedwish-detail');
                $(this).off('click');
            });
        });

        /*---------------------------------------------*/

        $('.js-addcart-detail').each(function() {
            var nameProduct = $(this).parent().parent().parent().parent().find('.js-name-detail').html();
            $(this).on('click', function() {
                swal(nameProduct, "is added to cart !", "success");
            });
        });
    </script>
    <!--===============================================================================================-->
    <script src="../../assets/vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script>
        $('.js-pscroll').each(function() {
            $(this).css('position', 'relative');
            $(this).css('overflow', 'hidden');
            var ps = new PerfectScrollbar(this, {
                wheelSpeed: 1,
                scrollingThreshold: 1000,
                wheelPropagation: false,
            });

            $(window).on('resize', function() {
                ps.update();
            })
        });
    </script>
    <!--===============================================================================================-->
    <script src="../../assets/js/main.js"></script>
</body>

</html>
