@extends('landing.master')
@section('main')

<body class="animsition">
    
    <!-- Product Detail -->
    <section class="sec-product-detail bg0 p-t-65 p-b-60">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-7 p-b-30">
                    <div class="p-l-25 p-r-30 p-lr-0-lg">
                        <div class="wrap-slick3 flex-sb flex-w">
                            <div class="wrap-slick3-dots"></div>
                            <div class="wrap-slick3-arrows flex-sb-m flex-w"></div>

                            <div class="slick3 gallery-lb">
                                    <div class="item-slick3" data-thumb="{{ asset('storage/' . $complement->image) }}">
                                        <div class="wrap-pic-w pos-relative">
                                            <img src="{{ asset('storage/' . $complement->image) }}" alt="IMG-PRODUCT">
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-5 p-b-30">
                    <div class="p-r-50 p-t-5 p-lr-0-lg">
                        <h4 class="mtext-105 cl2 js-name-detail p-b-14">
                            {{ $complement->name }}
                        </h4>
                        

                        <span class="stext-105 cl3">
                                Rp. {{ number_format($complement->price) }}
                        </span>
                        <br>
                        <span class="stext-100 cl3">
                                Stok : {{ ($complement->stok) }}
                        </span>

                        <p class="stext-102 cl3 p-t-23">
                            {{ $complement->description }}.
                        </p>

                        <!--  -->
                        <div class="p-t-33">

                            <div class="flex-w flex-r-m p-b-10">
                                <div class="size-204 flex-w flex-m respon6-next">
                                    <form action="{{ route('cart.add', $complement->id) }}" method="POST">
                                        @csrf
                                        <div class="wrap-num-product flex-w m-r-20 m-tb-10">
                                            <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                                <i class="fs-16 zmdi zmdi-minus"></i>
                                            </div>
                                    
                                            <input class="mtext-104 cl3 txt-center num-product" type="number" name="quantity" value="1" min="1" max="{{ $complement->stok }}">
                                    
                                            <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                                <i class="fs-16 zmdi zmdi-plus"></i>
                                            </div>
                                        </div>
                                        <button type="submit" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn3 p-lr-15 trans-04 js-addcart-detail">
                                            Add to Cart
                                        </button>
                                    </form>
                                </div>
                            </div>  
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>




<div class="btn-back-to-top" id="myBtn">
        <span class="symbol-btn-back-to-top">
            <i class="zmdi zmdi-chevron-up"></i>
        </span>
    </div>


</body>
@endsection
