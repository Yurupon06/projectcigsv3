
@extends('landing.master')
@include('landing.header')

@if(session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
@endif

<div class="container mt-4">
    <div class="row">
        <!-- Full Width Content on Desktop -->
        <div class="col-12 d-none d-lg-block">
            <div class="row">
                <!-- Main Content: Full Width on Desktop -->
                <div class="col-lg-12 mb-4">
                    @foreach ($orders as $i => $order)
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
                                <span class="status-badge" style="color: {{ $order->status == 'unpaid' ? 'red' : ($order->status == 'canceled' ? 'gray' : 'green') }}; font-weight: bold;">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </p>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Mobile Layout: Full Width -->
        <div class="col-12 d-lg-none">
            @foreach ($orders as $i => $order)
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
                        <span class="status-badge" style="color: {{ $order->status == 'unpaid' ? 'red' : ($order->status == 'canceled' ? 'gray' : 'green') }}; font-weight: bold;">
                            {{ ucfirst($order->status) }}
                        </span>
                    </p>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</div>

<style>
    .status-badge {
        font-weight: bold;
    }
    .card {
        cursor: pointer;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card:hover {
        transform: scale(1.02); /* Slightly enlarges the card */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* Adds shadow on hover */
    }
    @media (max-width: 576px) {
        .card-text {
            font-size: 14px;
        }
    }
</style>
