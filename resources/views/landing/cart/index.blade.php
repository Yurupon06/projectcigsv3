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
            <div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
                <div class="m-l-25 m-r--38 m-lr-0-xl">
                    <div class="wrap-table-shopping-cart">
                        <table class="table-shopping-cart">
                            <tr class="table_head">
                                <th class="column-1">Products</th>
                                <th class="column-2"></th>
                                <th class="column-3">Price</th>
                                <th class="column-4">Quantity</th>
                                <th class="column-5">Total</th>
                            </tr>

                            @forelse($cartItems as $dt)
                                <tr class="table_row">
                                    <td class="column-1">
                                        <form action="{{ route('cart.remove', $dt->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" style="border: none; background: none; padding: 0; cursor: pointer;">
                                                <div class="how-itemcart1">
                                                    <img src="{{ asset('storage/' . $dt->complement->image) }}" alt="IMG" style="width: 50px; height: 50px;">
                                                </div>
                                            </button>
                                        </form>
                                    </td>
                                    <td class="column-2">{{ $dt->complement->name }}</td>
                                    <td class="column-3">Rp. {{ number_format($dt->complement->price) }}</td>
                                    <td class="column-4">
                                        <div class="wrap-num-product flex-w m-l-auto m-r-0">
                                            <div class="btn-num-product-down decrement-btn cl8 hov-btn3 trans-04 flex-c-m">
                                                <i class="fs-16 zmdi zmdi-minus"></i>
                                            </div>
                                        
                                            <input class="mtext-104 cl3 txt-center num-product qty-input" type="number" name="quantity" value="{{ $dt->quantity }}" min="1" id="quantity-{{ $dt->id }}">
                                        
                                            <div class="btn-num-product-up increment-btn cl8 hov-btn3 trans-04 flex-c-m">
                                                <i class="fs-16 zmdi zmdi-plus"></i>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="column-5">Rp. {{ number_format($dt->total) }}</td>
                                </tr>
                            @empty
                            @endforelse

                        </table>
                    </div>
                </div>
            </div>
        </form>

        @if ($cartItems->isnotempty())
        <div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
            <div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
                <h4 class="mtext-109 cl2 p-b-30">Cart Totals</h4>

                <div class="flex-w flex-t bor12 p-b-13">
                    <div class="size-208">
                        <span class="stext-110 cl2">Subtotal:</span>
                    </div>

                    <div class="size-209">
                        <span class="mtext-110 cl2">
                            Rp. {{ number_format($cartItems->sum('total')) }}
                        </span>
                    </div>
                </div>
                <br>
                <div class="flex-w flex-t p-t-27 p-b-33">
                    <div class="size-208">
                        <span class="mtext-101 cl2">Total:</span>
                    </div>

                    <div class="size-209 p-t-1">
                        <span class="mtext-110 cl2">
                            Rp. {{ number_format($cartItems->sum('total')) }}
                        </span>
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
            
        @else
        <div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50">
            <div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
                <h4 class="mtext-109 cl2 p-b-30">Cart Empty</h4>
                <a href="{{route('f&b.index')}}">
                    <button type="button" class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
                        Back To Shop
                    </button>
                </a>
                    
            </div>
        </div>
        @endif
    </div>
</div>

@endsection
