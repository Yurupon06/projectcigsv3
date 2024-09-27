@extends('landing.master')
@section('title', isset($setting) ? $setting->app_name . ' - Order' : 'Order')
@section('main')

    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <style>
        .status-badge {
            font-weight: bold;
        }

        .card {
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: scale(1.02);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        @media (max-width: 576px) {
            .card-text {
                font-size: 14px;
            }
        }

        /* Responsive Search Form */
        .search-form input {
            border-radius: 0 0 0 0;
        }

        .search-form button {
            border-radius: 0 20px 20px 0;
        }

        /* Media queries for smaller screens */
        @media (max-width: 768px) {
            .search-form input {
                width: 50%;
            }

            .search-form button {
                width: 30%;
                border-radius: 0 20px 20px 0;
            }
        }

        @media (max-width: 576px) {
            .search-form input {
                width: 60%;
                font-size: 14px;
            }

            .search-form button {
                width: 40%;
                font-size: 14px;
                border-radius: 0 20px 20px 0;
            }

            .search-form input[type="date"] {
                position: relative;

            }
        }

        .container {
            padding-bottom: 100px;
            margin-top: 80px;
        }

        .btn-outline-orange {
            border-color: #ff7e00;
        }

        .btn-outline-orange:hover {
            background-color: #ff7e00;
            color: #fff;
        }

        .btn-outline-orange.active {
            background-color: #ff7e00;
            border-color: #ff7e00;
            color: #fff;
        }
    </style>

    <div class="container">
        <form method="GET" action="{{ route('yourorder.index') }}" id="filter-form" class="">
            <div class="btn-group mb-4">
                <input type="radio" name="type" id="membership" value="membership" class="visually-hidden" onchange="this.form.submit()">
                <label for="membership" class="btn btn-outline-orange {{ request('type') == 'membership' ? 'active' : '' }}">Membership</label>
                <input type="radio" name="type" id="complement" value="complement" class="visually-hidden" onchange="this.form.submit()">
                <label for="complement" class="btn btn-outline-orange {{ request('type') == 'complement' ? 'active' : '' }}">Complement</label>
            </div>
        </form>
        <div class="d-flex justify-content-center mb-4">
            <form method="GET" action="{{ route('yourorder.index') }}" class="d-flex search-form">
                <input clang="s" type="text" name="search" class="form-control" placeholder="Search"
                    value="{{ request('search') }}" style="border-radius: 20px 0 0 20px; height: 38px; font-size: 14px;">
                <input type="date" name="start_date" id="start_date" class="form-control"
                    value="{{ request('start_date', $startDate) }}" max="{{ date('Y-m-d', strtotime('now')) }}"
                    style="height: 38px;">
                <input type="date" name="end_date" id="end_date" class="form-control"
                    value="{{ request('end_date', $endDate) }}" max="{{ date('Y-m-d', strtotime('now')) }}"
                    style="height: 38px;">
                <button type="submit" class="btn btn-primary"
                    style="background-color: #ff7e00; height: 38px; width: 30px;  ">
                    <i class="fas fa-search align-middle d-flex justify-content-center"></i>
                </button>
            </form>
        </div>

        <div class="row">
            @if (request('type') === 'membership')
                <div class="col-12">
                    <div class="row">
                        <div class="col-lg-12 mb-4 list">
                            @forelse ($orders as $order)
                                <a href="{{ route('checkout', $order->id) }}" class="card mb-4 text-decoration-none text-dark">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $order->customer->user->name }}</h5>
                                        <h6 class="card-subtitle mb-2 text-muted">{{ $order->product->product_name }}</h6>
                                        <p class="card-text">
                                            <strong>Order Date:</strong>
                                            {{ \Carbon\Carbon::parse($order->order_date)->translatedFormat('d F Y H:i') }}
                                            <br>
                                            <strong>Total Amount:</strong> Rp {{ number_format($order->total_amount) }}
                                            <br>
                                            <strong>Status:</strong>
                                            <span class="status-badge"
                                                style="color: {{ $order->status == 'unpaid' ? 'red' : ($order->status == 'canceled' ? 'gray' : 'green') }};">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </p>
                                    </div>
                                </a>
                            @empty
                                <p class="text-center">No orders found.</p>
                            @endforelse
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12">
                                        {{ $orders->appends(request()->except('page'))->links('pagination::bootstrap-5') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif (request('type') === 'complement')
                <div class="col-12">
                    <p class="text-center">Complement orders are currently not displayed.</p>
                </div>
            @endif
        </div>
    </div>
@endsection
