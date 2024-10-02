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

        .summary-item img {
            width: 40px;
            height: 40px;
            border-radius: 0.375rem;
            margin-right: 10px;
        }
        /* Scrollable product list */
        .product-list-container {
            max-height: 400px; /* Adjust as necessary */
            overflow-y: auto;
        }
    </style>

    <div class="container-fluid mt-5 py-4">
        <div class="row">
            @if (session('success'))
                <div class="alert alert-success small" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-error small" role="alert">
                    {{ session('error') }}
                </div>
            @endif
            <div class="col-md-8">
                <div class="btn-group" role="group" aria-label="Basic example">
                    <a href="{{route('cashier.order')}}" type="button" class="btn btn-secondary">MEMBERSHIP</a>
                    <a href="{{route('cashier.complement')}}" type="button" class="btn btn-primary">COMPLEMENT</a>
                </div>
                <!-- Product List -->
                <div class="card">
                    <div class="card-body product-list-container">
                        <div class="row">
                            @forelse($complement as $dt)
                                <div class="col-md-2 mb-4">
                                    <div class="product-card">
                                        <img src="{{ asset('storage/' . $dt->image) }}" alt="{{ $dt->name }}">
                                        <div class="product-name">{{ $dt->name }}</div>
                                        <span>stok : {{$dt->stok}}</span>
                                        <div class="product-price">{{ number_format($dt->price, 0, ',', '.') }} IDR</div>
                                        <form action="{{ route('cart.added', $dt->id) }}" method="POST" class="add-to-cart-form">
                                            @csrf
                                            <button type="submit" class="btn btn-primary add-to-cart-btn">Add to Order</button>
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
            <div class="col-md-4">
                <div class="card summary-card">
                    <div class="summary-content">
                        <div class="summary-title">Order Summary</div>

                        <!-- Cart Items Display -->
                        <div id="cart-summary">
                                <div class="summary-item">
                                    <img src="{{ asset('storage/' . $item->complement->image) }}" alt="{{ $item->complement->name }}" style="width: 40px; height: 40px; border-radius: 0.375rem; margin-right: 10px;">

                                    <span>{{ $item->complement->name }}</span>
                                    <div class="summary-item-quantity">
                                        <div class="quantity-wrapper">
                                            <button class="quantity-btn minus-btn" onclick="changeQuantity(this, -1, {{ $item->id }})">-</button>
                                            <input type="number" class="quantity-input" value="{{ $item->quantity }}" min="1">
                                            <button class="quantity-btn plus-btn" onclick="changeQuantity(this, 1, {{ $item->id }})">+</button>
                                        </div>
                                        <span>x Rp {{ number_format($item->complement->price) }}</span>
                                    </div>

                                    <form action="{{ route('cart.deleted', $item->id) }}" method="POST" class="delete-btn">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">

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
                    <form action="{{ route('cart.checkout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary summary-checkout-btn">Proceed to Checkout</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        function changeQuantity(button, change, itemId) {
            const quantityInput = button.closest('.quantity-wrapper').querySelector('.quantity-input');
            let currentQuantity = parseInt(quantityInput.value);
            const newQuantity = currentQuantity + change;
    
            if (newQuantity < 1) return; 
    
            quantityInput.value = newQuantity;
    
            fetch(`{{ url('/cashier/cart/update') }}/${itemId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ quantity: newQuantity })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {

                    updateOverallTotal();
                } else {
                }
            })
            .catch(error => console.error('Error:', error));
        }
    
        function updateOverallTotal() {
            const summaryItems = document.querySelectorAll('.summary-item');
            let overallTotal = 0;
    
            summaryItems.forEach(item => {
                const quantityInput = item.querySelector('.quantity-input');
                const price = parseFloat(item.querySelector('span:last-child').textContent.replace(/[^\d.-]/g, ''));
                overallTotal += (quantityInput.value * price);
            });
    
            // Update the overall total display
            const totalDisplay = document.querySelector('.summary-total span:last-child');
            totalDisplay.textContent = `Rp ${overallTotal.toLocaleString()}`;
        }
    </script>

    
    
@endsection
