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
                        <img src="../assets/images/logo_gym.png" alt="Logo" class="logo">
                        <h1 class="h3">Forgot Password</h1>
                    </div>
                    <div class="card-body">
                        @if($message = session('status'))
                        <div class="alert alert-success my-2 text-success" role="alert">{{ $message }}</div>
                        @endif
                        <form action="{{ route('forgot') }}" method="POST">
                            @csrf
                            <div class="form-floating mb-3">
                                <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" id="floatingInput" placeholder="name@example.com" value="{{ old('email') }}" required>
                                <label for="floatingInput">Email address</label>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button class="w-100 btn btn-primary" type="submit">Send Email Link</button>
                        </form>
                    </div>
                    <div class="card-footer text-center">
                        <a href="{{ url()->previous() }}" class="btn btn-back w-100">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1cnd+0AdAq8ni0Y3C03GA+6GczfURhZgefjMNKDU3KwLLpTt92lW2TdeYifz59C" crossorigin="anonymous"></script>
</body>

</html>
