@extends('landing.master')
@section('title', isset($setting) ? $setting->app_name . ' - Home' : 'Home')
@section('main')

    <style>
        .card {
            border: none;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .card-header {
            background-color: #ffffff;
            padding: 20px;
        }

        .card-header h3 {
            font-size: 20px;
            margin-bottom: 0;
        }

        .card-header span {
            font-size: 16px;
            color: #6c757d;
        }

        /* Card Footer */
        .card-footer {
            background-color: #ffffff;
            padding: 15px;
            border-top: 1px solid #f1f1f1;
        }

        /* Button Style */
        .boxed-btn3 {
            display: inline-block;
            padding: 12px 25px;
            background-color: #FFA500;
            color: #000;
            border-radius: 30px;
            text-decoration: none;
            font-size: 16px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }

        .boxed-btn3:hover {
            background-color: #000;
            color: #fff;
            transform: scale(1.05);
        }

        .item-slick1 {
            position: relative;
            height: 100vh;
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .text-overlay {
            position: absolute;
            top: 80%;
            left: 50%;
            transform: translate(-60%, -50%);
            color: #fff;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.7);
            background: rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 10px;
            width: 80%;
        }

        .text-overlay h1 {
            font-size: 48px;
            font-weight: bold;
            margin-bottom: 15px;
            letter-spacing: 1px;
            line-height: 1.2;
            animation: fadeInDown 1s ease-in-out;
        }

        .text-overlay p {
            font-size: 20px;
            margin-bottom: 20px;
            animation: fadeInUp 1s ease-in-out;
        }

        /* Animasi */
        @keyframes fadeInDown {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            0% {
                opacity: 0;
            }

            100% {
                opacity: 1;
            }
        }

        @media (max-width: 768px) {
            .item-slick1 {
                height: 50vh;
            }

            .text-overlay {
                text-align: left;
                width: 90%;
                padding: 30px;
            }

            .text-overlay h1 {
                font-size: 40px;
            }

            .text-overlay p {
                font-size: 16px;
                margin-bottom: 15px;
            }
        }

        #product-section {
            padding-bottom: 100px;
        }

        .member-card {
            background-color: #282828;
            border-radius: 15px;
            width: 100%;
            padding: 20px;
            padding-top: 100px;
            color: white;
            font-family: 'Arial', sans-serif;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            position: relative;
        }

        .overlap-group {
            position: relative;
        }

        .logo-gym {
            width: 50px;
        }

        .text-wrapper {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .text-wrapper-2,
        .text-wrapper-3 {
            font-size: 14px;
            font-weight: normal;
            margin-bottom: 8px;
        }

        .text-wrapper-4,
        .text-wrapper-5 {
            font-size: 14px;
            font-weight: normal;
            margin-top: 10px;
        }

        .text-wrapper-4 span,
        .text-wrapper-5 span {
            font-weight: bold;
        }

        .overlap-btn {
            margin-top: 10px;
            background-color: #FF5722;
            border: none;
            padding: 10px 20px;
            color: white;
            font-size: 14px;
            border-radius: 25px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .overlap-btn:hover {
            background-color: #E64A19;
        }

        .modal-content {
            color: white;
        }

        .about-us {
            background-color: #fff;
            padding: 50px 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            text-align: center;
        }

        .about-us h2 {
            font-size: 40px;
            margin-bottom: 20px;
            color: #333;
        }

        .about-us p {
            font-family: 'Open Sans', sans-serif;
            font-size: 18px;
            color: #000;
            line-height: 1.6;
            max-width: 800px;
            margin: 0 auto;
        }
        /* Floating Cart Icon */
        .floating-cart {
            position: fixed;
            bottom: 100px;
            right: 420px;
            background-color: #fff;
            color: white;
            padding: 15px;
            border-radius: 50%;
            box-shadow: 0 3px 2px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            transition: background-color 0.3s ease;
        }

        .floating-cart:hover {
            background-color: #FF5722;
        }

        .floating-cart i {
            font-size: 20px;
            color: #FF5722;
        }
        .floating-cart:hover i {
            color: white;
        }
        @media screen and (max-width: 576px) {
            .floating-cart {
            display: flex;
            position: fixed;
            bottom: 100px;
            right: 20px;
            background-color: #fff;
            color: white;
            padding: 15px;
            border-radius: 50%;
            box-shadow: 0 3px 2px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            transition: background-color 0.3s ease;
            }
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if(session('warning'))
        <script>
            Swal.fire({
                icon: 'warning',
                title: 'Warning',
                text: '{{ session('warning') }}',
                confirmButtonText: 'OK',
                confirmButtonColor: '#3085d6',
            });
        </script>
    @endif

    <div class="animsition mb-5">
        <!-- Slider -->
        @if ($member)
        <div class="member-card">
            <div class="overlap-group">
                <div class="d-flex flex-row justify-content-between">
                    <div class="text-wrapper" style="color: {{ $member->status === 'active' ? 'green' : ($member->status === 'expired' ? 'red' : 'white') }}">
                        @switch($member->status)
                                  @case('active')
                                      Active
                                  @break
                                  @case('expired')
                                      Expired
                                  @break
                                  @case('inactive')
                                      You Got Ban !
                                  @break
                                  @default
                                      Lainnya
                              @endswitch
                    </div>  
                    <img class="logo-gym" src="{{ isset($setting) ? asset('storage/' . $setting->app_logo) : asset('assets/images/logo_gym.png') }}" alt="Gym Logo" />
                    <a href="{{route('landing.history')}}" style="color: white"  >
                        <i class="fa-solid fa-chevron-right "></i>
                    </a>
                    </div> 
                    
                
                </div>
                
                <div class="text-wrapper-2">
                    NAME : 
                    <span title="{{ $member->customer->user->name }}">
                        {{ $member->customer->user->name }}
                    </span>
                </div>
            
                <div class="text-wrapper-3">MEMBER ID : GYM.{{ $member->id }}</div>
            
                @if ($member->status !== 'inactive')
                    <div class="text-wrapper-4">
                        EXPIRED : <span style="color: {{ $member->status === 'active' ? 'green' : ($member->status === 'expired' ? 'red' : 'white') }}">
                        {{ \Carbon\Carbon::parse($member->end_date)->translatedFormat('d/M/Y') }}
                        </span>
                    </div>
                    <div class="d-flex flex-row justify-content-between">
                    <div class="text-wrapper-5 ">
                        Visit Left : <span style="color: {{ $member->status === 'active' ? 'white' : ($member->status === 'expired' ? 'red' : 'green') }}">
                            {{ $member->visit }}
                            @if ($member->visit == 0)
                                <span>visit habis</span>
                            @endif
                        </span>
                    </div>
                    @if ($member->status === 'active')
                    <a href="{{route('getin.index')}}" type="button" class="overlap-btn" >
                        Get In <i class="fa-solid fa-dumbbell"></i>
                    </a>
                    
                    @else
                    @endif
                    </div>
                    
                @endif
            </div>
        </div>
        @else
        <section class="section-slide">
            <div class="wrap-slick1 rs1-slick1">
                <div class="slick1">
                    <div class="item-slick1" style="background-image: url(../../assets/images/banner/banner.png);">
                        <div class="text-overlay">
                            <h1>Transform Your Body, Elevate Your Life</h1>
                            <p>Your Journey to a Stronger You Starts Here</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        @endif

        <section class="about-us">
            <h2>About Us</h2>
            <p>Welcome to our gym! We offer top-notch facilities and expert trainers to help you achieve your fitness goals. Whether you’re interested in a membership, a single visit, or fitness products, we have something for everyone. Join us and take the first step towards a healthier you!</p>
        </section>

        <section class="about-us">
            <h2>Membership</h2>    
        </section>
        <!-- Product -->
        <div id="product-section" class="container mt-5">
            <div class="d-flex justify-content-center flex-wrap">
                <div class="row">
                    @foreach ($products as $dt)
                        <div class="col-lg-12 mb-4">
                            <div class="card text-center shadow-lg w-100">
                                <div class="card-header">
                                    <h3>{{ $dt->product_name }}</h3>
                                    <span class="text-black">Rp.{{ number_format($dt->price) }}</span>
                                </div>
                                <div class="card-body">
                                    <p>{{ $dt->description }}</p>
                                </div>
                                <div class="card-footer">
                                    <form action="{{ route('beforeorder.index') }}" method="GET">
                                        <input type="hidden" name="product_id" value="{{ $dt->id }}">
                                        <input type="hidden" name="product_name" value="{{ $dt->product_name }}">
                                        <input type="hidden" name="description" value="{{ $dt->description }}">
                                        <input type="hidden" name="price" value="{{ $dt->price }}">
                                        <button type="submit" class="boxed-btn3">Join Now</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
        <!-- Floating Cart Icon -->
        <div class="floating-cart">
            <a href="{{ route('cart.index') }}">
                <i class="fa fa-shopping-cart"></i>
            </a>
        </div>
        <!-- Back to top -->
        <div class="btn-back-to-top" id="myBtn">
            <span class="symbol-btn-back-to-top">
                <i class="zmdi zmdi-chevron-up"></i>
            </span>
        </div>
    @endsection