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
            height: 350px;
            margin: auto;
        }

        #reader video {
            transform: scaleX(-1);
        }

        .tbl {
            min-height: 100%;
        }
    </style>
    
    <div class="container-fluid py-4 mt-4">
        <div class="row">
            <div class="col-md-12 d-flex">
                <div class="col-md-8 me-2" style="overflow: hidden;">
                    <div class="card my-4">
                        <div class="card-header pb-0">
                            <div class="d-flex justify-content-between align-items-center">
                                <h6 class="mb-2">Cashier</h6>
                                <div class="input-group mb-2" style="max-width: 300px;">
                                    <form method="GET" action="{{ route('cashier.index') }}" class="d-flex w-100">
                                        <input type="text" name="search" class="form-control" placeholder="Search orders" value="{{ request('search') }}" style="border-radius: 20px 0 0 20px; height: 38px;">
                                        <button type="submit" class="btn btn-primary" style="background-color: #ff7e00; border-radius: 0 20px 20px 0; height: 38px; padding: 0 15px;">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </form>
                                </div>

                            </div>
                        </div>
                        <div class="card-body px-0 pb-1">
                            <div class="table-responsive p-0">
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
                                                <td style="color: {{ $dt->status === 'unpaid' ? 'red' : ($dt->status === 'paid' ? 'green' : 'black') }}">
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
                                    {{ $orders->links('pagination::bootstrap-5') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 qr-section">
                    <div class="card mt-4 tbl" style="height: 92%;">
                        <div class="card-header">
                            <h6>Scanner For Order</h6>
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
