<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Register</title>

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
            margin: 0;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(255, 75, 43, 0.3);
            padding: 1.5rem;
            background-color: #404040;
            max-height: 90vh;
            max-width: 500px;
            width: 100%;
            margin: auto;
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
            text-align: center;
        }

        .btn-back:hover {
            background-color: #ff4b2b;
            border: 1px solid #ff4b2b;
        }

        .form-floating {
            height: 55px;
        }

        .form-floating > label {
            color: #bfbfbf;
            max-height: 10px;
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
            color: #ff4b2b;
            text-decoration: none;
        }

        .form-links a:hover {
            text-decoration: underline;
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .logo {
            width: 100px;
            height: auto;
        }

        h3 {
            font-weight: 600;
            margin: 0; 
        }

        .card-body {
            padding-top: 1rem; 
        }

        @media (max-width: 992px) {
            .card {
                padding: 2rem;
                max-width: 500px;
            }
        }

        @media (max-width: 575.98px) {
            .container 
            h3 {
                font-size: 1.25rem;
            }
            .card {
                border: none;
                border-radius: 10px;
                box-shadow: 0 4px 10px rgba(255, 75, 43, 0.3);
                padding: 20px;
                background-color: #404040;
                max-width: 500px;
                width: 100%;
                margin: auto;
            }
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
    </style>
</head>

<body>
    <main class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 col-sm-10">
                <div class="card">
                    <div class="card-header">
                        <img src="{{ isset($setting) && $setting->app_logo ? asset('storage/' . $setting->app_logo) : asset('assets/images/logo_gym.png') }}" alt="Logo" class="logo">
                        <h3 class="text-center">Register</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="form-floating mb-2">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="floatingName" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                <label for="floatingName">Name</label>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            {{-- <div class="form-floating mb-2">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="floatingEmail" name="email" value="{{ old('email') }}" required autocomplete="email">
                                <label for="floatingEmail">Email</label>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div> --}}
                            <div class="form-floating mb-2">
                                <input type="number" class="form-control @error('phone') is-invalid @enderror" id="floatingPhone" name="phone" value="{{ old('phone') }}" required autocomplete="phone">
                                <label for="floatingEmail">Phone</label>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-floating mb-2">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="floatingPassword" name="password" required autocomplete="new-password">
                                <label for="floatingPassword">Password</label>
                                <i class="fa fa-eye-slash input-icon" id="togglePasswordIcon" onclick="togglePassword('floatingPassword', 'togglePasswordIcon')"></i>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-floating mb-2">
                                <input type="password" class="form-control" id="floatingPasswordConfirm" name="password_confirmation" required autocomplete="new-password">
                                <label for="floatingPasswordConfirm">Confirm Password</label>
                                <i class="fa fa-eye-slash input-icon" id="togglePasswordConfirmationIcon" onclick="togglePassword('floatingPasswordConfirm', 'togglePasswordConfirmationIcon')"></i>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Register</button>                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <p>Already have an account? <a href="{{ route('login') }}" style="color: #ff4b2b;">Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
        function togglePassword(fieldId, toggleIconId) {
            var passwordField = document.getElementById(fieldId);
            var toggleIcon = document.getElementById(toggleIconId);

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
