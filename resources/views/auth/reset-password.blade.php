<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reset Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
            @if($message = session('status'))
            <div class="alert alert-success my-2 text-success" role="alert">{{ $message }}</div>
            @endif
            <div class="card">
                <form class="card-body" action="{{ route('reset') }}" method="POST">
                    @csrf
                    <h1 class="h3 mb-3 fw-normal">Please Reset Your Password</h1>
    
                    <input name="token" type="hidden" value="{{ request('token') }}">
    
                    <div>
                        <label for="floatingInput">Email address</label>
                        <input name="email" type="email" class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" id="floatingInput" placeholder="name@example.com" value="{{ old('email', request('email')) }}" readonly>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <div>
                        <label for="floatingPassword">Password</label>
                        <input name="password" type="password" class="form-control {{ $errors->has('password') ? 'is-invalid' : '' }}" id="floatingPassword" placeholder="Password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
    
                    <div class="mb-4">
                        <label for="floatingPassword">Password Confirmation</label>
                        <input name="password_confirmation" type="password" class="form-control {{ $errors->has('password_confirmation') ? 'is-invalid' : '' }}" id="floatingPassword" placeholder="Password">
                        @error('password_confirmation')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <button class="w-100 btn btn-lg btn-primary" type="submit">Submit</button>
                </form>
            </div>
            </div>
        </div>
    </div>
</body>
</html>