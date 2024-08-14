@extends('landing.master')
@include('landing.header')

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
        <a href="{{ route('landing.index') }}">Back</a>
    </div>

    <div class="profile-section">
        <h1 class="text-center">Membership</h1>
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
            <span>{{ $customer->gender ?? 'Not filled' }}</span>
        </div>

        <div class="profile-field">
            <span>Start Date:</span>
            <span>{{ $member->start_date ?? 'Not filled' }}</span>
        </div>

        <div class="profile-field">
            <span>Expiration Date:</span>
            <span>{{ $member->end_date ?? 'Not filled' }}</span>
        </div>

        <a href="#" type="button" class="btn btn-primary">
            Check In
        </a>
    </div>
</div>
