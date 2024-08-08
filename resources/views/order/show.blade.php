@extends('dashboard.master')
@section('title', 'Order Details')
@section('sidebar')
    @include('dashboard.sidebar')
@endsection
@section('page-title', 'Order Details')
@section('page', 'Order Details')
@section('main')
    @include('dashboard.main')

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header pb-0">
                        <h6>Order Details</h6>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <tr>
                                    <th>Customer Name</th>
                                    <td>{{ $order->customer->user->name }}</td>
                                </tr>
                                <tr>
                                    <th>Product</th>
                                    <td>{{ $order->product->product_name }}</td>
                                </tr>
                                <tr>
                                    <th>Order Date</th>
                                    <td>{{ \Carbon\Carbon::parse($order->order_date)->translatedFormat('d F Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Total Amount</th>
                                    <td>Rp {{ number_format($order->total_amount) }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td style="color: {{ $order->status === 'unpaid' ? 'red' : ($order->status === 'paid' ? 'green' : 'black') }}">
                                        {{ $order->status }}
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-end">
                                        <button type="button" class="btn btn-success">Procces Payment</button>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
