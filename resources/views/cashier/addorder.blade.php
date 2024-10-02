@extends('cashier.master')
@section('title', isset($setting) ? $setting->app_name . ' - Add Order' : 'Add Order')
@section('sidebar')
    @include('cashier.sidebar')
@endsection
@section('page-title', 'Add Order')
@section('page', 'Customer / Create')
@section('main')
    @include('cashier.main')

    <style>
        .select2-container--bootstrap-5 .select2-selection {
            border-radius: 0.375rem; /* Match Bootstrap 5 border radius */
            padding: 0.375rem;
            border: 1px solid #ced4da;
            height: calc(1.5em + 0.75rem + 2px);
        }
        .select2-container--bootstrap-5 .select2-selection__arrow {
            height: 100%;
        }

        .btn-membership:hover {
            background-color: #0056b3; /* Darker blue on hover */
            box-shadow: 0 6px 8px rgba(0, 0, 255, 0.2); /* Slightly larger shadow */
        }

        .btn-complement:hover {
            background-color: #e04e00; /* Darker orange on hover */
            box-shadow: 0 6px 8px rgba(255, 165, 0, 0.2); /* Slightly larger shadow */
        }
    </style>


    <!-- Tables -->
    <div class="container-fluid mt-5 py-4">
        <div class="row">   
            @if (session('success'))
                <div class="alert alert-success small" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <div class="col-md-8">
                <a href="{{route('cashier.order')}}" type="button" class="btn btn-primary btn-sm align-items-center btn-membership" style="font-size: 12px; padding: 10px 12px; background-color: #ff5c00; box-shadow: 0 4px 6px rgba(0, 0, 255, 0.1); border: none;">
                    <i class="fas fa-user-tag me-2" style="font-size: 18px;"></i> Membership
                </a>
                <a href="{{route('cashier.complement')}}" type="button" class="btn btn-sm align-items-center btn-complement" style="font-size: 12px; padding: 10px 12px; background-color:#007bff ; color: white; box-shadow: 0 4px 6px rgba(255, 165, 0, 0.1); border: none;">
                    <i class="fas fa-shopping-basket me-2" style="font-size: 18px;"></i> Complement
                </a>

                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <div class="card border-1">
                                <form action="{{ route('make.order') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-1 ms-3 me-3 mt-2">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <label for="customer_id" class="form-label">Select Name</label>
                                                <select id="customer_id" name="customer_id" class="ps-2 form-select select2" aria-label="Select Name" required>
                                                    <option value="" disabled selected>Select Customer</option>
                                                        @foreach ($customer as $dt)
                                                            @php
                                                                $phone = $dt->phone;
                                                                $maskedPhone = substr($phone, 0, 4) . '' . substr($phone, -4);
                                                            @endphp
                                                            <option value="{{ $dt->id }}" data-name="{{ $dt->user->name }}" data-phone="{{ $dt->phone }}"
                                                                {{ session('new_customer_id') == $dt->id ? 'selected' : '' }}>
                                                                {{ $dt->user->name }} ({{ $maskedPhone }})
                                                            </option>
                                                        @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-1 ms-3 me-3">
                                        <label for="product_id" class="form-label small">Product</label>
                                        <select id="product_id" name="product_id" class="ps-2 form-select form-select-sm"
                                            aria-label="Select Product" required>
                                            <option value="" disabled selected>Select Product</option>
                                            @foreach ($product as $dt)
                                                <option value="{{ $dt->id }}"
                                                    data-description="{{ $dt->description }}"
                                                    data-price="{{ $dt->price }}"
                                                    data-visit="{{ $dt->productcat->visit }}">
                                                    {{ $dt->product_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-1 ms-3 me-3">
                                        <label for="description" class="form-label small">Product Description</label>
                                        <textarea id="description" class="ps-2 form-control form-control-sm" readonly></textarea>
                                    </div>

                                    <div class="mb-1 ms-3 me-3">
                                        <label for="price" class="form-label small">Product Price</label>
                                        <input type="text" id="price" name="price" class="ps-2 form-control form-control-sm"
                                            readonly>
                                    </div>
                                    <div class="mb-1 ms-3 me-3">
                                        <label for="visit" class="form-label small">Product visit</label>
                                        <input type="text" id="visit" name="visit" class="ps-2 form-control form-control-sm"
                                            readonly>
                                    </div>

                                    <div class="ms-1 me-3 mt-2 text-end">
                                        <a href="{{ route('cashier.index') }}" type="button" class="btn btn-secondary">Cancel</a>
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
                    <div class="card-header text-uppercase font-weight-bolder opacity-20 text-centersmall text-center py-2 mt-2">
                        <h6>For Register Customer</h6>
                    </div>
                    <div class="modal-body pt-4 px-3">
                        <form id="addCustomerForm" action="{{ route('customer.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label small">Name</label>
                                <input type="text" id="name" name="name" class="form-control form-control-sm" required>
                            </div>
                            {{-- <div class="mb-3">
                                <label for="email" class="form-label small">Email</label>
                                <input type="email" id="email" name="email" class="form-control form-control-sm" required>
                            </div> --}}
                            <div class="mb-3">
                                <label for="phone" class="form-label small">Phone</label>
                                <input type="number" id="phone" name="phone" class="form-control form-control-sm" required>
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
    <script>
        document.getElementById('customer_search').addEventListener('input', function() {
            var searchValue = this.value.toLowerCase();
            var select = document.getElementById('customer_id');
            var options = select.getElementsByTagName('option');
            var selectedCustomerInput = document.getElementById('selected_customer');

            for (var i = 0; i < options.length; i++) {
                var option = options[i];
                var name = option.getAttribute('data-name');
                var phone = option.getAttribute('data-phone');

                if (name && phone) {
                    var text = (name + ' ' + phone).toLowerCase();
                    if (text.indexOf(searchValue) > -1) {
                        option.style.display = '';
                        if (searchValue.length > 0) {
                            selectedCustomerInput.value = name + ' (' + phone + ')';
                            return;
                        }
                    } else {
                        option.style.display = 'none';
                    }
                }
            }

            if (searchValue.length === 0) {
                selectedCustomerInput.value = '';
            }
        });
    </script>
    <script>
        document.getElementById('customer_id').addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            var name = selectedOption.getAttribute('data-name');
            var phone = selectedOption.getAttribute('data-phone');
            document.getElementById('selected_customer').value = name + ' (' + phone + ')';
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const customerSearch = document.getElementById('customer_search');
            const customerSearchResults = document.getElementById('customer_search_results');
            const customerSelect = document.getElementById('customer_id');
            const selectedCustomerInput = document.getElementById('selected_customer');

            customerSearch.addEventListener('input', function() {
                const searchValue = this.value.toLowerCase();
                const options = customerSelect.getElementsByTagName('option');
                const results = [];

                for (let option of options) {
                    if (option.value && option.text.toLowerCase().includes(searchValue)) {
                        results.push(option);
                    }
                }

                displayResults(results);
            });

            function displayResults(results) {
                customerSearchResults.innerHTML = '';
                if (results.length > 0) {
                    results.forEach(result => {
                        const li = document.createElement('li');
                        li.classList.add('list-group-item', 'list-group-item-action');
                        li.textContent = result.text;
                        li.addEventListener('click', () => selectCustomer(result));
                        customerSearchResults.appendChild(li);
                    });
                    customerSearchResults.classList.remove('d-none');
                } else {
                    customerSearchResults.classList.add('d-none');
                }
            }

            function selectCustomer(option) {
                customerSelect.value = option.value;
                selectedCustomerInput.value = option.text;
                customerSearch.value = option.text;
                customerSearchResults.classList.add('d-none');
            }

            // Sembunyikan hasil pencarian saat mengklik di luar area pencarian
            document.addEventListener('click', function(event) {
                if (!customerSearch.contains(event.target) && !customerSearchResults.contains(event.target)) {
                    customerSearchResults.classList.add('d-none');
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#customer_id').select2({
                placeholder: "Select Customer",
                allowClear: true
            });
        });
    </script>
@endsection