@extends('landing.master')
@section('title',  $setting->app_name . ' - Checkout' ?? 'Checkout')
@section('main')

<style>
    .cell-padding {
        padding-left: 10px;
        padding-right: 10px;
    }
    .flex-w {
        display: flex;
        flex-wrap: wrap;
    }
    .flex-sb {
        justify-content: space-between;
    }
    .mtext-110 {
        margin-right: 10px;
    }
    .mb-50 {
        margin-bottom: 50px;
    }
    .navigation-links {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
    }
    .navigation-links a {
        text-decoration: none;
        color: #007BFF;
        font-weight: bold;
    }
    .navigation-links a:hover {
        text-decoration: underline;
    }
    .qr-code-container {
        text-align: center;
        margin-top: 30px;
    }
    .card {
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        margin-bottom: 15px;
    }
    .card-title {
        font-size: 18px;
        font-weight: bold;
    }
    .card-subtitle {
        font-size: 16px;
        color: #6c757d;
    }
    .card-text {
        font-size: 14px;
    }
    .status-badge {
        font-weight: bold;
    }
    .custom-button {
        background-color: #007BFF;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        font-size: 14px;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.2s ease;
    }
    .custom-button:hover {
        background-color: #0056b3;
        transform: scale(1.05);
    }
    @media (max-width: 576px) {
        .card-title {
            font-size: 16px;
        }
        .card-subtitle {
            font-size: 14px;
        }
        .card-text {
            font-size: 12px;
        }
        .navigation-links {
            flex-direction: column;
            align-items: flex-start;
        }
    }
    @media (min-width: 992px) {
        .container {
            display: flex;
            justify-content: center;
        }
        .row {
            max-width: 900px;
            width: 100%;
        }
    }

    .container {
        padding-bottom: 100px;
    }
</style>

<div class="container mt-4">
    <div class="row">
        <!-- Navigation Back Link -->
        <div class="col-12 mb-3">
            <div class="navigation-links">
                <a href="{{ route('yourorder.index') }}">Back</a>
            </div>
        </div>

        <!-- Profile Section -->
        <div class="col-12 mb-4">
            <div class="card shadow">
                <h5 class="card-title">Profile</h5>
                <div class="card-text">
                    <p>{{ $order->customer->user->name }} ( {{ $order->customer->phone }} )</p>
                    <p>{{ $order->customer->user->email }}</p>
                </div>
            </div>
        </div>

        <!-- Order Details Section -->
        <div class="col-12 mb-4">
            <div class="card shadow">
                <h5 class="card-title">Order Details</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Order Date</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $order->product->product_name }}</td>
                            <td>{{ \Carbon\Carbon::parse($order->order_date)->translatedFormat('d/m/Y H:i') }}</td>
                            <td>Rp {{ number_format($order->total_amount) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-12 mb-4">
            @if ($order->status === 'unpaid')
                <div class="alert alert-warning">
                    Complete your payment.
                    <br>
                </div>
            @endif
        </div>

        <div class="col-12 mb-4">
            @if ($order->status === 'unpaid')
                <div class="qr-code-container">
                    <div class="mt-3">Go To Cashier And Show The QrCode To Pay</div>
                    <br>
                    {!! QrCode::size(200)->generate($order->qr_token) !!}
                </div>
                <br>
            @endif

            <div class="d-flex">
                    <div class="size-208">
                        <span class="mtext-101 cl2">
                            Total:
                        </span>
                    </div>
                    <div class="size-209 p-t-1 flex-w flex-sb">
                        <span class="mtext-110 cl2">
                            Rp {{ number_format($order->total_amount) }}
                        </span>
                        <span class="mtext-110 cl2" style="color: {{ $order->status == 'unpaid' ? 'red' : ($order->status == 'canceled' ? 'gray' : 'green') }}; font-weight: bold;">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                </div>
                <div class="d-flex justify-content-center mt-2">
                    @if ($order->status === 'unpaid')
                    <form action="{{ route('yourorder.cancel', $order->id) }}" method="POST" class="mt-3 w-100">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-dark w-100 rounded-0" onclick="return confirm('Are you sure you want to cancel this order?')">Cancel Order</button>
                    </form>
                    @endif
                </div>
        </div>
    </div>
</div>
@endsection