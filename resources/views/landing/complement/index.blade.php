@extends('landing.master')
@section('title', isset($setting) ? $setting->app_name . ' - Complement' : 'Complement')
@section('main')
    <style>
        .container {
            padding-top: 80px;
            padding-bottom: 100px;
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
            max-height: 200px;
            object-fit: cover;
        }

        .floating-cart {
            position: fixed;
            bottom: 100px;
            right: 420px;
            background-color: #fff;
            color: white;
            padding: 15px;
            border-radius: 50%;
            box-shadow: 0 3px 2px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            transition: background-color 0.3s ease;
        }

        .floating-cart:hover {
            background-color: #FF5722;
        }

        .floating-cart i {
            font-size: 20px;
            color: #FF5722;
        }
        .floating-cart:hover i {
            color: white;
        }
        @media screen and (max-width: 576px) {
            .floating-cart {
            display: flex;
            position: fixed;
            bottom: 100px;
            right: 20px;
            background-color: #fff;
            color: white;
            padding: 15px;
            border-radius: 50%;
            box-shadow: 0 3px 2px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            transition: background-color 0.3s ease;
            }
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
                        <div>
                            <div class="block2-pic hov-img0">
                                <img src="storage/{{ $dt->image }}" alt="{{ $dt->name }}">
                                <a href="{{ route('complement.detail', $dt->id) }}"
                                    class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04">
                                    Quick View
                                </a>
                            </div>
                            <div>
                                <div class="d-flex flex-column text-center">
                                    <span>
                                        {{ $dt->name }}
                                    </span>
                                    <span class="stext-105 cl3">
                                        Rp. {{ number_format($dt->price) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center">No Complement found.</p>
                @endforelse
            </div>
        </div>

        <!-- Floating Cart Icon -->
        <div class="floating-cart">
            <a href="{{ route('cart.index') }}">
                <i class="fa fa-shopping-cart"></i>
            </a>
        </div>

        <!-- Back to top -->
        <div class="btn-back-to-top" id="myBtn">
            <span class="symbol-btn-back-to-top">
                <i class="zmdi zmdi-chevron-up"></i>
            </span>
        </div>

    </body>
@endsection
