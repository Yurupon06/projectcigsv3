@extends('landing.master')
@section('title', isset($setting) ? $setting->app_name . ' - Cart' : 'Cart')
@section('main')

    <style>
        .container {
            padding-top: 80px;
            padding-bottom: 100px;
        }

        .delete-cart {
            top: 5px;
            right: 10px;
        }

        .proced:hover {
            background-color: #ffa500;
        }
    </style>

    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if ($cartItems->isNotEmpty())
            @foreach ($cartItems as $dt)
                <div class="row cart-item" data-id="{{ $dt->id }}">
                    <div class="col-12">
                        <div class="card mb-4 text-decoration-none text-dark">
                            <div class="card-body position-relative px-4">
                                <div class="row">
                                    <div class="col-3 text-center">
                                        <img src="{{ asset('storage/' . $dt->complement->image) }}" alt="IMG"
                                            style="max-width: 50px;">
                                    </div>
                                    <div class="col-5 d-flex flex-column my-auto">
                                        <span>{{ $dt->complement->name }}</span>
                                        <span>Rp. <span
                                                class="item-price">{{ number_format($dt->complement->price, 0, '.', '.') }}</span></span>
                                    </div>
                                    <div class="col-4 my-auto text-center">
                                        <span>Rp. <span
                                                class="item-total">{{ number_format($dt->total, 0, '.', '.') }}</span></span>
                                        <div class="">
                                            <div class="row gap-0">
                                                <div class="col-4 minus border border-secondary text-center p-0">
                                                    <i class="fa fa-minus"></i>
                                                </div>
                                                <input class="col-4 text-center item-quantity" type="number"
                                                    name="quantity-{{ $dt->id }}" value="{{ $dt->quantity }}"
                                                    min="1" max="{{ $dt->complement->stok }}" readonly>
                                                <div class="col-4 plus border border-secondary text-center p-0">
                                                    <i class="fa fa-plus"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="delete-cart position-absolute">
                                    <form action="{{ route('cart.remove', $dt->id) }}" method="POST" class="delete-btn">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="remove-item" data-id="{{ $dt->id }}"
                                            style="color: red; border: none; background: none; cursor: pointer;">
                                            <i class="fs-16 zmdi zmdi-delete"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="row">
                <div class="col-12 m-auto mb-4">
                    <div class="card p-4 total-summary">
                        <h5 class="stext-110 cl2 p-b-10">Order</h5>

                        @foreach ($cartItems as $item)
                            <div class="subtotal d-flex justify-content-between" data-id="{{ $item->id }}">
                                <div class="size-80 text-left">
                                    <span class="stext-110 cl2">{{ $item->complement->name }} (<span
                                            class="total-quantity">{{ $item->quantity }}</span> x Rp.
                                        {{ number_format($item->complement->price, 0, '.', '.') }})</span>
                                </div>
                                <div class="size-208 text-right">
                                    <span class="mtext-110 cl2">Rp. <span
                                            class="total-price">{{ number_format($item->total, 0, '.', '.') }}</span></span>
                                </div>
                            </div>
                        @endforeach

                        <hr>

                        <div class="d-flex justify-content-between py-3">
                            <div class="size-208">
                                <span class="mtext-101 cl2">Subtotal:</span>
                            </div>
                            <div class="size-209 text-right">
                                <span class="mtext-110 cl2" id="subtotal">Rp. <span
                                        id="subtotal-price">{{ number_format($cartItems->sum('total'), 0, '.', '.') }}</span></span>
                            </div>
                        </div>
                        <form id="checkout-form" action="{{ route('checkout.complement.store') }}" method="POST">
                            @csrf
                            @foreach ($cartItems as $item)
                                <div class="input-quantity d-none" data-id="{{ $item->id }}">
                                    <input type="number" name="quantity-{{ $item->id }}" class="item-quantity"
                                        value="{{ $item->quantity }}" min="1" max="{{ $item->complement->stok }}">
                                </div>
                            @endforeach
                            <button type="submit"
                                class="proced flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer"
                                style="font-size: 16px; padding: 10px 20px; border-radius: 5px;">
                                Checkout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <div class="row">
                <div class="col-lg-12 m-lr-auto m-b-50">
                    <div class="bor10 p-lr-40 p-t-30 p-b-40">
                        <h4 class="mtext-109 cl2 p-b-30">Your Cart is Empty</h4>
                        <a href="{{ route('f&b.index') }}">
                            <button class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
                                Back To Shop
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        $(document).ready(function() {
            $(document).on('click', '.minus', function() {
                let input = $(this).siblings('input.item-quantity');
                let quantity = parseInt(input.val());
                let price = parseInt($(this).closest('.card-body').find('.item-price').text().replace(
                    'Rp. ', '').replace('.', ''));
                let itemId = $(this).closest('.cart-item').data('id');
                let total = quantity * price;
                if (quantity > 1) {
                    input.val(quantity - 1);
                    $('.subtotal[data-id="' + itemId + '"]').find('span.total-quantity').text(quantity - 1);
                    $('.input-quantity[data-id="' + itemId + '"]').find('input').val(quantity - 1);
                    total = (quantity - 1) * price;
                    $(this).closest('.card-body').find('.item-total').text(new Intl.NumberFormat('id-ID')
                        .format(total));
                    $('.subtotal[data-id="' + itemId + '"]').find('.total-price').text(new Intl
                        .NumberFormat('id-ID').format(total));
                    updateTotal();
                }
            });

            $(document).on('click', '.plus', function() {
                let input = $(this).siblings('input.item-quantity');
                let quantity = parseInt(input.val());
                let max = parseInt(input.attr('max'));
                let price = parseInt($(this).closest('.card-body').find('.item-price').text().replace(
                    'Rp. ', '').replace('.', ''));
                let itemId = $(this).closest('.cart-item').data('id');
                let total = quantity * price;
                if (quantity < max) {
                    input.val(quantity + 1);
                    $('.subtotal[data-id="' + itemId + '"]').find('span.total-quantity').text(quantity + 1);
                    $('.input-quantity[data-id="' + itemId + '"]').find('input').val(quantity + 1);
                    total = (quantity + 1) * price;
                    $(this).closest('.card-body').find('.item-total').text(new Intl.NumberFormat('id-ID')
                        .format(total));
                    $('.subtotal[data-id="' + itemId + '"]').find('.total-price').text(new Intl
                        .NumberFormat('id-ID').format(total));
                    updateTotal();
                }
            });

            function updateTotal() {
                let subtotal = 0;
                $('.item-total').each(function() {
                    subtotal += parseInt($(this).text().replace('Rp. ', '').replace(',', '').replace('.',
                        ''));
                });
                $('#subtotal-price').text(new Intl.NumberFormat('id-ID').format(subtotal));
            }
        });
    </script>


@endsection
