
@extends('dashboard.master')
@extends('landing.master')
@include('landing.header')

@if(session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
@endif
<table class="table align-items-center mb-0">
    <thead>
        <tr>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Name</th>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Product Name</th>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Order Date</th>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Total Amount</th>
            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)
        <tr>
            <td>
                <div class="d-flex px-2 py-1">
                    {{ $loop->iteration }}.
                </div>
            </td>
            <td>
                {{ $order->customer->user->name }}
            </td>
            <td>
                {{ $order->product->product_name }}
            </td>
            <td>
                {{ \Carbon\Carbon::parse($order->order_date)->translatedFormat('d F Y H:i') }}
            </td>
            <td>
                Rp {{ number_format($order->total_amount) }}
            </td>
            <td>
                <span style="color: {{ $order->status == 'unpaid' ? 'red' : ($order->status == 'canceled' ? 'gray' : 'green') }}; font-weight: bold;">
                    {{ ucfirst($order->status) }}
                </span>
            </td>
            <td class="align-middle text-center text-sm">
                <a href="{{ route('checkout', $order->id) }}"><span class="badge badge-sm bg-gradient-info">Detail</span></a>
        </tr>
        @endforeach
    </tbody>
</table>
