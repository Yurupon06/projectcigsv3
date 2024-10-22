@extends('landing.home.master')
@section('title', isset($setting) ? $setting->app_name . ' - Home' : 'Home')
@section('main')
    @include('landing.home.main')

    <style>
        .item-slick1 {
            height: 90vh; 
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .text-overlay {
            position: absolute;
            top: 60%;
            left: 38%;
            transform: translate(-50%, -50%);
            color: white;
            text-align: left;
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
            font-size: 15px;
            margin-bottom: 20px;
            animation: fadeInUp 1s ease-in-out;
        }

        /* Animasi */
        @keyframes fadeInDown {
            0% {
                opacity: 0;
                transform: translateX(-20px);
            }
            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes fadeInUp {
            0% {
                opacity: 0;
                transform: translateX(20px);
            }
            100% {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: {{ isset($landingSetting->banner_button_bg_color) ? $landingSetting->banner_button_bg_color: '#FFA500' }};
            color: #000;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #FF8C00;
        }

        /* Card Styles */
        .card-container {
            background-color: #fff;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            padding: 50px 20px;
            gap: 20px;
        }

        .card {
            position: relative; 
            flex: 1;
            background: #fff;
            border-radius: 0;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease;
            max-width: calc(33.333% - 20px);
        }

        .card:hover {
            transform: scale(1.05);
        }

        .card img {
            width: 100%;
            height: 100%;
            object-fit: cover; 
            display: block;
        }

        .card-content {
            position: absolute;
            bottom: 20px; 
            left: 20px;
            color: #fff;
            text-align: left;
            z-index: 10; 
            background-color: rgba(0, 0, 0, 0.5); 
            padding: 10px;
            border-radius: 5px; 
        }

        .card h3, .card p, .card a {
            margin: 0;
            color: #fff;
        }

        .card h3 {
            margin-bottom: 15px;
            color: {{ isset($landingSetting->product_h1_color_1) ? $landingSetting->product_h1_color_1: '#fff' }};
        }

        .card p {
            color: {{ isset($landingSetting->product_p_color_1) ? $landingSetting->product_p_color_1: '#fff' }}; 
        }

        .card a {
            color: {{ isset($landingSetting->product_link_color_1) ? $landingSetting->product_link_color_1: '#FFA500' }};
            text-decoration: underline;
        }

        .card a:hover {
            color: #FF8C00;
        }

        .card {
            height: 300px;
        }

        /* About Us Section */
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
            color: {{ isset($landingSetting->about_us_text_color) ? $landingSetting->about_us_text_color: '#000' }};
            line-height: 1.6;
            max-width: 800px;
            margin: 0 auto;
        }

        .about-us img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin-top: 30px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .text-overlay {
                position: absolute;
                top: 60%;
                left: 40%;
                transform: translate(-50%, -50%);
            }
            .text-overlay h1 {
                font-size: 28px;
            }

            .text-overlay p {
                font-size: 20px;
            }
            .about-us {
                padding: 30px 10px;
            }

            .about-us h2 {
                font-size: 32px;
            }

            .about-us p {
                font-size: 16px;
            }

            .card-container {
                padding: 30px 10px;
            }

            .card {
                max-width: 100%;
                flex: 1 1 100%;
            }
        }

        .banner_h1_color {
            color: {{ isset($landingSetting->banner_h1_color) ? $landingSetting->banner_h1_color: '#fff' }};
        }
        .banner_p_color {
            color: {{ isset($landingSetting->banner_p_color) ? $landingSetting->banner_p_color: '#fff' }};
        }
        .banner_button_color {
            color: {{ isset($landingSetting->banner_button_color) ? $landingSetting->banner_button_color: '#000' }};
        }
    </style>

    <div class="animsition mb-5">
        <!-- Slider -->
        <section class="section-slide">
            <div class="wrap-slick1 rs1-slick1">
                <div class="slick1">
                    <div class="item-slick1" style="background-image: url('{{ isset($landingSetting) ? asset('storage/' . $landingSetting->banner_image) : asset('assets/images/banner/banner.png') }}');">
                        <div class="text-overlay">
                        <h1 class="banner_h1_color">{{ isset($landingSetting->banner_h1_text) ? $landingSetting->banner_h1_text : 'Join Our Gym Membership Today!' }}</h1>

                        <p class="banner_p_color">{{ isset($landingSetting->banner_p_text) ? $landingSetting->banner_p_text : 'Start your journey to a stronger, healthier you with our special membership offers!' }}</p>

                            <a href="{{ route('landing.index') }}" class="btn fw-bold banner_button_color"> {{ isset($landingSetting->banner_button_text) ? $landingSetting->banner_button_text : 'Get Started' }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- About Us Section -->
        <section class="about-us">
            <h2>About Us</h2>
            <p>{{ isset($landingSetting->about_us_text) ? $landingSetting->about_us_text : 'Welcome to our gym! We offer top-notch facilities and expert trainers to help you achieve your fitness goals. Whether you’re interested in a membership, a single visit, or fitness products, we have something for everyone. Join us and take the first step towards a healthier you!' }}</p>
        </section>

        <!-- Cards Section -->
        <section class="card-container">
            <!-- Membership Card -->
            <div class="card">
                <img src="{{ isset($landingSetting) ? asset('storage/' . $landingSetting->product_image_1) : asset('assets/images/banner/banner2.png') }}" alt="Membership Image">
                <div class="card-content">
                    <h3>{{ isset($landingSetting->product_h1_text_1) ? $landingSetting->product_h1_text_1 : 'Exclusive Membership' }}</h3>
                    <p>{{ isset($landingSetting->product_p_text_1) ? $landingSetting->product_p_text_1 : 'Get unlimited access to our gym with special membership plans. Enjoy lower rates and personalized training.' }}</p>
                    <a href="{{ route('landing.index') }}">{{ isset($landingSetting->product_link_1) ? $landingSetting->product_link_1 : 'Explore Membership' }}</a>

                </div>
            </div>

            <!-- Single Visit Card -->
            <div class="card">
                <img src="{{ isset($landingSetting) ? asset('storage/' . $landingSetting->product_image_2) : asset('assets/images/banner/bradcam_1.png') }}" alt="Single Visit Image">
                <div class="card-content">
                    <h3>{{ isset($landingSetting->product_h1_text_2) ? $landingSetting->product_h1_text_2 : 'Single Visit' }}</h3>
                    <p>{{ isset($landingSetting->product_p_text_2) ? $landingSetting->product_p_text_2 : 'Purchase a one-time pass for a days access to our gym. Ideal for trying us out without commitment.' }}</p>
                    <a href="{{ route('landing.index') }}">{{ isset($landingSetting->product_link_2) ? $landingSetting->product_link_2 : 'Get Single Pass' }}</a>

                </div>
            </div>

            <!-- Product Card -->
            <div class="card">
                <img src="{{ isset($landingSetting) ? asset('storage/' . $landingSetting->product_image_3) : asset('assets/images/banner/complement.jpg') }}" alt="Products Image">
                <div class="card-content">
                    <h3>{{ isset($landingSetting->product_h1_text_3) ? $landingSetting->product_h1_text_3 : 'Buy Products' }}</h3>
                    <p>{{ isset($landingSetting->product_p_text_3) ? $landingSetting->product_p_text_3 : 'Explore our fitness products including supplements, gear, and apparel to enhance your workouts.' }}</p>
                    <a href="{{ route('landing.index') }}">{{ isset($landingSetting->product_link_3) ? $landingSetting->product_link_3 : 'Shop Now' }}</a>

                </div>
            </div>
        </section>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if (Session::has('success'))
            {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ Session::get('success') }}',
                })
            }
        @endif
    </script>
@endsection
