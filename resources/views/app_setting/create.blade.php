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
                        <form action="{{ route('application-setting.store') }}" method="POST" enctype="multipart/form-data">
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
