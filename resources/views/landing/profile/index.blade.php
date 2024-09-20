@extends('landing.master')
@section('title', $setting->app_name . ' - Profile' ?? 'Profile')
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
    justify-content: space-between;
    margin: 20px 0;
}

.button-grid {
    display: flex;
    justify-content: space-between;
    margin: 20px 0;
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

    <div class="container">
        <div class="navigation-links">
            <a href="{{ route('landing.index') }}">Back</a>
        </div>

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
        </div>
        <div class="button-grid">
            <a href="{{ route('landing.profile') }}" class="btn-box">
                <i class="bi bi-person fs-1"></i>
            </a>
            @if ($member)
            <a href="{{route('landing.history')}}" class="btn-box">
                <i class="bi bi-clock-history fs-1"></i>
            </a>
            @endif
            
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
            <a href="{{ route('logout') }}" class="btn-box" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-right fs-1"></i>
            </a>
            
        </div>
        
    </div>




    <!-- Profile Update Modal -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="editProfileModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Update Profile</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('update.profile') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" class="form-control"
                                value="{{ Auth::user()->name }}" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control"
                                value="{{ Auth::user()->email }}" required>
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" id="phone" name="phone" class="form-control"
                                value="{{ $customer->phone ?? '' }}" required>
                        </div>
                        <div class="form-group">
                            <label for="born">Date of Birth</label>
                            <input type="date" id="born" name="born" class="form-control"
                                value="{{ $customer->born ?? '' }}" max="{{ date('Y-m-d', strtotime('-1 day')) }}"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <select id="gender" name="gender" class="form-control" required>
                                <option value="men" {{ ($customer->gender ?? 'men') == 'men' ? 'selected' : '' }}>Men
                                </option>
                                <option value="women" {{ ($customer->gender ?? 'men') == 'women' ? 'selected' : '' }}>
                                    Women</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Change Password Modal -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" role="dialog"
        aria-labelledby="changePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('update.password') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="current_password">Current Password</label>
                            <input type="password" id="current_password" name="current_password" class="form-control"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="password">New Password</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Confirm New Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
