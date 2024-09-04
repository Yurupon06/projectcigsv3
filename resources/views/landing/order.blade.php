@extends('landing.master')
@section('title', 'Order')
@section('main')
    @include('landing.header')

    @if(session('success'))
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
    </style>

    <div class="container mt-4">
        <div class="d-flex justify-content-end mb-4">
            <form method="GET" action="{{ route('yourorder.index') }}" class="d-flex">
                <input type="text" name="search" class="form-control" placeholder="Search" value="{{ request('search') }}" style="border-radius: 20px 0 0 20px; height: 38px; width: 250px;">
                <div class="form-group">
                    <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date', $startDate) }}" max="{{ date('Y-m-d', strtotime('now')) }}">
                </div>
                <div class="form-group">
                    <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date', $endDate) }}" max="{{ date('Y-m-d', strtotime('now')) }}">
                </div>
                <button type="submit" class="btn btn-primary" style="background-color: #ff7e00; border-radius: 0 20px 20px 0; height: 38px; padding: 0 15px;">
                    <i class="fas fa-search"></i>
                </button>
            </form>
        </div>
        
        <div class="row">
            <div class="col-12 d-none d-lg-block">
                <div class="row">
                    <div class="col-lg-12 mb-4">
                        @forelse ($orders as $i => $order)
                            <a href="{{ route('checkout', $order->id) }}" class="card mb-4 text-decoration-none text-dark">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $order->customer->user->name }}</h5>
                                    <h6 class="card-subtitle mb-2 text-muted">{{ $order->product->product_name }}</h6>
                                    <p class="card-text">
                                        <strong>Order Date:</strong> {{ \Carbon\Carbon::parse($order->order_date)->translatedFormat('d F Y H:i') }}
                                        <br>
                                        <strong>Total Amount:</strong> Rp {{ number_format($order->total_amount) }}
                                        <br>
                                        <strong>Status:</strong> 
                                        <span class="status-badge" style="color: {{ $order->status == 'unpaid' ? 'red' : ($order->status == 'canceled' ? 'gray' : 'green') }};">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </p>
                                </div>
                            </a>
                        @empty
                            <p class="text-center">No orders found.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Mobile Layout: Full Width -->
            <div class="col-12 d-lg-none">
                @forelse ($orders as $i => $order)
                    <a href="{{ route('checkout', $order->id) }}" class="card mb-4 text-decoration-none text-dark">
                        <div class="card-body">
                            <h5 class="card-title">{{ $order->customer->user->name }}</h5>
                            <h6 class="card-subtitle mb-2 text-muted">{{ $order->product->product_name }}</h6>
                            <p class="card-text">
                                <strong>Order Date:</strong> {{ \Carbon\Carbon::parse($order->order_date)->translatedFormat('d F Y H:i') }}
                                <br>
                                <strong>Total Amount:</strong> Rp {{ number_format($order->total_amount) }}
                                <br>
                                <strong>Status:</strong> 
                                <span class="status-badge" style="color: {{ $order->status == 'unpaid' ? 'red' : ($order->status == 'canceled' ? 'gray' : 'green') }};">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </p>
                        </div>
                    </a>
                @empty
                    <p style="text-align: center; font-weight: bold;">No orders found.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
