@extends('landing.master')
@section('title', isset($setting) && $setting->app_name . ' - Change Password' ?? 'Profile')
@section('main')

<style>
    /* CSS untuk memusatkan konten secara horizontal dan vertikal */
    .centered-container {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh; /* Tinggi minimum 100% dari viewport */
        background-color: #f8f9fa; /* Latar belakang halaman */
    }
    .content {
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 500px; /* Batas lebar maksimal */
    }
    #togglePassword{
        float: right;
        margin-left: -25px;
        margin-top: -30px;
        right: 10px;
        position: relative;
        z-index: 2;
    }
</style>


<div class="centered-container">
    <div class="content">
        @if (session('warning'))
    <div class="alert alert-warning">
        {{ session('warning') }}
    </div>
@endif
        <h5 class="mb-4">Change Password</h5>
        <form action="{{ route('update.password') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="current_password">Current Password</label>
                <input type="password" id="current_password" name="current_password" class="form-control"required>
                <span class="password-toggle" id="togglePassword" onclick="togglePassword('current_password')">
                    <i class="fa fa-eye-slash" id="toggleCurrentPasswordIcon"></i>
                </span>
            </div>
            <div class="form-group">
                <label for="password">New Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
                <span class="password-toggle" id="togglePassword" onclick="togglePassword('password')">
                    <i class="fa fa-eye-slash" id="togglePasswordIcon"></i>
                </span>
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirm New Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation"class="form-control" required>
                <span class="password-toggle" id="togglePassword" onclick="togglePassword('password_confirmation')">
                    <i class="fa fa-eye-slash" id="togglePasswordConfirmationIcon"></i>
                </span>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Save changes</button>
        </form>
    </div>
</div>

<script>
    function togglePassword(fieldId) {
        var passwordField = document.getElementById(fieldId);
        var toggleIcon = passwordField.nextElementSibling.querySelector('i');
        
        if (passwordField.type === "password") {
            passwordField.type = "text";
            toggleIcon.classList.remove("fa-eye-slash");
            toggleIcon.classList.add("fa-eye");
        } else {
            passwordField.type = "password";
            toggleIcon.classList.remove("fa-eye");
            toggleIcon.classList.add("fa-eye-slash");
        }
    }
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