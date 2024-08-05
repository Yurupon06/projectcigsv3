@extends('landing.master')
@include('landing.header')

<style>
/* Style for the container */
.container {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

/* Navigation links styling */
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

/* Profile section styling */
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
        <a href="{{ route('landing.index') }}">Back</a>
    </div>

    <div class="profile-section">
        <h1>Profile</h1>
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

<!-- Modal for updating profile -->
<div class="modal fade" id="editProfileModal" tabindex="-1" role="dialog" aria-labelledby="editProfileModalLabel" aria-hidden="true">
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
                        <label for="phone">Phone</label>
                        <input type="text" id="phone" name="phone" class="form-control" value="{{ $customer->phone ?? '' }}" required>
                    </div>
                    <div class="form-group">
                        <label for="born">Date of Birth</label>
                        <input type="date" id="born" name="born" class="form-control" value="{{ $customer->born ?? '' }}" required>
                    </div>
                    <div class="form-group">
                        <label for="gender">Gender</label>
                        <select id="gender" name="gender" class="form-control" required>
                            <option value="men" {{ ($customer->gender ?? 'men') == 'men' ? 'selected' : '' }}>Men</option>
                            <option value="women" {{ ($customer->gender ?? 'men') == 'women' ? 'selected' : '' }}>Women</option>
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
