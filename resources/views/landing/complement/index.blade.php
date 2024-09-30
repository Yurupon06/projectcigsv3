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
                            <div class="block2-pic hov-img0 mb-2">
                                <img src="storage/{{ $dt->image }}" alt="{{ $dt->name }}">
                            </div>
                            <div>
                                <div class="d-flex flex-column text-center">
                                    <a href="{{ route('complement.detail', $dt->id) }}" style="color:rgb(0, 0, 0);">
                                    <span>
                                        {{ $dt->name }}
                                    </span>
                                    <span class="stext-105 cl3 mb-2">
                                        Rp. {{ number_format($dt->price) }}
                                    </span>
                                    <a href="{{ route('complement.detail', $dt->id) }}"
                                        class="rounded-pill btn btn-dark text-white text-uppercase">
                                        Quick View
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-center">Complement currently not available.</p>
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
