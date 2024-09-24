@extends('landing.master')
@section('main')

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="bg0 p-t-75 p-b-85" id="cartForm">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 m-lr-auto m-b-20">
                <div class="wrap-table-shopping-cart">
                    <table class="table-shopping-cart shopee-style-cart">
                        <thead>
                            <tr class="table_head">
                                <th class="column-1">Products</th>
                                <th class="column-2">Price</th>
                                <th class="column-3">Quantity</th>
                                <th class="column-4">Total</th>
                                <th class="column-5">Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($cartItems as $dt)
                                <tr class="table_row">
                                    <!-- Product Info -->
                                    <td class="column-1" style="display: flex; align-items: center;">
                                        <img src="{{ asset('storage/' . $dt->complement->image) }}" alt="IMG" style="width: 80px; height: 80px; margin-right: 20px;">
                                        <span>{{ $dt->complement->name }}</span>
                                    </td>

                                    <!-- Price -->
                                    <td class="column-2">Rp. {{ number_format($dt->complement->price) }}</td>

                                    <!-- Quantity -->
                                    <td class="column-3">
                                        <div class="wrap-num-product flex-w m-l-auto m-r-0">
                                            <button class="btn-num-product-down decrement-btn cl8 hov-btn3 trans-04 flex-c-m">
                                                <i class="fs-16 zmdi zmdi-minus"></i>
                                            </button>
                                        
                                            <input class="mtext-104 cl3 txt-center num-product qty-input" type="number" name="quantity" value="{{ $dt->quantity }}" min="1">
                                        
                                            <button class="btn-num-product-up increment-btn cl8 hov-btn3 trans-04 flex-c-m">
                                                <i class="fs-16 zmdi zmdi-plus"></i>
                                            </button>
                                        </div>
                                    </td>

                                    <!-- Total Price -->
                                    <td class="column-4">Rp. {{ number_format($dt->total) }}</td>

                                    <!-- Actions (Remove Button) -->
                                    <td class="column-5">
                                        <form action="{{ route('cart.remove', $dt->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-remove-cart" style="color: red; border: none; background: none; cursor: pointer;">
                                                Remove
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Your cart is empty!</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        @if ($cartItems->isnotempty())
        <!-- Cart Total Section -->
        <div class="row">
            <div class="col-lg-12 m-lr-auto m-b-50">
                <div class="bor10 p-lr-40 p-t-30 p-b-40">
                    <div class="flex-w flex-t p-b-13">
                        <div class="size-208">
                            <span class="stext-110 cl2">Subtotal:</span>
                        </div>
                        <div class="size-209">
                            <span class="mtext-110 cl2">Rp. {{ number_format($cartItems->sum('total')) }}</span>
                        </div>
                    </div>
                    <div class="flex-w flex-t p-t-27 p-b-33">
                        <div class="size-208">
                            <span class="mtext-101 cl2">Total:</span>
                        </div>
                        <div class="size-209">
                            <span class="mtext-110 cl2">Rp. {{ number_format($cartItems->sum('total')) }}</span>
                        </div>
                    </div>
                    <form action="" method="POST">
                        @csrf
                        <button type="submit" class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
                            Proceed to Checkout
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
