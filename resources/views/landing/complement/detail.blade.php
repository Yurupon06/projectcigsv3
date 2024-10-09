@extends('landing.master')
@section('title', isset($setting) ? $setting->app_name . ' - Detail Complement' : 'Detail Complement')
@section('main')

    <body class="animsition">

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

            .disable-cart {
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

            .plus:hover,
            .minus:hover {
                background-color: #ffa500;
                color: #fff;
            }

            .out-of-stock {
            opacity: 0.5;
            }

            .out-of-stock-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            }
        </style>

        <!-- Product Detail Section -->
        <section class="sec-product-detail bg0 p-t-80 p-b-60">
            <div class="container">
                <div class="row">
                    <!-- Image Section -->
                    <div class="col-6 p-b-30">
                        <div class="p-l-25 p-r-30 p-lr-0-lg">
                            <div class="wrap-pic-w pos-relative" style="overflow: hidden;">
                                <img src="{{ asset('storage/' . $complement->image) }}" alt="IMG-PRODUCT" class="img-fluid"
                                style="border-radius: 10px;">
                                @if ($complement->stok == 0)
                                <h1 class="out-of-stock-overlay">
                                    <span class="badge bg-danger">Out of Stock</span>
                                </h1>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Product Details Section -->
                    <div class="col-6 p-b-30">
                        <div class="p-r-50 p-t-5 p-lr-0-lg ms-2">
                            <!-- Product Name -->
                            <h4 class="mtext-105 cl2 js-name-detail"
                                style="font-size: 32px; font-weight: bold; color: #333;">
                                {{ $complement->name }}
                            </h4>

                            <!-- Product Price -->
                            <span class="stext-105 cl3" style="font-size: 26px; color: #ffa500;">
                                Rp. {{ number_format($complement->price) }}
                            </span><br>

                            <!-- Product Stock -->
                            <span class="stext-100 cl3" style="font-size: 16px; color: #666;">
                                Stok: <span class="">{{ $complement->stok ?? 0 }}</span>
                            </span>

                            <!-- Product Description -->
                            <p class="stext-102 cl3 mb-0" style="font-size: 16px;color: #777;">
                                {{ $complement->description }}
                            </p>

                            <!-- Add to Cart Section -->
                            <div class="d-flex align-items-center justify-content-end">
                                <form action="{{ route('cart.add', $complement->id) }}" method="POST">
                                    @csrf
                                    <div class="d-flex justify-content-between p-3 {{ $complement->stok == 0 ? 'out-of-stock' : '' }}">
                                        <div class="minus px-2 border border-secondary">
                                            <i class="bi bi-dash fs-3"></i>
                                        </div>
                                        <input class="text-center" type="number" name="quantity" id="quantity"
                                            value="1" min="1" max="{{ $complement->stok }}" readonly>
                                        <div class="plus px-2 border border-secondary">
                                            <i class="bi bi-plus fs-3"></i>
                                        </div>
                                    </div>

                                    {{-- <div class="total-price text-center">Total: Rp. <span id="total-price"></span></div> --}}

                                    <!-- Add to Cart Button -->
                                    @if($complement->stok > 0)
                                    <button type="submit"
                                        class="addcart flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn3 p-lr-15 trans-04 js-addcart-detail">
                                        Add to Cart
                                    </button>
                                    @else
                                    <button class="disable-cart stext-101 cl0 size-101 bg-secondary p-lr-15 trans-04 out-of-stock" disabled>
                                        Out of Stock
                                    </button>
                                    @endif
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

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script>
            $(document).ready(function() {
                const price = {{ $complement->price }};
                let stock = {{ $complement->stok }};

                function updateTotal() {
                    const quantity = parseInt($('#quantity').val());
                    const total = price * quantity;
                    $('#total-price').text(new Intl.NumberFormat('id-ID').format(total));
                }

                function updateStockDisplay() {
                    const quantity = parseInt($('#quantity').val());
                    if (stock == 0) {
                        $('.stock').text('0');
                    } else {
                        $('.stock').text(stock - quantity);
                    }
                }

                $('.minus').click(function() {
                    let quantity = parseInt($('#quantity').val());
                    if (quantity > 1) {
                        $('#quantity').val(quantity - 1);
                        stock + 1;
                        updateTotal();
                        updateStockDisplay();
                    }
                });

                $('.plus').click(function() {
                    let quantity = parseInt($('#quantity').val());
                    if (quantity < stock) {
                        $('#quantity').val(quantity + 1);
                        stock - 1;
                        updateTotal();
                        updateStockDisplay();
                    }
                });

                updateStockDisplay();
                updateTotal();
            });
        </script>
    </body>
@endsection