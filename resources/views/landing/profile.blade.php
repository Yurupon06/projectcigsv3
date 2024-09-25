@extends('landing.master')
@section('title', isset($setting) ? $setting->app_name . ' - Profile' : 'Profile')
@section('main')

    <style>
        .container {
            min-height: 100vh;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }

        .navigation-links {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .navigation-links a {
            text-decoration: none;
            color: #007BFF;
            font-weight: bold;
        }

        .navigation-links a:hover {
            text-decoration: underline;
        }

        .profile-section {
            background-color: #f9f9f9;
            margin: 20px;
            margin-top: 60px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .profile-section h1 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #333;
        }

        .profile-field {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .profile-field span {
            font-size: 18px;
            color: #555;
        }

        .profile-field a {
            text-decoration: none;
            color: #007BFF;
            font-weight: bold;
            font-size: 16px;
        }

        .profile-field a:hover {
            text-decoration: underline;
        }

        /* Mobile Logout Button Styles */
        .btn-logout-mobile {
            display: block;
            color: #007BFF;
            font-weight: bold;
            text-decoration: none;
            padding: 10px;
            text-align: center;
            border: 1px solid #007BFF;
            border-radius: 5px;
            margin-top: 10px;
        }

        .btn-logout-mobile:hover {
            background-color: #007BFF;
            color: white;
            text-decoration: none;
        }
        .button-grid {
            display: flex;
            color: #000;
            justify-content: space-between;
            margin: 20px;
        }

        .btn-box {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 30%;
            padding: 20px;
            text-align: center;
            background-color: white;
            color: #333;
            border-radius: 10px;
            font-weight: bold;
            text-decoration: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
            border: 1px solid #ddd;
        }

        .btn-box:hover {
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .btn-box:active {
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        .btn-logo {
            width: 20px;
            height: auto;
            margin-right: 10px;
        }

        
    </style>

        <div class="profile-section">
            <h1>Profile</h1>
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('warning'))
                <div class="alert alert-warning">
                    {{ session('warning') }}
                </div>
            @endif
            <div class="profile-field">
                <span>Name:</span>
                <span>{{ $user->name }}</span>
            </div>
            <div class="profile-field">
                <span>Email:</span>
                <span>{{ $user->email ?? 'Not filled' }}</span>
            </div>
            <div class="profile-field">
                <span>Phone:</span>
                <span>{{ $customer->phone ?? 'Not filled' }}</span>
            </div>

            <div class="profile-field">
                <span>Date of Birth:</span>
                <span>{{ $customer->born ?? 'Not filled' }}</span>
            </div>

            <div class="profile-field">
                <span>Gender:</span>
                <span>{{ $customer->gender ?? 'Not filled' }}</span>
            </div>

        </div>
        <div class="button-grid">
            <a href="{{route('landing.edit')}}" type="button" class="btn-box">
                <i class="bi bi-gear fs-1"></i>
            </a>
            <a href="{{route('landing.change')}}" type="button" class="btn-box">
                <i class="bi bi-key fs-1"></i>
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
            
            <a href="#" class="btn-box" id="logout-btn">
                <i class="bi bi-box-arrow-right fs-1"></i>
            </a>
            
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('logout-btn').addEventListener('click', function(event) {
            event.preventDefault(); // Mencegah link logout default dijalankan

            Swal.fire({
                title: 'Are you sure?',
                text: "You will be logged out from this session.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, log me out!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika user memilih logout, submit form logout
                    document.getElementById('logout-form').submit();
                }
            });
        });
    </script>

    <script>
        document.querySelector('form').addEventListener('submit', function(event) {
            var currentPassword = document.getElementById('current_password').value;
            var newPassword = document.getElementById('password').value;
            var confirmPassword = document.getElementById('password_confirmation').value;

            if ((newPassword || confirmPassword) && (!currentPassword || !newPassword || !confirmPassword)) {
                event.preventDefault();
                alert('Please fill in all fields if you are changing your password.');
            }
        });
    </script>
@endsection