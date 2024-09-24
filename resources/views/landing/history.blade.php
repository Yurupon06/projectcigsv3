@extends('landing.master')
@section('title', isset($setting) ? $setting->app_name : ' - Order' ?? 'Order')
@section('main')

@if(session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
@endif

<style>
    .card {
        cursor: pointer;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        display: flex;
        align-items: left;
    }
    .card:hover {
        transform: scale(1.02);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    .card-img {
        text-align: left;
        width: 100px; /* Lebar tetap untuk gambar */
        height: 100px; /* Tinggi tetap untuk gambar */
        object-fit: cover; /* Pastikan gambar menutupi area */
        margin-right: 15px; /* Jarak antara gambar dan teks */
    }
    .card-body {
        display: flex; /* Gunakan flexbox untuk tubuh kartu */
        justify-content: space-between; /* Distribusikan ruang antara anak */
        align-items: center; /* Pusatkan item secara vertikal */
        width: 100%; /* Ambil lebar penuh */
    }
    .card-title {
        margin: 0; /* Hapus margin default */
    }
    .time-text {
        text-align: center; 
    }
    .container {
        padding-bottom: 100px;
        margin-top: 80px;
    }
</style>

<div class="container">
    <div class="col">
        @forelse ($memberckin as $dt)
            <div class="card col-12">
                <div class="card-body">
                    <img src="{{ asset('storage/' . $dt->image) }}" class="card-img" alt="Member Image">
                    <p class="time-text">{{ $dt->created_at->setTimezone('Asia/Jakarta')->format('d/m/Y, H:i') }}</p>
                    </div>
            </div>
        @empty
            <p class="text-center">No orders found.</p>
        @endforelse

        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    {{ $memberckin->appends(request()->except('page'))->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
