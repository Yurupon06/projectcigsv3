@extends('cashier.master')
@section('title', isset($setting) ? $setting->app_name . ' - Payment Detail' : 'Payment Detail')
@section('sidebar')
    @include('cashier.sidebar')
@endsection
@section('page-title', 'Payment Detail')
@section('page', 'Payment Details')
@section('main')
    @include('cashier.main')

    <style>
        .navigation-links {
        display: flex;
        justify-content: space-between;
        }

        .navigation-links a {
            text-decoration: none;
            color: #007BFF;
            font-weight: bold;
        }

        .navigation-links a:hover {
            text-decoration: underline;
        }

        .details-table {
            margin-top: 1rem;
            width: 100%;
        }

        .details-table th {
            text-align: left;
            padding-right: 10px;
        }

        .details-table td {
            padding-bottom: 0.5rem;
        }

        .status {
            color: {{ $dpayment->order->status === 'unpaid' ? 'red' : ($dpayment->order->status === 'paid' ? 'green' : 'black') }};
            font-weight: bold;
        }
    </style>

    <div class="container-fluid py-4 mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header py-2 navigation-links">
                        <a href="{{ route('cashier.payment') }}">Back</a>
                    </div>
                    <div class="card-header py-1 mt-1">
                        <h6>Payment Details</h6>
                    </div>
                    <div class="card-body py-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <tr>
                                    <th>Customer Name</th>
                                    <td>{{ $dpayment->order->customer->user->name }}</td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td>{{ $dpayment->order->customer->user->email }}</td>
                                </tr>
                                <tr>
                                    <th>Phone</th>
                                    <td>{{ $dpayment->order->customer->phone }}</td>
                                </tr>
                                <tr>
                                    <th>Order ID</th>
                                    <td>{{ $dpayment->order->id }}</td>
                                </tr>
                                <tr>
                                    <th>Product</th>
                                    <td>{{ $dpayment->order->product->product_name }}</td>
                                </tr>
                                <tr>
                                    <th>Amount</th>
                                    <td>Rp {{ number_format($dpayment->amount) }}</td>
                                </tr>
                                <tr>
                                    <th>Amount Given</th>
                                    <td>Rp {{ number_format($dpayment->amount_given) }}</td>
                                </tr>
                                <tr>
                                    <th>Change</th>
                                    <td>Rp {{ number_format($dpayment->change) }}</td>
                                </tr>
                                <tr>
                                    <th>Payment Date</th>
                                    <td>{{ \Carbon\Carbon::parse($dpayment->payment_date)->translatedFormat('d F Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td class="status">{{ $dpayment->order->status }}</td>
                                </tr>
                                <tr><td></td></tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
