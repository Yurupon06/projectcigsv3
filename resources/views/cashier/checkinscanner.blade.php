<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Check In Scanner</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        #reader {
            width: 500px;
            height: 500px;
            margin: auto;
        }

        #reader video {
            transform: scaleX(-1);
        }

        table td{
            text-align: left;
            font-size: 1.4rem;
            padding: 5px;
        }
    </style>
</head>
<body>
    <div class="container mt-5 text-center">
        <h1>Scan QR Code</h1>
        <div class="row">
            <div class="col-md-6">
                <div id="reader"></div>
            </div>
            <div class="col-md-6">
                <div id="result">
                    <table>
                        <tr>
                            <td><b>Nama</b></td>
                            <td>:</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><b>No. Hp</b></td>
                            <td>:</td>
                            <td></td>
                        </tr>
                        <tr>
                            <td><b>Expiration Date</b></td>
                            <td>:</td>
                            <td></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
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
</body>
</html>
