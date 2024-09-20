@extends('dashboard.master')
@section('title', $settings->app_name . ' - Edit User' ?? 'Edit User')
@section('sidebar')
    @include('dashboard.sidebar')
@endsection
@section('page-title', 'Edit User')
@section('page', 'User / Edit')
@section('main')
    @include('dashboard.main')

    <!-- Tables -->
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Edit User</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <div class="card border-1 m-3 pt-3">
                                <form action="{{ route('user.update', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3 ms-3 me-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text"
                                            class="ps-2 form-control border border-secondary-subtle @error('name') is-invalid @enderror"
                                            placeholder="Name" aria-label="name" id="name" name="name"
                                            value="{{ old('name', $user->name) }}">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 ms-3 me-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="text"
                                            class="ps-2 form-control border border-secondary-subtle @error('email') is-invalid @enderror"
                                            placeholder="Email" aria-label="email" id="email" name="email"
                                            value="{{ old('email', $user->email) }}">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 ms-3 me-3">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input type="number"
                                            class="ps-2 form-control border border-secondary-subtle @error('phone') is-invalid @enderror"
                                            placeholder="Phone" aria-label="phone" id="phone" name="phone"
                                            value="{{ old('phone', $user->phone) }}">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 ms-3 me-3">
                                        <label for="role" class="form-label">Role</label>
                                        <select
                                            class="form-select border border-secondary-subtle @error('role') is-invalid @enderror"
                                            id="role" name="role">
                                            <option value="" disabled>Select Role</option>
                                            <option value="admin"
                                                {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                            <option value="customer"
                                                {{ old('role', $user->role) == 'customer' ? 'selected' : '' }}>Customer
                                            </option>
                                            <option value="cashier"
                                                {{ old('role', $user->role) == 'cashier' ? 'selected' : '' }}>Cashier
                                            </option>
                                        </select>
                                        @error('role')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="ms-3 me-3 text-end">
                                        <a href="{{ route('user.index') }}" type="button"
                                            class="btn bg-gradient-primary ws-15 my-4 mb-2">Cancel</a>
                                        <button type="submit"
                                            class="btn bg-gradient-success ws-15 my-4 mb-2">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
