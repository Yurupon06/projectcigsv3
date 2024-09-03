@extends('dashboard.master')
@section('title', 'complement Create')
@section('sidebar')
    @include('dashboard.sidebar')
@endsection
@section('page-title', 'complement Create')
@section('page', 'complement / Create')
@section('main')
    @include('dashboard.main')

<!-- Tables -->
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>New complement</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <div class="card border-1 m-3 pt-3">
                  <form action="{{route('complement.store')}}" method="POST" enctype="multipart/form-data">
                      @csrf
                      <div class="mb-3 ms-3 me-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="ps-2 form-control border border-secondary-subtle @error('name') is-invalid @enderror" placeholder="Name" aria-label="name" id="name" name="name" value="{{ old('name') }}">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 ms-3 me-3">
                        <label for="category" class="form-label">category</label>
                        <select class="form-select border border-secondary-subtle @error('category') is-invalid @enderror" id="category" name="category">
                          <option value="" disabled selected>Select category</option>
                          <option value="food" {{ old('category') == 'food' ? 'selected' : '' }}>food</option>
                          <option value="drink" {{ old('category') == 'drink' ? 'selected' : '' }}>drink</option>
                          <option value="suplement" {{ old('category') == 'suplement' ? 'selected' : '' }}>suplement</option>
                        </select>
                        @error('category')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 ms-3 me-3">
                        <label for="description" class="form-label">description</label>
                        <textarea class="ps-2 form-control border border-secondary-subtle @error('description') is-invalid @enderror"
                            name="description" id="description" placeholder="Description"></textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 ms-3 me-3">
                        <label for="price" class="form-label">price</label>
                        <input type="number"
                            class="ps-2 form-control border border-secondary-subtle @error('price') is-invalid @enderror"
                            placeholder="price" aria-label="price" id="price" name="price"
                            value="{{ old('price') }}">
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 ms-3 me-3">
                        <label for="stok" class="form-label">stok</label>
                        <input type="number"
                            class="ps-2 form-control border border-secondary-subtle @error('stok') is-invalid @enderror"
                            placeholder="stok" aria-label="stok" id="stok" name="stok"
                            value="{{ old('stok') }}">
                        @error('stok')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3 ms-3 me-3">
                        <label for="image" class="formlabel">image _url1</label>
                        <input class="ps-2 form-control border border-secondary-subtle @error('image') isinvalid @enderror" type="file" id="image" name="image">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                      
                      <div class="ms-3 me-3 text-end">
                          <a href="" type="button" class="btn bg-gradient-primary ws-15 my-4 mb-2">Cancel</a>
                          <button type="submit" class="btn bg-gradient-success ws-15 my-4 mb-2">Save</button>
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
