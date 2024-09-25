@extends('landing.master')
@section('title', isset($setting) ? $setting->app_name . ' - Cart' : 'Cart')
@section('main')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<style>
    .btn-num-product-down:hover,
    .btn-num-product-up:hover,
    .proced:hover {
        background-color: #ffa500;
        color: #fff;
    }

    .cart-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 0px;
        margin-bottom: 15px;
        background-color: #fff;
        position: relative; /* Position relative for the delete button */
    }

    .cart-item img {
        width: 80px;
        height: 80px;
        margin-right: 20px;
    }

    .quantity-wrapper {
        display: flex;
        align-items: center;
        font-size: 0.8rem; /* Reduce font size */
    }

    .quantity-wrapper input {
        width: 40px; /* Reduce width */
        height: 30px; /* Set a specific height */
        text-align: center;
        margin: 0 5px; /* Reduce margin */
        font-size: 0.9rem; /* Reduce font size */
        border: 1px solid #ddd;
    }

    .btn-num-product-down, .btn-num-product-up {
        width: 30px; /* Set a specific width */
        height: 30px; /* Set a specific height */
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .total-summary {
        border-top: 1px solid #ddd;
        padding-top: 15px;
    }

    /* New CSS for delete button positioning */
    .delete-btn {
        position: absolute;
        top: 10px;
        right: 10px;
        color: red;
        border: none;
        background: none;
        cursor: pointer;
    }

    .subtotal {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
    }
    @media (max-width: 767px) {
        .cart-item {
            flex-direction: row;
            align-items: middle;
            font-size: 0.85rem; /* Smaller font size */
        }

        .cart-item img {
            width: 60px;
            height: 60px;
            margin-bottom: 10px;
        }

        .cart-item span {
            font-size: 0.85rem; /* Smaller font for price */
        }

        .quantity-wrapper input {
            width: 35px; /* Smaller input */
            height: 25px; /* Smaller height */
            font-size: 0.75rem; /* Smaller font */
        }

        .btn-num-product-down, .btn-num-product-up {
            width: 25px; /* Smaller button width */
            height: 25px; /* Smaller button height */
        }

        .subtotal span,
        .total-summary .mtext-110,
        .total-summary .stext-110 {
            font-size: 0.85rem; /* Reduce font size for total section */
        }

        .proced {
            font-size: 14px; /* Smaller button font size */
            padding: 8px 16px; /* Adjust padding */
        }
    }
</style>

<div class="bg0 p-t-80 p-b-85" id="cartForm">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 m-lr-auto m-b-40">
                <div class="wrap-cart-items">
                    @forelse($cartItems as $dt)
                        <div class="cart-item">
                            <!-- Product Info -->
                            <div style="display: flex; align-items: center;">
                                <img src="{{ asset('storage/' . $dt->complement->image) }}" alt="IMG">
                                <span>{{ $dt->complement->name }}</span>
                            </div>

                            <!-- Price -->
                            <span>Rp. {{ number_format($dt->complement->price) }}</span>

                            <!-- Total Price -->
                            <span>Rp. {{ number_format($dt->total) }}</span>

                            <!-- Actions (Remove Button) -->
                            <form action="{{ route('cart.remove', $dt->id) }}" method="POST" class="delete-btn">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="color: red; border: none; background: none; cursor: pointer;">
                                    <i class="fs-16 zmdi zmdi-delete"></i>
                                </button>
                            </form>

                            <!-- Quantity -->
                            <div class="quantity-wrapper">
                                <button class="btn-num-product-down decrement-btn cl8 hov-btn3 trans-04 flex-c-m">
                                    <i class="fs-16 zmdi zmdi-minus"></i>
                                </button>
                                
                                <input class="mtext-104 cl3 txt-center num-product qty-input" type="number" name="quantity" value="{{ $dt->quantity }}" min="1">
                                
                                <button class="btn-num-product-up increment-btn cl8 hov-btn3 trans-04 flex-c-m">
                                    <i class="fs-16 zmdi zmdi-plus"></i>
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="text-center">Your cart is empty!</div>
                    @endforelse
                </div>
            </div>
        </div>

        @if ($cartItems->isNotEmpty())
            <!-- Cart Total Section -->
            <div class="row">
                <div class="col-lg-12 m-lr-auto m-b-50">
                    <div class="bor10 p-lr-30 p-t-25 p-b-30 total-summary">
                        <h5 class="stext-110 cl2 p-b-10">Order</h5>
                        
                        <!-- Order Items -->
                        @foreach ($cartItems as $item)
                            <div class="subtotal flex-w flex-t p-b-10">
                                <div class="size-80 text-left">
                                    <span class="stext-110 cl2">{{ $item->complement->name }} ({{ $item->quantity }} x Rp. {{ number_format($item->complement->price) }})</span>
                                </div>
                                <div class="size-208 text-right">
                                    <span class="mtext-110 cl2">Rp. {{ number_format($item->total) }}</span>
                                </div>
                            </div>
                        @endforeach

                        <hr>

                        <!-- Total Section -->
                        <div class="flex-w flex-t p-t-15 p-b-20">
                            <div class="size-208">
                                <span class="mtext-101 cl2">Subtotal:</span>
                            </div>
                            <div class="size-209 text-right">
                                <span class="mtext-110 cl2">Rp. {{ number_format($cartItems->sum('total')) }}</span>
                            </div>
                        </div>
                        <form action="" method="POST">
                            @csrf
                            <button type="submit" class="proced flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer" style="font-size: 16px; padding: 10px 20px; border-radius: 5px;">
                                Checkout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <!-- If Cart is Empty -->
            <div class="row">
                <div class="col-lg-12 m-lr-auto m-b-50">
                    <div class="bor10 p-lr-40 p-t-30 p-b-40">
                        <h4 class="mtext-109 cl2 p-b-30">Your Cart is Empty</h4>
                        <a href="{{route('f&b.index')}}">
                            <button class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
                                Back To Shop
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>

@endsection
