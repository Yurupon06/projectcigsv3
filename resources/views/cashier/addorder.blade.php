@extends('dashboard.master')
@section('title', 'Add Order')
@section('sidebar')
    @include('cashier.sidebar')
@endsection
@section('page-title', 'Add Order')
@section('page', 'Customer / Create')
@section('main')
    @include('cashier.main')

<!-- Tables -->
<div class="container-fluid py-4">
    <div class="row">
    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#addCustomerModal">
                        <span class="badge badge-sm bg-gradient-primary mb-3 fs-6">
                          <i class="material-icons opacity-10">person_add</i>
                        </span>
                    </a>
                    <h6>Add Order</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <div class="card border-1 m-3 pt-3">
                            <form action="{{ route('make.order') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3 ms-3 me-3">
                                    <label for="customer_id" class="form-label">Name</label>
                                    <select id="customer_id" name="customer_id" class="ps-2 form-select" aria-label="Select Name">
                                        <option selected disabled>Select Name</option>
                                        @foreach($customer as $dt)
                                            <option value="{{ $dt->id }}" {{ session('new_customer_id') == $dt->id ? 'selected' : '' }}>
                                                {{ $dt->user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-2 ms-3 me-3">
                                    <label for="product_id" class="form-label">Product</label>
                                    <select id="product_id" name="product_id" class="ps-2 form-select" aria-label="Select Product">
                                        <option selected disabled>Select Product</option>
                                        @foreach($product as $dt)
                                            <option value="{{ $dt->id }}" data-description="{{ $dt->description }}" data-price="{{ $dt->price }}">
                                                {{ $dt->product_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            
                                <div class="mb-3 ms-3 me-3">
                                    <label for="description" class="form-label">Product Description</label>
                                    <textarea id="description" class="ps-2 form-control" readonly></textarea>
                                </div>
                            
                                <div class="mb-3 ms-3 me-3">
                                    <label for="price" class="form-label">Product Price</label>
                                    <input type="text" id="price" name="price" class="ps-2 form-control" readonly>
                                </div>
                                <div class="ms-3 me-3 text-end">
                                    <a href="" type="button" class="btn bg-gradient-primary ws-15 my-4 mb-2">Cancel</a>
                                    <button type="submit" class="btn bg-gradient-success ws-15 my-4 mb-2">Make Order</button>
                                </div>
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Customer Modal -->
<div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addCustomerModalLabel">Add Customer</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="addCustomerForm" action="{{ route('customer.store') }}" method="POST">
            @csrf
            <div class="mb-3">
              <label for="user_id" class="form-label">Select User</label>
              <select id="user_id" name="user_id" class="form-select" required>
                <option selected disabled>Select User</option>
                @foreach($usersWithoutCustomer as $user)
                  <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="mb-3">
              <label for="phone" class="form-label">Phone</label>
              <input type="text" id="phone" name="phone" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Customer</button>
          </form>
        </div>
      </div>
    </div>
  </div>

<script>
    document.getElementById('product_id').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        var description = selectedOption.getAttribute('data-description');
        var price = selectedOption.getAttribute('data-price');

        document.getElementById('description').value = description;
        document.getElementById('price').value = price;
    });
</script>

@endsection
