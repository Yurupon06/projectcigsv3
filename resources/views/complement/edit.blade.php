@extends('dashboard.master')
@section('title',  $setting->app_name . ' - Edit complement' ?? 'Edit - complement')
@section('sidebar')
    @include('dashboard.sidebar')
@endsection
@section('page-title', 'Edit complement')
@section('page', 'complement / Edit')
@section('main')
    @include('dashboard.main')

    <!-- Tables -->
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h6>Edit complement</h6>
                    </div>
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="table-responsive p-0">
                            <div class="card border-1 m-3 pt-3">
                                <form action="{{ route('complements.update', $complement->id) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3 ms-3 me-3">
                                        <label for="name" class="form-label">Name</label>
                                        <input type="text"
                                            class="ps-2 form-control border border-secondary-subtle @error('name') is-invalid @enderror"
                                            placeholder="Name" aria-label="name" id="name" name="name"
                                            value="{{ old('name', $complement->name) }}">
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 ms-3 me-3">
                                        <label for="category" class="form-label">category</label>
                                        <select
                                            class="form-select border border-secondary-subtle @error('category') is-invalid @enderror"
                                            id="category" name="category">
                                            <option value="" disabled>Select category</option>
                                            <option value="food"
                                                {{ old('category', $complement->category) == 'food' ? 'selected' : '' }}>food</option>
                                            <option value="drink"
                                                {{ old('category', $complement->category) == 'drink' ? 'selected' : '' }}>drink</option>
                                            <option value="suplement"
                                                {{ old('category', $complement->category) == 'suplement' ? 'selected' : '' }}>suplement</option>
                                        </select>
                                        @error('category')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 ms-3 me-3">
                                        <label for="description" class="form-label">description</label>
                                        <input type="text"
                                            class="ps-2 form-control border border-secondary-subtle @error('description') is-invalid @enderror"
                                            placeholder="description" aria-label="description" id="description" name="description"
                                            value="{{ old('description', $complement->description) }}">
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 ms-3 me-3">
                                        <label for="price" class="form-label">price</label>
                                        <input type="number"
                                            class="ps-2 form-control border border-secondary-subtle @error('price') is-invalid @enderror"
                                            placeholder="price" aria-label="price" id="price" name="price"
                                            value="{{ old('price', $complement->price) }}">
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 ms-3 me-3">
                                        <label for="stok" class="form-label">stok</label>
                                        <input type="number"
                                            class="ps-2 form-control border border-secondary-subtle @error('stok') is-invalid @enderror"
                                            placeholder="stok" aria-label="stok" id="stok" name="stok"
                                            value="{{ old('stok', $complement->stok) }}">
                                        @error('stok')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 ms-3 me-3">
                                        <label for="image" class="form-label">Image</label>
                                        <input type="file" class="form-control border border-secondary-subtle @error('image') is-invalid @enderror" id="image" name="image">
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <br>
                                        @if ($complement->image)
                                            <img src="{{ asset('storage/' . $complement->image) }}" alt="Current Image" width="150">
                                        @endif
                                    </div>
                                    
                                    <div class="ms-3 me-3 text-end">
                                        <a href="{{route('complements.index')}}" type="button"
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
