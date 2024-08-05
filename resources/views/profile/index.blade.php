<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Edit Profile</title>

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

        .form-floating > label {
            color: #ffffff;
        }

        .form-floating > .form-control:focus ~ label {
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
          background-color: #ff4b2b;
        }

        .btn-grey {
          background-color: #696969;
        }

    </style>
</head>

<body>
    <main class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <h3>Profile</h3>
                    <div>
                      <h6>Name</h6>
                    <div class="profile-detail">
                      <p>{{ $user->name }}</p>
                    </div>
                    </div>

                    <div>
                      <h6>Email</h6>
                    <div class="profile-detail">
                      <p>{{ $user->email }}</p>
                    </div>
                    </div>

                    <div>
                      <h6>Phone Number</h6>
                    <div class="profile-detail">
                      <p>{{ $customer->phone ?? 'Not Found'}}</p>
                    </div>
                    </div>

                    <div>
                      <h6>Gender</h6>
                    <div class="profile-detail">
                      <p>{{ $customer->gender }}</p>
                    </div>
                    </div>

                    <div>
                      <h6>Birthdate</h6>
                    <div class="profile-detail">
                      <p>{{ $customer->born ?? 'Not Found'}}</p>
                    </div>
                    </div>
                    <div>
                      <a href="{{ route('profile.edit', $profile = $customer->id) }}" class="btn btn-orange text-white">Edit Profile</a>
                      <a href="{{ route('landing.index') }}" class="btn btn-grey text-white">Back</a>
                    </div>
                      
                </div>
            </div>
        </div>
    </main>

    {{-- Sweet Alert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1cnd+0AdAq8ni0Y3C03GA+6GczfURhZgefjMNKDU3KwLLpTt92lW2TdeYifz59C" crossorigin="anonymous"></script>

    <script>
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}',
            })
        @endif
    </script>
</body>

</html>
