@extends('dashboard.master')
@section('sidebar')
@section('page-title', 'Profile Cashier')
@extends('landing.master')
@section('main')
    @include('cashier.main')
<head>
    <title>Profile</title>
</head>
<style>
.container {
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

</style>

<div class="container">
    <div class="navigation-links">
        <a href="{{ route('cashier.index') }}">Back</a>
    </div>

    <div class="profile-section">
        <h1>Profile Cashier</h1>
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
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
            <span class="{{ !$customer ? : '' }}">{{ $customer->phone ?? 'Not filled' }}</span>
        </div>

        <div class="profile-field">
            <span>Date of Birth:</span>
            <span class="{{ !$customer ? : '' }}">{{ $customer->born ?? 'Not filled' }}</span>
        </div>

        <div class="profile-field">
            <span>Gender:</span>
            <span class="{{ !$customer ? : '' }}">{{ $customer->gender ?? 'Not filled' }}</span>
        </div>


        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#editProfileModal">
            Update Profile
        </button>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="editProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProfileModalLabel">Update Profile</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('update.profill') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone', $customer->phone ?? '') }}" required>
                        @error('phone')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="born">Date of Birth</label>
                        <input type="date" id="born" name="born" class="form-control" value="{{ old('born', $customer->born ?? '') }}" required>
                        @error('born')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select id="gender" name="gender" class="form-control" required>    
                            <option value="">Select Gender</option>
                            <option value="men" {{ old('gender', optional($customer)->gender) == 'men' ? 'selected' : '' }}>Men</option>
                            <option value="women" {{ old('gender', optional($customer)->gender) == 'women' ? 'selected' : '' }}>Women</option>
                        </select>
                        @error('gender')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="current_password">Current Password</label>
                        <input type="password" id="current_password" name="current_password" class="form-control">
                        @error('current_password')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password">New Password</label>
                        <input type="password" id="password" name="password" class="form-control">
                        @error('password')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Confirm New Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                        @error('password_confirmation')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
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