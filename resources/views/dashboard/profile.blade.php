@extends('dashboard.master')
@section('page-title', 'Profile Admin')
@section('title',  isset($setting) ? $setting->app_name : ' - Profile Admin' ?? 'Profile Admin')
@section('main')
    @include('dashboard.main')

    @section('profile-style')
    <style>
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
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
        </style>
    @endsection

    <div class="container">
        <div class="navigation-links d-flex justify-content-between mb-3">
            <a href="{{ route('dashboard.index') }}" class="text-primary text-decoration-none fw-bold">Back</a>
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
            <div class="profile-field">
                <span>Email:</span>
                <span>{{ $user->email }}</span>
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
                <span class="text-capitalize">{{ $customer->gender ?? 'Not filled' }}</span>
            </div>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editProfileModal">
                Update Profile
            </button>
            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#changePasswordModal">
                Change Password
            </button>
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
                <form action="{{ route('update.profile.admin') }}" method="POST">
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
                                value="{{ $customer->born ?? '' }}" 
                                max="{{ date('Y-m-d', strtotime('-1 day')) }}" required>
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
                <form action="{{ route('update.password.admin') }}" method="POST">
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
    @section('profile-script')
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
@endsection