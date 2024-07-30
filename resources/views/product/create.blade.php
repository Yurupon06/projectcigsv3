@extends('dashboard.master')
@section('title', 'product  create')
@section('sidebar')
    @include('dashboard.sidebar')
@endsection
@section('page-title', 'product  Create')
@section('page', 'product / create')
@section('main')
    @include('dashboard.main')

<!-- Tables -->
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>New product</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <div class="card border-1 m-3 pt-3">
                  <form action="{{ route('product.store')}}" method="POST" enctype="multipart/form-data">
                      @csrf
                        <div class="mb-2 ms-3 me-3">
                            <label for="product_category_id" class="form-label">name</label>
                            <select id="product_category_id" name="product_category_id" class="ps-2 form-select" aria-label="Default select example">
                                <option selected disabled>Select category</option>
                                @foreach ($productcat as $dt)
                                    <option value="{{ $dt->id }}">{{ $dt->category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 ms-3 me-3">
                            <label for="product_name" class="form-label">product name</label>
                            <input type="text" class="ps-2 form-control border border-secondary-subtle @error('product_name') is-invalid @enderror" placeholder="product name" aria-label="product_name" id="product_name" name="product_name" value="{{ old('product_name') }}">
                            @error('product_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 ms-3 me-3">
                            <label for="description" class="form-label">description</label>
                            <textarea class="ps-2 form-control border border-secondary-subtle" name="description" id="description" placeholder="Description"></textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 ms-3 me-3">
                            <label for="price" class="form-label">price</label>
                            <input type="number" class="ps-2 form-control border border-secondary-subtle @error('price') is-invalid @enderror" placeholder="price" aria-label="price" id="price" name="price" value="{{ old('price') }}">
                            @error('price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="ms-3 me-3 text-end">
                            <a href="{{ route('product.index')}}" type="button" class="btn bg-gradient-primary ws-15 my-4 mb-2">Cancel</a>
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