<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Forgot Password</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ isset($setting) ? asset('storage/' . $setting->app_logo) : asset('assets/images/logo_gym.png') }}">

    <style>
        body {
            background-color: #1a1a1a;
            color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: 'Poppins', sans-serif;
            margin: 0;
        }

        .container {
            padding: 2rem;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(255, 75, 43, 0.3);
            padding: 2rem;
            background-color: #404040;
        }

        .btn-primary {
            background-color: #ff4b2b;
            border: none;
        }

        .btn-primary:hover {
            background-color: #ff1c1c;
        }

        .btn-back {
            background-color: #3c3c3c;
            border: 1px solid #ff4b2b;
            color: #ffffff;
        }

        .btn-back:hover {
            background-color: #ff4b2b;
            border: 1px solid #ff4b2b;
        }

        .form-floating > label {
            color: #bfbfbf;
        }

        .form-floating > .form-control:focus ~ label {
            color: #ffffff;
        }

        .form-control {
            background-color: #3c3c3c;
            color: #ffffff;
            border: 1px solid #ff4b2b;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(255, 75, 43, 0.2);
        }

        .form-control:focus {
            background-color: #3c3c3c;
            color: #ffffff;
            border: 1px solid #ff4b2b;
            box-shadow: 0 4px 10px rgba(255, 75, 43, 0.2);
        }

        .form-control:read-only {
            background-color: #3c3c3c;
            color: #a0a0a0;
            border: 1px solid #ff4b2b;
            box-shadow: 0 4px 10px rgba(255, 75, 43, 0.2);
        }

        .invalid-feedback {
            color: #ff4b2b;
        }

        .card-header {
            text-align: center;
            padding: 0;
        }

        .logo {
            width: 150px;
            height: auto;
        }

        .card-header h1 {
            font-weight: 600;
            margin: 0;
        }

        @media (max-width: 767.98px) {
            .container {
                padding: 2rem 1.5rem;
            }
            .card-header h1 {
                font-size: 1.5rem;
            }
        }

        @media (max-width: 575.98px) {
            .container {
                padding: 2rem 1rem;
            }
            .card-header h1 {
                font-size: 1.25rem;
            }
        }
    </style>
</head>

<body>
    <main class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 col-sm-10">
                <div class="card">
                    <div class="card-header">
                        <img src="{{ isset($setting) ? asset('storage/' . $setting->app_logo) : asset('assets/images/logo_gym.png') }}" alt="Logo" class="logo">
                        <h1 class="h3">Forgot Password</h1>
                    </div>
                    <div class="card-body">
                        @if($message = session('status'))
                        <div class="alert alert-success my-2 text-success" role="alert">{{ $message }}</div>
                        @endif
                        <p>Enter your phone number to receive OTP</p>
                        <form action="{{ route('send-otp-forgot-password') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <input name="phone" type="text" oninput="this.value = this.value.replace(/[^0-9]/g, '');" maxlength="13" class="form-control text-center @error('phone') is-invalid @enderror" id="floatingInput" placeholder="08XXXXXXXXXX" value="{{ auth()->user()->phone ?? old('phone') }}" {{ isset(auth()->user()->phone) ? 'readonly' : 'required' }}>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button class="w-100 btn btn-primary" type="submit">Send OTP</button>
                        </form>
                        <a href="{{ isset(auth()->user()->phone) ? url()->previous() : route('login') }}" class="btn btn-back w-100 mt-3">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1cnd+0AdAq8ni0Y3C03GA+6GczfURhZgefjMNKDU3KwLLpTt92lW2TdeYifz59C" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if (Session::has('error'))
            {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '{{ Session::get('error') }}',
                })
            }
        @endif
    </script>
    <script>
        function maxLength(input) {
            const maxLength = 13;
            if (input.value.length > maxLength) {
                input.value = input.value.slice(0, maxLength);
            }
        }
    </script>
</body>

</html>