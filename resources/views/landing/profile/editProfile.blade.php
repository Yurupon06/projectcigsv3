@extends('landing.master')
@section('title', isset($setting) ? $setting->app_name . ' - Edit Profile' : 'Edit Profile')
@section('main')

<style>
    .centered-container {
        display: flex;
        justify-content: center;
        margin-top:60px;
        align-items: center; /* Diubah agar konten mulai dari atas saat di-scroll */
        min-height: 90vh; /* Tinggi minimum 100% dari viewport */
        background-color: #f8f9fa; /* Latar belakang halaman */
    }

    .content {
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 500px; /* Batas lebar maksimal */
        max-height: 90vh; /* Batas tinggi maksimal */
        overflow-y: auto; /* Tambahkan scroll jika konten melebihi tinggi */
    }

    /* Untuk mobile, pastikan konten tetap bisa di-scroll */
    @media (max-width: 768px) {
        .centered-container {
            align-items: center;
            justify-content: center;
            margin-top: 0;
            min-height: 100vh;
        }
        .content {
            align-items: center;
            justify-content: center;
            position: fixed;
        }
    }

    .btn-primary {
        background-color: #ff8500;
        border-color: #ff8500;
    }

    .btn-primary:hover {
        background-color: #ff5500;
        border-color: #ff5500;
    }
</style>

<div class="centered-container">
    <div class="content">
        <h5 class="mb-4">Update Profile</h5>
        <form action="{{ route('update.profile') }}" method="POST">
            @csrf
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
                       value="{{ $customer->born ?? '' }}" max="{{ date('Y-m-d', strtotime('-1 day')) }}" required>
            </div>
            <div class="form-group">
                <label for="gender">Gender</label>
                <select id="gender" name="gender" class="form-control" required>
                    <option value="men" {{ ($customer->gender ?? 'men') == 'men' ? 'selected' : '' }}>Men</option>
                    <option value="women" {{ ($customer->gender ?? 'men') == 'women' ? 'selected' : '' }}>Women</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Save changes</button>
        </form>
    </div>
</div>
@endsection