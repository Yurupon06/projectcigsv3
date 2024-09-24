<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>{{ $setting->app_name }} - Reset Password</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
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
            background-color: #333333;
            border: none;
            color: #ffffff;
        }

        .btn-back:hover {
            background-color: #555555;
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

        .form-control[name="email"] {
            background-color: #4a4a4a; 
        }

        .form-control[name="email"]::placeholder {
            color: #b0b0b0; 
        }

        .invalid-feedback {
            color: #ff4b2b;
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0; 
        }

        .logo {
            width: 150px;
            height: auto;
        }

        h1 {
            font-weight: 600;
            margin-bottom: 1rem;
        }

        @media (max-width: 767.98px) {
            .container {
                padding: 2rem 1.5rem; 
            }
            h1 {
                font-size: 1.5rem; 
            }
        }

        @media (max-width: 575.98px) {
            .container {
                padding: 2rem 1rem; 
            }
            h1 {
                font-size: 1.25rem;
            }
        }
    </style>
</head>

<body>
    <main class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if($message = session('status'))
                    <div class="alert alert-success my-2 text-success" role="alert">{{ $message }}</div>
                @endif
                <div class="card">
                    <div class="card-header text-center">
                        <img src="{{  $setting->app_logo ? asset('storage/' . $setting->app_logo) : asset('assets/images/logo_gym.png') }}" alt="Logo" class="logo">
                        <h1 class="h3 mb-3 fw-normal">Reset Password</h1>
                    </div>
                    <form class="card-body" action="{{ route('reset') }}" method="POST">
                        @csrf
                        <input name="token" type="hidden" value="{{ request('token') }}">

                        <div class="mb-3">
                            <label for="floatingInput" class="form-label">Email address</label>
                            <input name="email" type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" id="floatingInput" placeholder="name@example.com" value="{{ old('email', request('email')) }}" readonly>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="floatingPassword" class="form-label">Password</label>
                            <input name="password" type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" id="floatingPassword" placeholder="Password">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="floatingPasswordConfirm" class="form-label">Password Confirmation</label>
                            <input name="password_confirmation" type="password" class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}" id="floatingPasswordConfirm" placeholder="Confirm Password">
                            @error('password_confirmation')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <button class="w-100 btn btn-primary btn-lg mb-3" type="submit">Submit</button>
                        <a href="{{ url()->previous() }}" class="btn btn-back w-100">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1cnd+0AdAq8ni0Y3C03GA+6GczfURhZgefjMNKDU3KwLLpTt92lW2TdeYifz59C" crossorigin="anonymous"></script>
</body>

</html>
