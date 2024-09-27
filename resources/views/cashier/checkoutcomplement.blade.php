@extends('cashier.master')
@section('title', isset($setting) ? $setting->app_name . ' - Add Order' : 'Add Order')
@section('sidebar')
    @include('cashier.sidebar')
@endsection
@section('page-title', 'Add Order')
@section('page', 'Customer / Create')
@section('main')
    @include('cashier.main')
    <div class="container mt-4">
        <h1 class="mb-4">Order Details - Order # {{ $orderComplement->id }}</h1>
    
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
    
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Order # {{ $orderComplement->id }}</h5>
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Complement</th>
                            <th>Quantity</th>
                            <th>Sub Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orderDetails as $dt)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('storage/' . $dt->complement->image) }}" alt="{{ $dt->complement->name }}" class="img-thumbnail" style="width: 50px; height: 50px; margin-right: 10px;">
                                        {{ $dt->complement->name }}
                                    </div>
                                </td>
                                <td>{{ $dt->quantity }}</td> 
                                <td>{{ number_format($dt->sub_total, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2" class="text-right"><strong>Total</strong></td>
                            <td><strong>{{ number_format($orderDetails->sum('sub_total'), 2) }}</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
            <div class="card-footer d-flex justify-content-end gap-2">
                <form action="" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary">Proceed to Payment</button>
                </form>
                <form action="" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">Cancel</button>
                </form>
            </div>
        </div>
    </div>
@endsection
