@extends('dashboard.master')
@section('title', 'Order')
@section('sidebar')
    @include('dashboard.sidebar')
@endsection
@section('page-title', 'Order')
@section('page', 'Order')
@section('main')
    @include('dashboard.main')

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header pb-0  py-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6>Order</h6>
                            <div class="input-group" style="max-width: 300px;">
                                <form method="GET" action="{{ route('order.index') }}" class="d-flex w-100 pt-2">
                                    <input type="text" name="search" class="form-control"
                                        placeholder="Search Order" value="{{ request('search') }}"
                                        style="border-radius: 20px 0 0 20px; height: 38px; font-size: 14px;">
                                    <button type="submit" class="btn btn-primary"
                                        style="background-color: #ff7e00; border-radius: 0 20px 20px 0; height: 38px; padding: 0 10px; font-size: 14px;">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="d-flex align-items-center my-3">
                                <form method="GET" action="{{ route('order.index') }}" class="d-flex">
                                    <label for="per_page" class="form-label me-2 mt-2">Show:</label>
                                    <select name="per_page" id="per_page" class="form-select form-select-sm w-auto me-3" onchange="this.form.submit()">
                                        <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
                                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                    </select>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">name</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">product</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">order date</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">total amount</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order as $i => $dt)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    {{ ($order->currentPage() - 1) * $order->perPage() + $i + 1 . ' . ' }}
                                                </div>
                                            </td>
                                            <td>
                                                {{ $dt->customer->user->name }}
                                            </td>
                                            <td>
                                                {{ $dt->product->product_name }}
                                            </td>
                                            <td>
                                                {{ \Carbon\Carbon::parse($dt->order_date)->translatedFormat('d F Y H:i') }}
                                            </td>
                                            <td>
                                                Rp {{ number_format($dt->total_amount) }}
                                            </td>
                                            <td
                                                style="color: {{ $dt->status === 'unpaid' ? 'red' : ($dt->status === 'paid' ? 'green' : 'black') }}">
                                                {{ $dt->status }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                {{ $order->appends(request()->except('page'))->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection