
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
                Rp.{{ number_format($order->total_amount) }}
            </td>
            <td>
                <span style="color: {{ $order->status == 'unpaid' ? 'red' : ($order->status == 'canceled' ? 'gray' : 'green') }}; font-weight: bold;">
                    {{ ucfirst($order->status) }}
                </span>
            </td>
            <td class="align-middle text-center text-sm">
                <a href="{{ route('checkout', $order->id) }}"><span class="badge badge-sm bg-gradient-success">Pay</span></a>
                <form action="" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="badge badge-sm bg-gradient-danger" onclick="return confirm('Are you sure you want to Cancel this order?')">Cancel</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
