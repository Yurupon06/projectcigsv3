@extends('landing.master')
@section('title', isset($setting) ? $setting->app_name . ' - Complement' : 'Complement')
@section('main')
    <style>
        .container {
            padding-top: 80px;
            padding-bottom: 200px;
        }

        .block2-pic {
            height: auto;
        }

        .block2-txt-child1 {
            text-align: center;
        }

        .block2-btn {
            font-size: 12px;
            padding: 10px 15px;
        }

        .block2-pic img {
            width: 100%;
            max-height: 150px;
            object-fit: cover;
        }

        .out-of-stock {
            opacity: 0.7;
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

    <body class="animsition">

        <div class="container">
            <div class="d-flex flex-row flex-wrap mb-4">
                <a href="{{ route('f&b.index') }}"
                    class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 {{ !$category ? 'how-active1' : '' }}"
                    data-filter="*">
                    All Complements
                </a>
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="bi bi-funnel-fill"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li>
                            <a href="{{ route('f&b.index', ['category' => 'food']) }}"
                                class="dropdown-item stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 {{ $category == 'food' ? 'how-active1' : '' }}"
                                data-filter=".food">
                                Food
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('f&b.index', ['category' => 'drink']) }}"
                                class="dropdown-item stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 {{ $category == 'drink' ? 'how-active1' : '' }}"
                                data-filter=".drink">
                                Drink
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('f&b.index', ['category' => 'suplement']) }}"
                                class="dropdown-item stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 {{ $category == 'suplement' ? 'how-active1' : '' }}"
                                data-filter=".suplement">
                                Suplement
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('f&b.index', ['category' => 'other']) }}"
                                class="dropdown-item stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 {{ $category == 'other' ? 'how-active1' : '' }}"
                                data-filter=".other">
                                Other
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="row">
                @forelse($complement as $dt)
                    <div class="col-6 mb-4">
                        <div class="position-relative {{ $dt->stok == 0 ? 'out-of-stock' : '' }} text-center">
                            <div class="block2-pic hov-img0">
                                @if ($dt->stok > 0)
                                    <a href="{{ route('complement.detail', $dt->id) }}">
                                        <img src="storage/{{ $dt->image }}" alt="{{ $dt->name }}">
                                    </a>
                                @else
                                    <img src="storage/{{ $dt->image }}" alt="{{ $dt->name }}">
                                    <h1 class="out-of-stock-overlay">
                                        <span class="badge bg-danger">Out of Stock</span>
                                    </h1>
                                @endif
                            </div>
                            <div>
                                @if ($dt->stok > 0)
                                <div class="mt-2">
                                    <a href="{{ route('complement.detail', $dt->id) }}" class="text-dark">
                                        <h6>
                                            {{ $dt->name }}
                                        </h6>
                                        <div class="stext-105 cl3">
                                            Rp. {{ number_format($dt->price) }}
                                        </div>
                                    </a>
                                    <form action="{{ route('cart.add', $dt->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="btn btn-dark btn-add-to-cart">
                                            Add to <i class="fa fa-cart-plus"></i>
                                        </button>
                                    </form>
                                </div>
                                @else
                                <div class="mt-2">
                                    <div>
                                        <h6>
                                            {{ $dt->name }}
                                        </h6>
                                        <div class="stext-105 cl3">
                                            Rp. {{ number_format($dt->price) }}
                                        </div>
                                    </div>
                                    <button class="btn btn-secondary" disabled>
                                        Out of Stock
                                    </button>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center">No Complement found.</p>
                @endforelse
            </div>
        </div>

        <!-- Back to top -->
        <div class="btn-back-to-top" id="myBtn">
            <span class="symbol-btn-back-to-top">
                <i class="zmdi zmdi-chevron-up"></i>
            </span>
        </div>

    </body>
@endsection