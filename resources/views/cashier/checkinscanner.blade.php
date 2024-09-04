<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Check In Scanner</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" type="image/png"
        href="{{ isset($setting) && $setting->app_logo ? asset('storage/' . $setting->app_logo) : asset('assets/images/logo_gym.png') }}">

    <style>
        #reader {
            width: 100%;
            height: 500px;
            margin: auto;
        }

        #reader video {
            transform: scaleX(-1);
        }

        table td {
            text-align: left;
            font-size: 1.4rem;
            padding: 5px;
        }

        #success-message,
        #error-message,
        #countdown {
            display: none;
        }
    </style>
</head>

<body>
    <div class="container mt-5 text-center">
        @if (session('message'))
            <script>
                alert('{{ session('message') }}');
            </script>
        @endif
        <h1>Scan QR Code</h1>
        <div class="row">
            <div class="col-md-6">
                <div id="reader"></div>
            </div>
            <div class="col-md-6">
                <div id="result">
                    <table class="table table-bordered">
                        <tr>
                            <td><b>Nama</b></td>
                            <td id="name"></td>
                        </tr>
                        <tr>
                            <td><b>No. Hp</b></td>
                            <td id="phone"></td>
                        </tr>
                        <tr>
                            <td><b>Expiration Date</b></td>
                            <td id="expiration"></td>
                        </tr>
                    </table>
                </div>
                <div id="success-message" class="alert alert-success">
                    Scan Successfully!
                </div>
                <div id="error-message" class="alert alert-danger"></div>
                <div id="countdown" class="alert alert-info"></div>
            </div>
        </div>
        <a class="btn btn-outline-primary" href="{{ route('cashier.membercheckin') }}" role="button">Back</a>
    </div>

    <!-- Success and error sounds -->
    <audio id="success-sound" src="../../assets/sound/success.mp3"></audio>
    <audio id="error-sound" src="../../assets/sound/Error2.mp3"></audio>

    <script src="https://cdn.jsdelivr.net/npm/html5-qrcode/minified/html5-qrcode.min.js"></script>
    <script>
        let scanCompleted = false;
        let html5QrcodeScanner = new Html5Qrcode("reader");

        function onScanSuccess(decodedText) {
            if (scanCompleted) return;

            scanCompleted = true;

            fetch(`/member-details/${decodedText}`)
                .then(response => response.json())
                .then(data => {
                    if (data.error) {
                        const errorMessage = document.getElementById('error-message');
                        errorMessage.textContent = data.error;
                        errorMessage.style.display = 'block';
                        scanCompleted = false;

                        document.getElementById('error-sound').play();

                        setTimeout(() => {
                            errorMessage.style.display = 'none';
                        }, 3000);
                    } else {
                        document.getElementById('name').textContent = data.name;
                        document.getElementById('phone').textContent = data.phone;
                        document.getElementById('expiration').textContent = data.expired_date;

                        const successMessage = document.getElementById('success-message');
                        const countdown = document.getElementById('countdown');
                        const errorMessage = document.getElementById('error-message');
                        successMessage.style.display = 'block';
                        countdown.style.display = 'block';
                        errorMessage.style.display = 'none';

                        document.getElementById('success-sound').play();

                        let countdownValue = 5;

                        const interval = setInterval(() => {
                            countdown.textContent = `Refreshing in ${countdownValue} seconds...`;
                            countdownValue--;

                            if (countdownValue < 0) {
                                clearInterval(interval);
                                countdown.style.display = 'none';
                                location.reload();
                            }
                        }, 1000);

                        fetch('/store-checkin', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                                        'content')
                                },
                                body: JSON.stringify({
                                    qr_token: decodedText,
                                    image: null
                                })
                            })
                            .then(response => response.json())
                            .then(result => {
                                if (result.success) {
                                    console.log('Check-in recorded successfully');
                                    console.log('New QR token:', result.new_qr_token);
                                } else {
                                    const errorMessage = document.getElementById('error-message');
                                    errorMessage.textContent = result.message;
                                    errorMessage.style.display = 'block';

                                    document.getElementById('error-sound').play();

                                    setTimeout(() => {
                                        errorMessage.style.display = 'none';
                                    }, 3000);
                                }
                            })
                            .catch(error => console.error('Error:', error));

                        html5QrcodeScanner.stop().then(ignore => {
                            console.log("QR code scanning stopped.");
                        }).catch(err => {
                            console.error("Error stopping QR code scanning:", err);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error fetching member details:', error);
                    const errorMessage = document.getElementById('error-message');
                    errorMessage.textContent = 'Invalid Qr.';
                    errorMessage.style.display = 'block';

                    document.getElementById('error-sound').play();

                    scanCompleted = false;

                    setTimeout(() => {
                        errorMessage.style.display = 'none';
                    }, 3000);
                });
        }

        html5QrcodeScanner.start({
                facingMode: "environment"
            }, {
                fps: 30,
                qrbox: 500
            },
            onScanSuccess
        ).catch(err => {
            console.error("Error starting QR code scanner: ", err);
        });
    </script>
</body>

</html>
