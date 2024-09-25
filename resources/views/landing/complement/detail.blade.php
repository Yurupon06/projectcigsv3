@extends('landing.master')
@section('title', isset($setting) ? $setting->app_name . ' - Detail Complement' : 'Detail Complement')
@section('main')

<body class="animsition">

    <!-- Product Detail Section -->
    <section class="sec-product-detail bg0 p-t-65 p-b-60">
        <div class="container">
            <div class="row">
                <!-- Image Section -->
                <div class="col-md-6 col-lg-7 p-b-30">
                    <div class="p-l-25 p-r-30 p-lr-0-lg">
                        <div class="wrap-pic-w pos-relative" style="overflow: hidden;">
                            <img src="{{ asset('storage/' . $complement->image) }}" alt="IMG-PRODUCT" class="img-fluid" style="border-radius: 10px;">
                        </div>
                    </div>
                </div>

                <!-- Product Details Section -->
                <div class="col-md-6 col-lg-5 p-b-30">
                    <div class="p-r-50 p-t-5 p-lr-0-lg ms-2">
                        <!-- Product Name -->
                        <h4 class="mtext-105 cl2 js-name-detail p-b-14" style="font-size: 32px; font-weight: bold; color: #333;">
                            {{ $complement->name }}
                        </h4>
                        
                        <!-- Product Price -->
                        <span class="stext-105 cl3" style="font-size: 26px; color: #ffa500;">
                            Rp. {{ number_format($complement->price) }}
                        </span><br>

                        <!-- Product Stock -->
                        <span class="stext-100 cl3" style="font-size: 16px; color: #666;">
                            Stok: {{ $complement->stok }}
                        </span>

                        <!-- Product Description -->
                        <p class="stext-102 cl3 p-t-23" style="font-size: 16px; line-height: 1.8; color: #777;">
                            {{ $complement->description }}
                        </p>

                        <!-- Add to Cart Section -->
                        <div class="d-flex align-items-center justify-content-end pt-2">
                            <form action="{{ route('cart.add', $complement->id) }}" method="POST">
                                @csrf
                                <div class="wrap-num-product flex-w m-r-20 m-tb-10" style="border-radius: 10px; overflow: hidden;">
                                    <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                        <i class=" fs-16 zmdi zmdi-minus"></i>
                                    </div>
                            
                                    <input class="mtext-104 cl3 txt-center num-product" type="number" name="quantity" value="1" min="1" max="{{ $complement->stok }}">
                            
                                    <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                        <i class="fs-16 zmdi zmdi-plus"></i>
                                    </div>
                                </div>

                                <!-- Add to Cart Button -->
                                <button type="submit" class="addcart flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn3 p-lr-15 trans-04 js-addcart-detail">
                                    Add to Cart
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Back to Top Button -->
    <div class="btn-back-to-top" id="myBtn">
        <span class="symbol-btn-back-to-top">
            <i class="zmdi zmdi-chevron-up"></i>
        </span>
    </div>

    <style>
        /* Custom CSS for responsive adjustments */
        .wrap-pic-w {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
        }
        
        .btn-num-product-down,
        .btn-num-product-up {
            border-radius: 5px;
        }

        .btn-num-product-down:hover {
            background-color: #ffa500;
            color: #000;
        }
        
        .btn-num-product-up:hover {
            background-color: #ffa500;
            color: #000;
        }

        .addcart {
            background-color: #000;
            color: #fff;
            border-radius: 5px;
            padding: 5px;
            margin: 5px;
        }

        .addcart:hover {
            background-color: #ffa500;
            color: #fff;
        }

        @media (max-width: 767.98px) {
            .size-204 {
                width: 100%;
            }

            .p-r-50 {
                padding-right: 15px;
            }

            .slick3 img {
                max-width: 100%;
                height: auto;
            }
        }
    </style>
</body>
@endsection
