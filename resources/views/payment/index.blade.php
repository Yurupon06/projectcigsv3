@extends('dashboard.master')
@section('title', isset($setting) ? $setting->app_name . ' - Payment' : 'Payment')
@section('sidebar')
    @include('dashboard.sidebar')
@endsection
@section('page-title', 'Payment')
@section('page', 'Payment')
@section('main')
    @include('dashboard.main')

    <style>
        .hidden {
            display: none;
        }
    </style>

    <div class="container-fluid pb-4">
        <div class="row">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header pb-0 py-1">
                        <div class="d-flex  align-items-center">
                        <a href="{{ route('payment.index', ['filter' => 'membership', 'search' => request('search'), 'per_page' => request('per_page')]) }}" type="button" 
                        class=" {{ request('filter') == 'membership' ? 'active' : '' }} btn btn-primary btn-sm align-items-center btn-membership" 
                        style="font-size: 12px; padding: 10px 12px; background-color: #ff5c00; box-shadow: 0 4px 6px rgba(0, 0, 255, 0.1); border: none;">
                            <i class="fas fa-user-tag me-2" style="font-size: 18px;"></i> Membership
                        </a>
                        <a href="{{route('payment.index', ['filter' => 'complement', 'per_page' => request('per_page')]) }}" type="button" 
                        class=" {{ request('filter') == 'complement' ? 'active' : '' }} btn btn-sm align-items-center btn-complement mx-2" 
                        style="font-size: 12px; padding: 10px 12px; background-color:#007bff; color: white; box-shadow: 0 4px 6px rgba(255, 165, 0, 0.1); border: none;">
                            <i class="fas fa-shopping-basket me-2" style="font-size: 18px;"></i> Complement
                        </a>

                            <!-- Form search -->
                            <div class="input-group" style="max-width: 300px; margin-left: auto;">
                                <form method="GET" action="{{ route('payment.index') }}" class="d-flex w-100 pt-2">
                                    <input type="text" name="search" class="form-control"
                                        placeholder="Search Payments" value="{{ request('search') }}"
                                        style="border-radius: 20px 0 0 20px; height: 38px; font-size: 14px;">
                                        <input type="hidden" name="filter" value="{{ request('filter') }}">
                                    <button type="submit" class="btn btn-primary"
                                        style="background-color: #ff7e00; border-radius: 0 20px 20px 0; height: 38px; padding: 0 10px; font-size: 14px;">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </form>
                            </div>

                            <!-- Form Pagination -->
                            <div class="d-flex align-items-center my-3" style="margin-left: auto">
                                <form method="GET" action="{{ route('payment.index') }}" class="d-flex">
                                    <select name="filter" id="filter" class="form-select form-select-sm w-auto me-3 hidden" onchange="this.form.submit()">
                                        <option value="membership" {{ request('filter') == 'membership' ? 'selected' : '' }}>Membership</option>
                                        <option value="complement" {{ request('filter') == 'complement' ? 'selected' : '' }}>Complement</option>
                                    </select>

                                    <!-- Pagination Control -->
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
                            @if(request('filter') == 'membership' || !request('filter'))
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Customer Name</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Order ID</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Product</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Amount</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Amount Given</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Change</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Payment Date</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $no = $payment->firstItem();
                                    @endphp
                                    @foreach ($payment as $i => $dt)
                                        <tr>
                                            @if(request('filter') == 'membership' || !request('filter'))
                                            
                                                @if($dt->order)
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        {{ $no++ . ' . ' }}
                                                    </div>
                                                </td>
                                                    <td>
                                                        {{ $dt->order->customer->user->name }}
                                                    </td>
                                                    <td>
                                                        <div class="d-flex px-2 py-1">
                                                            {{ $dt->order->id }}
                                                        </div>
                                                    </td>
                                           
                                                    <td>
                                                        {{ $dt->order->product->product_name }}
                                                    </td>

                                                    <td>
                                                        Rp {{ number_format($dt->amount) }}
                                                    </td>
                                                    <td>
                                                        Rp {{ number_format($dt->amount_given) }}
                                                    </td>
                                                    <td>
                                                        Rp {{ number_format($dt->change) }}
                                                    </td>
                                                    <td>
                                                        {{ \Carbon\Carbon::parse($dt->payment_date)->translatedFormat('d F Y H:i') }}
                                                    </td>

                                                    <td style="color: {{ $dt->order->status === 'unpaid' ? 'red' : ($dt->order->status === 'paid' ? 'green' : 'black') }}">
                                                        {{ $dt->order->status }}
                                                    </td>
                                                @endif
                                            @endif    
                                        </tr>
                                    @endforeach
                                </tbody>
                            @endif
                                @if(request('filter') == 'complement')
                                    <thead>
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                                           <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Order Complement</th>
                                            <!-- <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Complement</th> -->
                                            <!-- <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Quantity</th> -->
                                            <!-- <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Price</th> -->
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Amount</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Amount Given</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Change</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Payment Date</th>                         
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @php
                                        $no = $payment->firstItem();
                                    @endphp
                                    @foreach ($payment as $i => $dt)
                                        <tr>
                                            @if(request('filter') == 'complement')
                                                @if($dt->orderComplement)
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        {{ $no++ . ' . ' }}
                                                    </div>
                                                </td>
                                                    <td>
                                                        {{ $dt->ordercomplement->id }}
                                                    </td>
                                                    <!-- <td>
                                                        {{ $dt->ordercomplement->name }} 
                                                    </td> -->
                                                    <!-- <td>
                                                            {{$dt->quantity }}
                                                    </td> -->
                                                    <!-- <td>
                                                        Rp {{ number_format($dt->ordercomplement->price) }}
                                                    </td> -->
                                                    <td>
                                                        Rp {{ number_format($dt->amount) }}
                                                    </td>
                                                    <td>
                                                        Rp {{ number_format($dt->amount_given) }}
                                                    </td>
                                                    <td>
                                                        Rp {{ number_format($dt->change) }}
                                                    </td>
                                                    <td>
                                                        {{ \Carbon\Carbon::parse($dt->payment_date)->translatedFormat('d F Y H:i') }}
                                                    </td>
                                                @endif
                                            @endif
                                        </tr>
                                    @endforeach
                                @endif
                            </table>
                        </div>
                    </div>

                    <!-- Pagination Links -->
                    <div class="container-fluid">
                        <div class="row">
                            @if (request('filter') == 'membership')
                                {{ $payment->appends(['filter' => 'membership', 'search' => request('search'), 'per_page' => request('per_page')])->links('pagination::bootstrap-5') }}
                            @elseif (request('filter'))
                                {{ $payment->appends(['filter' => 'complement', 'search' => request('search'), 'per_page' => request('per_page')])->links('pagination::bootstrap-5') }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection