@extends('landing.master')
@section('title',  isset($setting) ? $setting->app_name . ' - QR Code' : 'QR Code')
@section('main')

<style>

    .card {
        background-color: #2c2c2c; /* Warna card */
        color: #fff;
        border-radius: 20px; /* Membuat sudut lebih melengkung */
    }

    .card-header h3 {
        color: #ff4b2b; /* Warna judul mencolok */
    }

    .card-header p {
        color: #a9a9a9; /* Warna teks p lebih redup */
    }

    .qr-code {
        background-color: #ffffff;
        padding: 20px;
        border-radius: 15px;
    }
</style>
<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh; background-color:#2c2c2c">
    <div class="card shadow-lg p-4" style="max-width: 400px; width: 100%; background-color: #2c2c2c; border-radius: 20px;">
        <div class="card-header text-center" style="border-bottom: none;">
            <h3 class="text-white" style="font-weight: 600;">Your QR Code</h3>
            <p class="text-white">Scan this to get in</p>
        </div>
        <div class="card-body text-center">
            <div class="qr-code p-4" style="background-color: #fff; border-radius: 15px; display: inline-block;">
                <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(250)->mergeString(Storage::get(isset($setting) ? $setting->app_logo : asset('assets/images/logo_gym.png') ))->generate($member->qr_token)) !!} ">
            </div>
        </div>
    </div>
</div>
@endsection
 