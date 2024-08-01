<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Register</title>

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
            margin: 3rem;
        }

        .container {
            padding: 2rem;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(255, 75, 43, 0.3);
            padding: 1.5rem; /* Reduced padding */
            background-color: #404040;
            max-width: 500px; /* Set maximum width */
            margin: auto; /* Center card and add margin */
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
            padding: 0; 
        }

        .logo {
            width: 150px;
            height: auto;
        }

        h3 {
            font-weight: 600;
            margin: 0; 
        }

        .card-body {
            padding-top: 1rem; 
        }

        @media (max-width: 767.98px) {
            .container {
                padding: 2rem 1.5rem; 
            }
            h3 {
                font-size: 1.5rem; 
            }
        }

        @media (max-width: 575.98px) {
            .container {
                padding: 2rem 1rem; 
            }
            h3 {
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
                        <img src="../assets/images/logo_gym.png" alt="Logo" class="logo">
                        <h3 class="text-center">Register</h3>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="floatingName" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                                <label for="floatingName">Name</label>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email" class="form-control @error('email') is-invalid @enderror" id="floatingEmail" name="email" value="{{ old('email') }}" required autocomplete="email">
                                <label for="floatingEmail">Email</label>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" id="floatingPassword" name="password" required autocomplete="new-password">
                                <label for="floatingPassword">Password</label>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-floating mb-3">
                                <input type="password" class="form-control" id="floatingPasswordConfirm" name="password_confirmation" required autocomplete="new-password">
                                <label for="floatingPasswordConfirm">Confirm Password</label>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Register</button>
                            <a href="{{ url()->previous() }}" class="btn btn-back w-100 mt-3">Back</a>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <p>Already have an account? <a href="{{ route('login') }}" style="color: #ff4b2b;">Login</a></p>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1cnd+0AdAq8ni0Y3C03GA+6GczfURhZgefjMNKDU3KwLLpTt92lW2TdeYifz59C" crossorigin="anonymous"></script>
</body>

</html>
