@extends('dashboard.master')
@section('title', 'App Setting')
@section('sidebar')
    @include('dashboard.sidebar')
@endsection
@section('page-title', 'App Setting')
@section('page', 'App Setting')
@section('main')
    @include('dashboard.main')

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header py-2">
                        <h3 class="text-center font-weight-bold">App Setting</h3>
                    </div>
                    <div class="card-body p-3">
                        @if ($setting)
                            <div class="profile-field">
                                <span>App Name:</span>
                                <span>{{ $setting->app_name ?? 'Not filled' }}</span>
                            </div>
                            <div class="profile-field">
                                <span>App Logo:</span>
                                <span>
                                    <img src="{{ $setting->app_logo ? asset('storage/' . $setting->app_logo) : asset('assets/images/logo_gym.png') }}"
                                        alt="App-Logo" width="200px">
                                </span>
                            </div>
                            <div class="profile-field">
                                <span>Address:</span>
                                <span>{{ $setting->app_address ?? 'Not filled' }}</span>
                            </div>
                            <a href="{{ route('application-setting.edit', $setting->id) }}" class="btn btn-primary">Edit</a>
                        @else
                            <p>No settings available. Please add settings first.</p>
                            <a href="{{ route('application-setting.create') }}" class="btn btn-primary">Add Settings</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if (Session::has('success'))
            {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ Session::get('success') }}',
                })
            }
        @endif
    </script>

@endsection
