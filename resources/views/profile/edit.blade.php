<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Profile</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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

        .form-floating>label {
            color: #ffffff;
        }

        .form-floating>.form-control:focus~label {
            color: #ffffff;
        }

        .form-control {
            background-color: #404040;
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

        .form-select {
            background-color: #404040;
            color: #ffffff;
            border: 1px solid #ff4b2b;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(255, 75, 43, 0.2);
        }

        h1 {
            font-weight: 600;
            margin-top: 0.10rem;
        }

        .logo {
            display: block;
            margin: 0 auto 0.10rem auto;
            width: 300px;
            height: auto;
        }

        .card-content {
            text-align: center;
        }

        .profile-detail {
            border: 1px solid #ff4b2b;
            border-radius: 10px;
            padding: 10px;
            margin-bottom: 20px;
        }

        .profile-detail p {
            margin: 0;
        }

        .btn-orange {
            background-color: #ff4b2b
        }
    </style>
</head>

<body>
    <main class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <form action="{{ route('profile.update', Auth::user()->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <h3 class="mb-3">Edit Profile</h3>
                        <div class="card-content">
                            <div class="form-floating mb-3">
                                <input type="text"
                                    class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" id="name"
                                    name="name" placeholder="Name" value="{{ $user->name }}" required>
                                <label for="name">Name</label>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-floating mb-3">
                                <input type="email"
                                    class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" id="email"
                                    name="email" placeholder="Email" value="{{ $user->email }}" required>
                                <label for="email">Email</label>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-floating mb-3">
                                <input type="number"
                                    class="form-control {{ $errors->has('number') ? 'is-invalid' : '' }}" id="phone"
                                    name="phone" placeholder="Phone  Number" value="{{ $customer->phone }}">
                                <label for="phone">Phone Number</label">
                                    @error('number')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                            </div>
                            <div class="form-floating mb-3">
                                <select class="form-select {{ $errors->has('gender') ? 'is-invalid' : '' }}"
                                    id="gender" name="gender">
                                    <option value="men" @if ($customer->gender == 'men' || old('gender') == 'men') selected @endif>Male
                                    </option>
                                    <option value="women" @if ($customer->gender == 'women' || old('gender') == 'women') selected @endif>Female
                                    </option>
                                </select>
                                <label for="gender">Gender</label>
                                @error('gender')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-floating mb-3">
                                <input type="date"
                                    class="form-control {{ $errors->has('born') ? 'is-invalid' : '' }}" id="born"
                                    name="born" placeholder="Birthdate" value="{{ $customer->born }}">
                                <label for="gender">Birthdate</label>
                                @error('born')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-orange ws-15 my-4 mb-2 text-white w-100">Update</button>
                        <div class="form-links">
                            <a href="{{ route('profile.index') }}">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-U1cnd+0AdAq8ni0Y3C03GA+6GczfURhZgefjMNKDU3KwLLpTt92lW2TdeYifz59C" crossorigin="anonymous">
    </script>
</body>

</html>
