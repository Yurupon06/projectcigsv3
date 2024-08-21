@extends('dashboard.master')
@section('title', 'Order Details')
@section('sidebar')
    @include('cashier.sidebar')
@endsection
@section('page-title', 'Order Detail')
@section('page', 'Order Details')
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
        <h1>Scan QR Code</h1>
        <div id="reader"></div>
        <p id="result"></p>
        <a class="btn btn-outline-primary" href="{{route('cashier.index')}}" role="button">Back</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/html5-qrcode/minified/html5-qrcode.min.js"></script>
    <script>
        function onScanSuccess(decodedText, decodedResult) {
            // Redirect to the URL decoded from the QR code
            window.location.href = decodedText;
        }

        function onScanFailure(error) {
            console.warn(`Code scan error = ${error}`);
        }

        let html5QrcodeScanner = new Html5Qrcode("reader");
        html5QrcodeScanner.start(
            { facingMode: "environment" },
            {
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