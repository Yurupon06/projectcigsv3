@extends('dashboard.master')
@section('title', 'Application Setting')
@section('sidebar')
    @include('dashboard.sidebar')
@endsection
@section('page-title', 'Application Setting')
@section('page', 'Application Setting')
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
                            <img class="d-block mx-auto"
                                src="{{ $setting->app_logo ? asset('storage/' . $setting->app_logo) : asset('assets/images/logo_gym.png') }}"
                                alt="Logo" width="200px">
                            <form action="{{ route('application-setting.update', $setting->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="mb-3 ms-3 me-3">
                                    <label for="app_name" class="form-label">App Name</label>
                                    <input type="text"
                                        class="ps-2 form-control border border-secondary-subtle @error('app_name') is-invalid @enderror"
                                        placeholder="App Name" aria-label="app_name" id="app_name" name="app_name"
                                        value="{{ old('app_name', $setting->app_name) }}">
                                    @error('app_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 ms-3 me-3">
                                    <label for="app_logo" class="form-label">App Logo</label>
                                    <input type="file"
                                        class="ps-2 form-control border border-secondary-subtle @error('app_logo') is-invalid @enderror"
                                        placeholder="App Logo" aria-label="app_logo" id="app_logo" name="app_logo"
                                        value="{{ old('app_logo', $setting->app_logo) }}">
                                    @error('app_logo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Better format file is PNG.</small>
                                </div>
                                <div class="mb-3 ms-3 me-3">
                                    <label for="app_address" class="form-label">Address</label>
                                    <textarea name="app_address" id="app_address"
                                        class="ps-2 form-control border border-secondary-subtle @error('app_address') is-invalid @enderror"
                                        placeholder="Address" rows="3" style="resize: none;">{{ old('app_address', $setting->app_address) }}</textarea>
                                    @error('app_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit"><span class="btn bg-gradient-success ws-15 my-4 mb-2">Update</span></button>
                            </form>
                        @else
                            <p class="mb-3 ms-3 me-3">No settings available. Please add settings first.</p>
                            <form action="{{ route('application-setting.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3 ms-3 me-3">
                                    <label for="app_name" class="form-label">App Name</label>
                                    <input type="text"
                                        class="ps-2 form-control border border-secondary-subtle @error('app_name') is-invalid @enderror"
                                        placeholder="App Name" aria-label="app_name" id="app_name" name="app_name"
                                        value="{{ old('app_name') }}">
                                    @error('app_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3 ms-3 me-3">
                                    <label for="app_logo" class="form-label">App Logo</label>
                                    <input type="file"
                                        class="ps-2 form-control border border-secondary-subtle @error('app_logo') is-invalid @enderror"
                                        placeholder="App Logo" aria-label="app_logo" id="app_logo" name="app_logo"
                                        value="{{ old('app_logo') }}">
                                    @error('app_logo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Better format file is PNG.</small>
                                </div>
                                <div class="mb-3 ms-3 me-3">
                                    <label for="app_address" class="form-label">Address</label>
                                    <textarea name="app_address" id="app_address"
                                        class="ps-2 form-control border border-secondary-subtle @error('app_address') is-invalid @enderror"
                                        placeholder="Address" rows="3" style="resize: none;">{{ old('app_address') }}</textarea>
                                    @error('app_address')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-primary mb-3 ms-3 me-3">Create</button>
                            </form>
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
