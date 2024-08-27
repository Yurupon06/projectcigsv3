@extends('landing.master')
@section('title', 'Home')
@section('main')
    @include('landing.header')

<style>
    .boxed-btn3 {
        display: inline-block;
        padding: 10px 20px;
        background-color: #842cff;
        color: #fff;
        border-radius: 5px;
        text-decoration: none;
        font-size: 14px; /* Ensure button text is readable */
        transition: background-color 0.3s ease;
    }
    .boxed-btn3:hover {
        background-color: #6f00b1; /* Darker shade on hover */
    }

    html {
        scroll-behavior: smooth;
    }

    /* Ensure slider is full width and adjusts on mobile */
    .section-slide {
        width: 100%;
        overflow: hidden;
    }
    .wrap-slick1 {
        width: 100%;
    }
    ..slick1 .item-slick1 {
        background-size: cover;
        background-position: center;
        width: 100%;
        height: 500px; /* Ubah sesuai kebutuhan */
    }


    /* Responsive adjustments for product cards */
    .card {
        border: 1px solid #ddd;
        border-radius: 8px;
        margin-bottom: 20px;
        transition: box-shadow 0.3s ease;
    }
    .card:hover {
        box-shadow: 0 4px 8px rgba(0,0,0,0.2);
    }
    .card-header, .card-body, .card-footer {
        padding: 15px;
    }
    .card-header h3 {
        font-size: 18px;
    }
    .card-footer {
        text-align: center;
    }

    @media (max-width: 768px) {
        .card-header h3 {
            font-size: 16px; 
        }
        .card-body ul {
            font-size: 14px; 
        }
        .boxed-btn3 {
            padding: 10px 15px; 
            font-size: 12px; 
        }
    }

    @media (max-width: 576px) {
        .card {
            width: 100%; 
            margin-bottom: 20px;
        }
        .card-header h3 {
            font-size: 14px; 
        }
        .card-body ul {
            font-size: 12px; 
        }
        .boxed-btn3 {
            padding: 12px 10px; 
        }
    }
</style>

	<div class="animsition">
    <!-- Slider -->
    <section class="section-slide">
        <div class="wrap-slick1 rs1-slick1">
            <div class="slick1">
                <div class="item-slick1" style="background-image: url(../../assets/images/banner/banner.png);">
                </div>
            </div>
        </div>
    </section>

    <!-- Product -->
    <div id="product-section" class="container mt-5">
        <div class="d-flex justify-content-center flex-wrap">
            @foreach ($products as $dt)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card text-center mx-auto">
                    <div class="card-header">
                        <h3>{{$dt->product_name}}</h3>
                        <span>Rp.{{$dt->price}}</span>
                    </div>
                    <div class="card-body">
                        <ul>
                            <li>{{$dt->description}}</li>
                        </ul>
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

    <!-- Back to top -->
    <div class="btn-back-to-top" id="myBtn">
        <span class="symbol-btn-back-to-top">
            <i class="zmdi zmdi-chevron-up"></i>
        </span>
    </div>
@endsection

