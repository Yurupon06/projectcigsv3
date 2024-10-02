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
        .search-form {
            border-radius: 0 0 0 0;
        }

        .search-button {
            border-radius: 0 20px 20px 0;
            width: 50px;
            background-color: #ff7e00;
        }

        .fa-search {
            font-size: 18px;
            color: #fff;
        }

        .container {
            padding-bottom: 100px;
            margin-top: 80px;
        }

        label {
            cursor: pointer;
        }

        .btn-outline-orange {
            border: 1px solid #ff7e00;
        }

        .btn-outline-orange:hover {
            background-color: #ff7e00;
            color: #fff;
            transform: scale(1.05);
        }

        .btn-outline-orange.active {
            background-color: #ff7e00;
            border: 1px solid #ff7e00;
            color: #fff;
        }

        @media (max-width: 576px) {
            .search-form .form-control {
                width: 100%;
            }
        }
    </style>

    <div class="container">
        <div class="row">
            <form method="GET" action="{{ route('yourorder.index') }}" id="filter-form">
                <div class="button-group d-flex flex-row mb-4">
                    <div
                        class="rounded-start btn-outline-orange {{ request('type', 'membership') == 'membership' ? 'active' : '' }} px-2 pt-1">
                        <input type="radio" name="type" id="membership" value="membership" class="d-none"
                            {{ request('type', 'membership') == 'membership' ? 'checked' : '' }} onchange="this.form.submit()">
                        <label for="membership">Membership</label>
                    </div>
                    <div class="rounded-end btn-outline-orange {{ request('type') == 'complement' ? 'active' : '' }} px-2 pt-1">
                        <input type="radio" name="type" id="complement" value="complement" class="d-none"
                            {{ request('type') == 'complement' ? 'checked' : '' }} onchange="this.form.submit()">
                        <label for="complement">Complement</label>
                    </div>
                </div>
                <div class="d-flex justify-content-center mb-4">
                    <div class="col-4 col-sm-4 p-0">
                        <input type="text" name="search" class="form-control" placeholder="Search"
                            value="{{ request('search') }}" style="border-radius: 20px 0 0 20px;">
                    </div>
                    <div class="col-3 col-sm-3 p-0">
                        <input type="date" name="start_date" id="start_date" class="form-control" style="border-radius: 0;"
                            value="{{ request('start_date', $startDate) }}" max="{{ date('Y-m-d', strtotime('now')) }}">
                    </div>
                    <div class="col-3 col-sm-3 p-0">
                        <input type="date" name="end_date" id="end_date" class="form-control" style="border-radius: 0;"
                            value="{{ request('end_date', $endDate) }}" max="{{ date('Y-m-d', strtotime('now')) }}">
                    </div>
                    <div class="col-2 col-sm-2 p-0 search-button d-flex justify-content-center">
                        <button type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
            </form>
        </div>
        <div class="row">
            @if (request('type') === 'membership')
                <div class="col-12">
                    <div class="row ms-2">
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
                    <div class="row ms-2">
                        <div class="col-lg-12 mb-4 list">
                            @forelse ($orderComplements as $orderComplement)
                                <a href="{{ route('checkout.complement', $orderComplement->id) }}"
                                    class="card mb-4 text-decoration-none text-dark">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $orderComplement->user->name }}</h5>
                                        <h6 class="card-subtitle mb-2 text-muted">Complement</h6>
                                        <p class="card-text">
                                            <strong>Order Date:</strong>
                                            {{ \Carbon\Carbon::parse($orderComplement->created_at)->translatedFormat('d F Y H:i') }}
                                            <br>
                                            <strong>Total Amount:</strong>Rp
                                            {{ number_format($orderComplement->total_amount) }}
                                            <br>
                                            <strong>Status:</strong>
                                            <span class="status-badge"
                                                style="color: {{ $orderComplement->status == 'unpaid' ? 'red' : ($orderComplement->status == 'canceled' ? 'gray' : 'green') }};">
                                                {{ ucfirst($orderComplement->status) }}
                                            </span>
                                        </p>
                                    </div>
                                </a>
                            @empty
                                <p class="text-center">No complement found.</p>
                            @endforelse
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12">
                                        {{ $orderComplements->appends(request()->except('page'))->links('pagination::bootstrap-5') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
