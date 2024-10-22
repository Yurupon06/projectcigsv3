<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Login</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{ isset($setting) && $setting->app_logo ? asset('storage/' . $setting->app_logo) : asset('assets/images/logo_gym.png') }}">

    <!-- Tambahkan Font Awesome untuk ikon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <style>
        body {
            background-color: #1a1a1a;
            color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: 'Poppins', sans-serif;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(255, 75, 43, 0.3);
            padding: 1.5rem;
            background-color: #404040;
            max-width: 90vh;
            margin: auto;
        }

        .card-content {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 1rem;
        }

        .btn-primary {
            background-color: #ff4b2b;
            border: none;
        }

        .btn-primary:hover {
            background-color: #ff1c1c;
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

        .invalid-feedback {
            color: #ff4b2b;
        }

        .form-links {
            color: #ffffff;
            text-align: center;
            display: block;
            margin-top: 1rem;
        }

        .form-links a {
            color: #fff;
            text-decoration: none;
        }

        .form-links a:hover {
            text-decoration: underline;
            color: #ff1c1c;
        }

        h1 {
            font-weight: 600;
            margin-top: 0.10rem;
        }

        .logo {
            margin-bottom: 1rem;
            width: 130px;
            height: auto;
        }

        .card-content {
            text-align: center;
        }

        .input-icon {
            position: absolute;
            top: 50%;
            right: 15px;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
        }

        .input-icon:hover {
            color: #ffffff;
        }

        .position-relative {
            position: relative;
        }

        @media (min-width: 992px) {
            .card {
                padding: 2rem;
                max-width: 500px;
            }
        }
    </style>
</head>

<body>
    <main class="container">
        @if($message = session('success'))
        <div class="alert alert-success my-2 text-success" role="alert">{{ $message }}</div>
        @elseif ($message = session('error'))
        <div class="alert alert-danger my-2 text-danger" role="alert">{{ $message }}</div>
        @endif
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-content d-flex justify-content-center align-items-center">
                        <img src="{{ isset($setting) && $setting->app_logo ? asset('storage/' . $setting->app_logo) : asset('assets/images/logo_gym.png') }}" alt="Logo" class="logo">
                        <h1 class="h3 mb-3 fw-bold text-center">Sign In</h1>
                    </div>
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="form-floating mb-3">
                            <input name="phone" type="phone" class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" id="floatingInput" placeholder="08XXXXXXXXXX" value="{{ old('phone') }}" required>
                            <label for="floatingInput">Phone Number</label>
                            @error('phone')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-floating mb-3 position-relative">
                            <input name="password" type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" id="floatingPassword" placeholder="Password" required>
                            <label for="floatingPassword">Password</label>
                            <i class="fa fa-eye-slash input-icon" id="togglePasswordIcon" onclick="togglePassword()"></i>
                            @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
                        <div class="form-links">
                            <a href="{{ route('register') }}">Register</a> | <a href="{{ route('show-forgot') }}">Forgot Password</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <!-- Script untuk toggle visibility password -->
    <script>
        function togglePassword() {
            var passwordField = document.getElementById("floatingPassword");
            var toggleIcon = document.getElementById("togglePasswordIcon");

            if (passwordField.type === "password") {
                passwordField.type = "text";
                toggleIcon.classList.remove("fa-eye-slash");
                toggleIcon.classList.add("fa-eye");
            } else {
                passwordField.type = "password";
                toggleIcon.classList.remove("fa-eye");
                toggleIcon.classList.add("fa-eye-slash");
            }
        }
    </script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1cnd+0AdAq8ni0Y3C03GA+6GczfURhZgefjMNKDU3KwLLpTt92lW2TdeYifz59C" crossorigin="anonymous"></script>
</body>

</html>
