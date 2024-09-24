@extends('dashboard.master')
@section('title', isset($setting) ? $setting->app_name . ' - Product' : 'Product')
@section('sidebar')
    @include('dashboard.sidebar')
@endsection
@section('page-title', 'Product')
@section('page', 'Product')
@section('main')
    @include('dashboard.main')

    <div class="container-fluid pb-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                <div class="card-header pb-0 py-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('product.create') }}">
                                <span class="btn btn-sm bg-gradient-primary mb-3 fs-6">Add new item</span>
                            </a>

                            <!-- Form Pencarian -->
                            <div class="input-group" style="max-width: 300px;">
                                <form method="GET" action="{{ route('product.index') }}" class="d-flex w-100">
                                    <input type="text" name="search" class="form-control"
                                        placeholder="Search Product" value="{{ request('search') }}"
                                        style="border-radius: 20px 0 0 20px; height: 38px; font-size: 14px;">
                                    <button type="submit" class="btn btn-primary"
                                        style="background-color: #ff7e00; border-radius: 0 20px 20px 0; height: 38px; padding: 0 10px; font-size: 14px;">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </form>
                            </div>

                            <!-- Opsi Show Per Page -->
                            <div class="d-flex align-items-center my-3">
                                <form method="GET" action="{{ route('productcategories.index') }}" class="d-flex">
                                    <label for="per_page" class="form-label me-2 mt-2">Show:</label>
                                    <select name="per_page" id="per_page" class="form-select form-select-sm w-auto me-3" onchange="this.form.submit()">
                                        <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
                                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                    </select>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">category name</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">product name</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">description</th>
                                        <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">price</th>
                                        <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="text-capitalize">
                                    @foreach ($product as $i => $dt)
                                        <tr>
                                            <td>
                                                <div class="d-flex px-2 py-1">
                                                    {{ ($product->currentPage() - 1) * $product->perPage() + $i + 1 . ' . ' }}
                                                </div>
                                            </td>
                                            <td>
                                                {{ $dt->productcat->category_name }}
                                            </td>
                                            <td>
                                                {{ $dt->product_name }}
                                            </td>
                                            <td>
                                                {{ $dt->description }}
                                            </td>
                                            <td>
                                                Rp {{ number_format($dt->price) }}
                                            </td>
                                            <td class="align-middle text-center text-sm">
                                                <a href="{{ route('product.edit', $dt->id) }}">
                                                    <span class="btn bg-gradient-success btn">
                                                    <i class="material-icons">edit</i></span>
                                                </a>
                                                <form action="{{ route('product.destroy', $dt->id) }}" method="POST"
                                                    class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn bg-gradient-danger btn"
                                                        onclick="return confirm('Are you sure you want to delete this category?')">
                                                        <i class="material-icons">delete</i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Paginate -->
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                {{ $product->appends(request()->except('page'))->links('pagination::bootstrap-5') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection