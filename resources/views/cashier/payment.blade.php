@extends('cashier.master')
@section('title', isset($setting) ? $setting->app_name . ' - Payment' : 'Payment')
@section('sidebar')
    @include('cashier.sidebar')
@endsection
@section('page-title', 'Payment')
@section('page', 'Payment')
@section('main')
	@include('cashier.main')
    <style>
        .u {
        font-weight: bold;
        text-decoration: none;
        }

        .u:hover {
            color: #ff7e00;
        }

        .hidden {
            display: none;
        }

        @media screen and (max-width: 768px) {
                .page {
                display: none;
            }

            .input-group {
                margin-right: 8px;
            }
        }
        .btn-group{
            padding-top: 50px;
        }
    </style>
	
    <div class="container-fluid py-4 mt-4">
        <div class="row">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="btn-group" role="group" aria-label="Basic example">
                <a href="{{ route('cashier.payment', ['filter' => 'membership', 'search' => request('search'), 'per_page' => request('per_page')]) }}" 
                   class="btn btn-primary {{ request('filter') == 'membership' ? 'active' : '' }}">
                    MEMBERSHIP
                </a>
                <a href="{{ route('cashier.payment', ['filter' => 'complement', 'per_page' => request('per_page')]) }}" 
                   class="btn btn-primary {{ request('filter') == 'complement' ? 'active' : '' }}">
                    COMPLEMENT
                </a>
            </div>
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header pb-0 py-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <h6 class="mb-2 page">Payment</h6>
                            <div class="input-group" style="max-width: 300px;">
                                <form method="GET" action="{{ route('cashier.payment') }}" class="d-flex w-100 pt-2">
                                    <input type="text" name="search" class="form-control"
                                        placeholder="Search Payments" value="{{ request('search') }}"
                                        style="border-radius: 20px 0 0 20px; height: 38px; font-size: 14px;">
                                    <input type="hidden" name="filter" value="{{ request('filter') }}"> 
                                    <button type="submit" class="btn btn-primary"
                                        style="background-color: #ff7e00; border-radius: 0 20px 20px 0; height: 38px; padding: 0 10px; font-size: 14px;">
                                        <i class="fas fa-search"></i>
                                    </button>
                                    <input type="hidden" name="per_page" value="{{ request('per_page') }}">
                                </form>
                            </div>
                            <div class="d-flex align-items-center my-3">
                                <form method="GET" action="{{ route('cashier.payment') }}" class="d-flex">
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
                            <table class="table align-items-center mb-0" id="datatable">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                                        @if(request('filter') == 'membership' || !request('filter'))
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Customer Name</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">order id</th>
                                        @elseif(request('filter') == 'complement')
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Customer Name</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">order complement</th>
                                        @endif
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">amount</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">payment date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($payments as $i => $dt)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                {{ $payments->firstItem() + $i }}
                                            </div>
                                        </td>
                            
                                        @if(request('filter') == 'membership' || !request('filter'))
                                            @if($dt->order)
                                                <td>
                                                    <a class="u" href="{{ route('cashier.detailpayment', $dt->id )}}">
                                                    {{ $dt->order->customer->user->name }}</a>
                                                </td>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        {{ $dt->order->id }}
                                                    </div>
                                                </td>
                                            @endif
                                        @elseif(request('filter') == 'complement')
                                            @if($dt->orderComplement)
                                                <td>
                                                    {{ $dt->ordercomplement->user->name }}</a>
                                                </td>
                                                <td>
                                                    <a class="u" href="{{ route('cashier.checkout', $dt->ordercomplement->qr_token )}}">
                                                    {{ $dt->ordercomplement->id }}
                                                    </a>
                                                </td>
                                            @endif
                                        @endif
                            
                                        <td>
                                            Rp {{ number_format($dt->amount) }}
                                        </td>
                                        <td>
                                            {{ \Carbon\Carbon::parse($dt->payment_date)->translatedFormat('d F Y H:i') }}
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
                                {{ $payments->appends(request()->except('page'))->links('pagination::bootstrap-5') }}

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection