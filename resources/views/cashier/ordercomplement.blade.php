@extends('cashier.master')
@section('title', isset($setting) ? $setting->app_name . ' - Add Order' : 'Add Order')
@section('sidebar')
    @include('cashier.sidebar')
@endsection
@section('page-title', 'Add Order')
@section('page', 'Customer / Create')
@section('main')
    @include('cashier.main')

    <style>
        .product-card {
            border: 1px solid #ddd;
            border-radius: 0.375rem;
            padding: 0.5rem;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            height: 100%;
        }
        .product-card img {
            width: 100%;
            height: 120px;
            object-fit: cover;
            margin-bottom: 0.5rem;
            border-radius: 0.375rem;
        }
        .product-name {
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 0.25rem;
        }
        .product-price {
            font-size: 0.875rem;
            font-weight: 500;
            color: #28a745;
            margin-bottom: 0.75rem;
        }
        .add-to-cart-btn {
            font-size: 0.75rem;
            padding: 0.375rem 0.75rem;
        }
        /* Flexbox for the summary card */
        .summary-card {
            display: flex;
            flex-direction: column;
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            border-radius: 0.375rem;
            padding: 1rem;
            height: 100%;
        }
        .summary-content {
            flex-grow: 1;
        }
        .summary-title {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 1rem;
        }
        .summary-item {
            font-size: 0.700rem;
            margin-bottom: 0.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .summary-item-quantity {
            display: flex;
            align-items: center;
            gap: 5px;
            padding-top: 0.8rem;
            padding-bottom: 0.2rem;
        }
        .quantity-input {
            width: 20px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 0.375rem;
            height: 20px;
        }
        .quantity-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 75px;
        }
        .quantity-btn {
            background-color: #e9ecef;
            border: none;
            padding: 1px;
            font-size: 1rem;
            cursor: pointer;
            border-radius: 0.375rem;
            height: 20px;
            width: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .quantity-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }
        .summary-total {
            font-size: 1rem;
            font-weight: 700;
            margin-top: 1rem;
            display: flex;
            justify-content: space-between;
        }
        .summary-checkout-btn {
            width: 100%;
            margin-top: 1rem;
        }
        .col-md-5 {
            width: 33%;
        }
        @media (min-width: 992px) { 
            .col-md-4 {
                width: 25%; 
                height: 100%;
            }
            .col-md-5 {
                width: 33%; 
            }
            .product-card {
                padding: 0.25rem; 
                font-size: 0.85rem; 
            }
            .product-card img {
                height: 100%; 
            }
            .product-name {
                font-size: 0.75rem; 
            }
            .product-price {
                font-size: 0.75rem; 
            }
            .add-to-cart-btn {
                font-size: 0.65rem; 
                padding: 0.25rem 0.5rem; 
            }
            .summary-card {
                display: flex;
                flex-direction: column;
                background-color: #f8f9fa;
                border: 1px solid #ddd;
                border-radius: 0.375rem;
                padding: 1rem;
                height: 100%;
            }
            .summary-content {
                flex-grow: 1;
            }
            .summary-title {
                font-size: 1rem;
                font-weight: 600;
                margin-bottom: 1rem;
            }
            .summary-item {
                font-size: 0.875rem;
                margin-bottom: 0.5rem;
                display: flex;
                justify-content: space-between;
                align-items: center;
            }
            .summary-item-quantity {
                display: flex;
                align-items: center;
                gap: 5px;
            }
            .quantity-input {
                width: 40px;
                text-align: center;
                border: 1px solid #ddd;
                margin: 0 5px;
                height: 30px;
            }
            .quantity-wrapper {
                width: 100px;
                margin-right: 4rem;
                display: flex;
            }
            .quantity-btn {
                background-color: #e9ecef;
                border: none;
                padding: 0 10px;
                padding-right: 10px;
                font-size: 1.2rem;
                cursor: pointer;
                border-radius: 0.375rem;
                height: 30px;
                width: 30px;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .quantity-btn:disabled {
                opacity: 0.5;
                cursor: not-allowed;
            }
            .summary-total {
                font-size: 1rem;
                font-weight: 700;
                margin-top: 1rem;
                display: flex;
                justify-content: space-between;
            }
            .summary-checkout-btn {
                width: 100%;
                margin-top: 1rem;
            }
        }
    </style>

    <div class="container-fluid mt-5 py-4">
        <div class="row">   
            @if (session('success'))
                <div class="alert alert-success small" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="col-md-8">
                <a href="{{route('cashier.order')}}" type="button" class="btn btn-primary btn-sm align-items-center" style="font-size: 12px; padding: 10px 12px; background-color: #007bff; box-shadow: 0 4px 6px rgba(0, 0, 255, 0.1); border: none;">
                    <i class="fas fa-user-tag me-2" style="font-size: 18px;"></i> Membership
                </a>
                <a href="{{route('cashier.complement')}}" type="button" class="btn btn-sm align-items-center" style="font-size: 12px; padding: 10px 12px; background-color: #ff5c00; color: white; box-shadow: 0 4px 6px rgba(255, 165, 0, 0.1); border: none;">
                    <i class="fas fa-shopping-basket me-2" style="font-size: 18px;"></i> Complement
                </a>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            @forelse($complement as $product)
                                <div class="col-md-4 mb-4"> 
                                    <div class="product-card">
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                        <div class="product-name">{{ $product->name }}</div>
                                        <div class="product-price">{{ number_format($product->price, 0, ',', '.') }} IDR</div>
                                        <form action="{{route('cart.added', $product->id)}}" method="POST" class="add-to-cart-form">
                                            @csrf
                                            <button type="submit" class="btn btn-primary add-to-cart-btn">Add to Cart</button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <div class="col-md-12">
                                    <p>No products available.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card summary-card">
                    <div class="summary-content">
                        <div class="summary-title">Order Summary</div>
                        <!-- Cart Items Display -->
                        <div id="cart-summary">
                            @foreach($cartItems as $item)
                                <div class="summary-item" style="position: relative;">
                                    <span>{{ $item->complement->name }}</span>
                                    <div class="summary-item-quantity">
                                        <div class="quantity-wrapper">
                                            <button class="quantity-btn minus-btn" onclick="changeQuantity(this, -1, {{ $item->id }})">-</button>
                                            <input type="number" class="quantity-input" value="{{ $item->quantity }}" min="1" readonly>
                                            <button class="quantity-btn plus-btn" onclick="changeQuantity(this, 1, {{ $item->id }})">+</button>
                                        </div>
                                        <span>x Rp {{ number_format($item->complement->price, 0, ',', '.') }}</span>
                                    </div>
                                    <!-- Tombol Delete -->
                                    <form action="{{ route('cart.deleted', $item->id) }}" method="POST" class="delete-btn" style="position: absolute; top: 0; right: 0;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" style="font-size: 8px; padding: 1px 3px; margin-bottom: 5px;">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            @endforeach
                        </div>

                        
                        <!-- Total Harga -->
                        <div class="summary-total">
                            <span>Total</span>
                            <span>Rp {{ number_format($cartItems->sum('total'), 0, ',', '.') }}</span>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary summary-checkout-btn">Proceed to Checkout</button>
                </div>
            </div>
        </div>
    </div>
    

    <script>
        function changeQuantity(button, change, cartId) {
            const input = button.parentElement.querySelector('.quantity-input');
            const currentValue = parseInt(input.value);
            const newValue = currentValue + change;
            if (newValue >= 1) {
                input.value = newValue;
                // Kirim request Ajax untuk update quantity
                updateCartQuantity(cartId, newValue);
            }
        }

        function updateCartQuantity(cartId, quantity) {
            $.ajax({
                url: '/cart/update/' + cartId,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    quantity: quantity
                },
                success: function(response) {
                    // Update summary cart items
                    $('#cart-summary').html(response.html);
                    // Update total
                    $('.summary-total span:last-child').text('Rp ' + response.total);
                }
            });
        }

        $('.add-to-cart-form').submit(function(e) {
            e.preventDefault();
            var form = $(this);
            $.ajax({
                url: form.attr('action'),
                method: form.attr('method'),
                data: form.serialize(),
                success: function(response) {
                    // Update cart summary dengan data baru
                    $('#cart-summary').html(response.html);
                    $('.summary-total span:last-child').text('Rp ' + response.total);
                }
            });
        });
    </script>
@endsection