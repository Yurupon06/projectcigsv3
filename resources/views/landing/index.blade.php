@extends('landing.master')
@section('title', 'Home')
@section('main')
    @include('landing.header')

<style>
    .card {
        border: none; 
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px); 
        box-shadow: 0 8px 16px rgba(0,0,0,0.2);
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
        text-align: justify;
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

</style>

	<div class="animsition">
    <!-- Slider -->
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

    <!-- Product -->
    <div id="product-section" class="container mt-5">
        <div class="d-flex justify-content-center flex-wrap">
            @foreach ($products as $dt)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card text-center mx-auto">
                    <div class="card-header">
                        <h3>{{$dt->product_name}}</h3>
                        <span class="text-black">Rp.{{number_format($dt->price)}}</span>
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

