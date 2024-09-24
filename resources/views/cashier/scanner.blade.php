@extends('dashboard.master')
@section('title',  isset($setting) ? $setting->app_name : ' - Scanner' ?? 'Scanner')
@section('sidebar')
    @include('cashier.sidebar')
@endsection
@section('page-title', 'Scanner')
@section('page', 'Scanner')
@section('main')
    @include('cashier.main')
    <style>
        #reader {
            width: 500px;
            height: 500px;
            margin: auto;
        }

        #reader video {
            transform: scaleX(-1);
        }
    </style>

    <div class="container mt-5 text-center">
        {{-- <h1>Scan QR Code</h1> --}}
        <div id="reader"></div>
        <p id="result"></p>
        <a class="btn btn-outline-primary" href="{{ route('cashier.index') }}" role="button">Back</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/html5-qrcode/minified/html5-qrcode.min.js"></script>
    <script>
        function onScanSuccess(decodedText, decodedResult) {
            // Trim the decoded text to avoid extra spaces
            let qrToken = decodedText.trim();

            // Construct the URL using the scanned QR token
            let url = `{{ route('cashier.qrscan', ['qr_token' => '__TOKEN__']) }}`.replace('__TOKEN__', qrToken);

            // Redirect to the constructed URL
            window.location.href = url;
        }

        function onScanFailure(error) {
            console.warn(`Code scan error = ${error}`);
        }

        let html5QrcodeScanner = new Html5Qrcode("reader");
        html5QrcodeScanner.start({
                facingMode: "environment"
            }, {
                fps: 30,
                qrbox: 500
            },
            onScanSuccess,
            onScanFailure
        ).catch(err => {
            console.error("Error starting QR code scanner: ", err);
        });
    </script>
@endsection
