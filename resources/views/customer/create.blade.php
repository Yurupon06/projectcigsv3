@extends('dashboard.master')
@section('title', 'customer  create')
@section('sidebar')
    @include('dashboard.sidebar')
@endsection
@section('page-title', 'customer  Create')
@section('page', 'customer / create')
@section('main')
    @include('dashboard.main')

<!-- Tables -->
    <div class="container-fluid py-4">
      <div class="row">
        <div class="col-12">
          <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>New customer</h6>
            </div>
            <div class="card-body px-0 pt-0 pb-2">
              <div class="table-responsive p-0">
                <div class="card border-1 m-3 pt-3">
                  <form action="{{ route('customer.store')}}" method="POST" enctype="multipart/form-data">
                      @csrf
                        <div class="mb-2 ms-3 me-3">
                            <label for="user_id" class="form-label">name</label>
                            <select id="user_id" name="user_id" class="ps-2 form-select" aria-label="Default select example">
                                <option selected disabled>Select Name</option>
                                @foreach ($user as $dt)
                                    <option value="{{ $dt->id }}">{{ $dt->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3 ms-3 me-3">
                            <label for="phone" class="form-label">phone</label>
                            <input type="number" class="ps-2 form-control border border-secondary-subtle @error('phone') is-invalid @enderror" placeholder="phone" aria-label="phone" id="phone" name="phone" value="{{ old('phone') }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 ms-3 me-3">
                            <label for="born" class="form-label">born</label>
                            <input type="date" class="ps-2 form-control border border-secondary-subtle @error('born') is-invalid @enderror" placeholder="born" aria-label="born" id="born" name="born" value="{{ old('born') }}">
                            @error('born')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 ms-3 me-3">
                            <label for="gender">Jenis Kelamin</label>
                            <select class="form-select @error('gender') is-invalid @enderror" id="gender" name="gender">
                                <option value="men" @if (old('gender') == 'men') selected @endif>men</option>
                                <option value="women" @if (old('gender') == 'women') selected @endif>women</option>
                            </select>
                          </div>
                        <div class="ms-3 me-3 text-end">
                            <a href="{{ route('customer.index')}}" type="button" class="btn bg-gradient-primary ws-15 my-4 mb-2">Cancel</a>
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