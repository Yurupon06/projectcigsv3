@extends('cashier.master')
@section('title', 'Add Order')
@section('sidebar')
    @include('cashier.sidebar')
@endsection
@section('page-title', 'Add Order')
@section('page', 'Customer / Create')
@section('main')
    @include('cashier.main')

    <!-- Tables -->
    <div class="container-fluid mt-6 py-4">
        <div class="row">
            @if(session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <div class="card border-1">
                                <form action="{{ route('make.order') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-1 ms-3 me-3 mt-2">
                                        <label for="customer_id" class="form-label">Name</label>
                                        <select id="customer_id" name="customer_id" class="ps-2 form-select" aria-label="Select Name">
                                            <option selected disabled>Select Name</option>
                                            @foreach($customer as $dt)
                                                <option value="{{ $dt->id }}" {{ session('new_customer_id') == $dt->id ? 'selected' : '' }}>
                                                    {{ $dt->user->name }} ( {{$dt->phone}} )
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-1 ms-3 me-3">
                                        <label for="product_id" class="form-label">Product</label>
                                        <select id="product_id" name="product_id" class="ps-2 form-select" aria-label="Select Product">
                                            <option selected disabled>Select Product</option>
                                            @foreach($product as $dt)
                                            <option value="{{ $dt->id }}" data-description="{{ $dt->description }}" data-price="{{ $dt->price }}" data-visit="{{$dt->productcat->visit}}">
                                                {{ $dt->product_name }}
                                            </option>
                                            @endforeach
                                        </select>
                                    </div>
                                
                                    <div class="mb-1 ms-3 me-3">
                                        <label for="description" class="form-label">Product Description</label>
                                        <textarea id="description" class="ps-2 form-control" readonly></textarea>
                                    </div>
                                
                                    <div class="mb-1 ms-3 me-3">
                                        <label for="price" class="form-label">Product Price</label>
                                        <input type="text" id="price" name="price" class="ps-2 form-control" readonly>
                                    </div>
                                    <div class="mb-1 ms-3 me-3">
                                        <label for="visit" class="form-label">Product visit</label>
                                        <input type="text" id="visit" name="visit" class="ps-2 form-control" readonly>
                                    </div>
                                    
                                    <div class="ms-1 me-3 mt-2 text-end">
                                        <a href="#" type="button" class="btn btn-secondary">Cancel</a>
                                        <button type="submit" class="btn btn-primary">Make Order</button>
                                    </div>
                                </form>                      
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Card on the Right -->
            <div class="col-md-4">
                <div class="card" style="height: 100%">
                    <div class="card-header text-uppercase font-weight-bolder opacity-20" >
                        <h6>Add Order and Register Customer</h6>
                    </div>
                    <div class="modal-body pt-4 px-3">
                    <form id="addCustomerForm" action="{{ route('customer.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" id="name" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" id="phone" name="phone" class="form-control" required>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-primary">Add Customer</button>
                        </div>
                    </form>
                </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    document.getElementById('product_id').addEventListener('change', function() {
        var selectedOption = this.options[this.selectedIndex];
        var description = selectedOption.getAttribute('data-description');
        var price = selectedOption.getAttribute('data-price');
        var visit = selectedOption.getAttribute('data-visit');

        document.getElementById('description').value = description;
        document.getElementById('price').value = price;
        document.getElementById('visit').value = visit;
    });
</script>
@endsection
