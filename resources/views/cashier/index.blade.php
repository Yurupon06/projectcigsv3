@extends('cashier.master')
@section('title', 'Cashier')
@section('sidebar')
    @include('cashier.sidebar')
@endsection
@section('page-title', 'Cashier')
@section('page', 'Cashier')
@section('main')
    @include('cashier.main')
    <style>
        #reader {
            width: 100%;
            height: auto;
            margin: auto;
            max-height: 350px;
            overflow: hidden;
            position: absolute;
            justify-content: center;
        }

        #reader video {
            transform: scaleX(-1);
        }

        .card-body .table-responsive .table th,
        .card-body .table-responsive .table td {
            font-size: 12px;
        }

        .card-header h6,
        .card-body .table-responsive .table th,
        .card-body .table-responsive .table td {
            font-size: 13px;
        }
        
        @media (max-width: 767px) {
            .qr-section {
                display: flex;
                justify-content: center;
                margin-top: 20px;
            }

            .qr-section .card {
                height: auto;
            }

            .container-fluid {
                padding-left: 15px;
                padding-right: 15px;
            }

            .input-group {
                max-width: 100%;
            }

            .card {
                margin-top: 80px;
            }

            .card .input-group {
                max-width: 100%;
            }

            .card-body .table-responsive {
                overflow-x: auto;
            }

            .card-header h6 {
                font-size: 14px;
            }
        }
        @media (max-width: 992px) {
            .card-body {
                display: flex;
                justify-content: center;
                align-items: center;
                flex-direction: column;
            }
            video {
                width: 100%;
            }
        }
    </style>

    <div class="container-fluid pt-4 mt-4">
        <div class="row">
            <div class="col-lg-8 col-md-12 d-flex flex-column mb-4">
                <div class="card mt-4">
                    <div class="card-header py-1">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <h6>Cashier</h6>
                            <div class="input-group" style="max-width: 200px;">
                                <form method="GET" action="{{ route('cashier.index') }}" class="d-flex w-100 pt-2">
                                    <input type="text" name="search" class="form-control"
                                        placeholder="Search orders" value="{{ request('search') }}"
                                        style="border-radius: 15px 0 0 15px; height: 32px; font-size: 12px;">
                                    <button type="submit" class="btn btn-primary"
                                        style="background-color: #ff7e00; border-radius: 0 15px 15px 0; height: 32px; padding: 0 10px; font-size: 12px;">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-1">
                        <div class="table-responsive">
                            <table class="table align-items-center mb-0" id="datatable">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Name</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Product</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Order Date</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Total Amount</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $i => $dt)
                                        <tr>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">name</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">product</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">order date</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">total amount</th>
                                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">status</th>
                                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $i => $dt)
                                            <tr>
                                                <td>
                                                    <div class="d-flex px-2 py-1">
                                                        {{ $i + 1 + ($orders->currentPage() - 1) * $orders->perPage() }}
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
                                                <td class="align-middle text-center text-sm">
                                                    <a href="{{route('cashier.qrscan', $dt->qr_token)}}">
                                                    <span class="btn bg-gradient-info ws-15 my-4 mb-2 btn-sm">Detail</span>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                {{ $orders->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-12 qr-section mt-4 mt-lg-0">
                <div class="card mt-4 tbl" style="height: 100%;">
                    <div class="card-header py-2 text-center">
                        <h6 class="m-2">Scanner For Order</h6>
                    </div>
                    <div class="card-body">
                        <div id="reader"></div>
                        <div class="mt-3 text-center">
                            <button id="toggle-scan-btn" class="btn btn-primary">Start Scan</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/html5-qrcode/minified/html5-qrcode.min.js"></script>
    <script>
        let html5QrcodeScanner = new Html5Qrcode("reader");
        let isScanning = false;

        function onScanSuccess(decodedText, decodedResult) {
            let qrToken = decodedText.trim();
            let url = `{{ route('cashier.qrscan', ['qr_token' => '__TOKEN__']) }}`.replace('__TOKEN__', qrToken);
            window.location.href = url;
        }

        function onScanFailure(error) {
            console.warn(`Code scan error = ${error}`);
        }

        document.getElementById('toggle-scan-btn').addEventListener('click', function() {
            if (isScanning) {
                html5QrcodeScanner.stop().then(() => {
                    document.getElementById('toggle-scan-btn').textContent = 'Start Scan';
                    isScanning = false;
                }).catch(err => {
                    console.error("Error stopping QR code scanner: ", err);
                });
            } else {
                html5QrcodeScanner.start(
                    { facingMode: "environment" },
                    {
                        fps: 30,
                        qrbox: 350
                    },
                    onScanSuccess,
                    onScanFailure
                ).then(() => {
                    document.getElementById('toggle-scan-btn').textContent = 'Stop Scan';
                    isScanning = true;
                }).catch(err => {
                    console.error("Error starting QR code scanner: ", err);
                });
            }
        });
    </script>
@endsection