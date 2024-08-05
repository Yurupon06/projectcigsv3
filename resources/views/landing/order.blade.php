// resources/views/order/index.blade.php

@extends('dashboard.master')
@extends('landing.master')
@include('landing.header')

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
                {{ $order->order_date }}
            </td>
            <td>
                Rp.{{ number_format($order->total_amount, 2) }}
            </td>
            <td>
                <span style="color: {{ $order->status == 'unpaid' ? 'red' : ($order->status == 'canceled' ? 'gray' : 'green') }}; font-weight: bold;">
                    {{ ucfirst($order->status) }}
                </span>
            </td>
            <td class="align-middle text-center text-sm">
                @if($order->status == 'unpaid')
                <form action="" method="POST" style="display:inline;">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="badge badge-sm bg-gradient-success">Pay</button>
                </form>
                @endif
                @if($order->status != 'canceled')
                <form action="" method="POST" style="display:inline;">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="badge badge-sm bg-gradient-danger" onclick="return confirm('Are you sure you want to cancel this order?')">Cancel</button>
                </form>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
