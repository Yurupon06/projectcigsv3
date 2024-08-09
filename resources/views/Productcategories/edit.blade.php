@extends('dashboard.master')
@section('title', 'Product Categories Edit')
@section('sidebar')
    @include('dashboard.sidebar')
@endsection
@section('page-title', 'Product Categories Edit')
@section('page', 'Product Categories / Edit')
@section('main')
    @include('dashboard.main')

<!-- Tables -->
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Edit Product Categories</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <div class="card border-1 m-3 pt-3">
                  <form action="{{ route('productcategories.update', $productcat->id)}}" method="POST" enctype="multipart/form-data">
                      @csrf
                      @method('PUT')
                        <div class="mb-3 ms-3 me-3">
                            <label for="category_name" class="form-label">Category Name</label>
                            <input type="text" class="ps-2 form-control border border-secondary-subtle @error('category_name') is-invalid @enderror" placeholder="Category Name" aria-label="category_name" id="category_name" name="category_name" value="{{ old('category_name', $productcat->category_name) }}">
                            @error('category_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        
                        <div class="mb-3 ms-3 me-3">
                          <label for="type">Total Visit</label>
                          <select class="form-select @error('visit') is-invalid @enderror" id="visit" name="visit">
                              <option value="1" @if (old('visit') == '1') selected @endif>1</option>
                              <option value="30" @if (old('visit') == '30') selected @endif>30</option>
                          </select>
                          @error('visit')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3 ms-3 me-3">
                            <label for="cycle" class="form-label">Cycle (in day)</label>
                            <input type="number" class="ps-2 form-control border border-secondary-subtle @error('cycle') is-invalid @enderror" placeholder="Cycle" aria-label="cycle" id="cycle" name="cycle" value="{{ old('cycle', $productcat->cycle) }}">
                            @error('cycle')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>


                        <div class="ms-3 me-3 text-end">
                            <a href="{{ route('productcategories.index')}}" type="button" class="btn bg-gradient-primary ws-15 my-4 mb-2">Cancel</a>
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
