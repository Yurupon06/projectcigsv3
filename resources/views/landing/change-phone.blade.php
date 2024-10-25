@extends('landing.master')
@section('title', isset($setting) ? $setting->app_name . ' - Change Phone Number' : 'Change Phone Number')
@section('main')

    <style>
        .container {
            margin-top: 100px;
        }
    </style>

    <main class="container">
        <div class="row justify-content-center">
            <div class="col-10">
                <div class="card">
                    <div class="card-header">
                        <p class="mb-0 text-center">Please enter your new phone number</p>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('change-phone') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <input type="text" oninput="this.value = this.value.replace(/[^0-9]/g, '');" maxlength="13"
                                    class="form-control text-center" id="phone"
                                    name="phone" placeholder="08XXXXXXXXXX" value="{{ auth()->user()->phone }}" required>
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary btn-block">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-U1cnd+0AdAq8ni0Y3C03GA+6GczfURhZgefjMNKDU3KwLLpTt92lW2TdeYifz59C" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ session('error') }}',
            })
        @elseif(session('warning'))
            Swal.fire({
                icon: 'warning',
                title: 'Oops...',
                text: '{{ session('warning') }}',
            })
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
@endsection
