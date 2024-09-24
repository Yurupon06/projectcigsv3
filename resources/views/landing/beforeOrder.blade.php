@extends('landing.master')
@section('title',  isset($setting) ? $setting->app_name : ' - Before Order' ?? 'Before Order')
@section('main')
    <style>
        .pointer {
            display: inline-block;
            padding: 12px 20px;
            background-color: #000000;
            color: #fff;
            border-radius: 30px;
            text-decoration: none;
            font-size: 16px;
            font-weight: bold;
        }

        .pointer:hover {
            background-color: #DC5F00;
            transform: scale(1.05);
        }

        .container {
            padding-top: 60px;
            padding-bottom: 100px;
        }
    </style>
    <div class="container mt-4 flex-wrap">
        <div class="row">
            <div class="col-md-12 ">
                <div class="shadow p-3" style="border-radius: 20px">
                    <div class="wrap-table-shopping-cart" style="border-radius: 20px">
                        <table class="table align-items-center mb-0">
                            <tr>
                                <th>Name</th>
                                <td>{{ $user->name }}</td>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <td>{{ $user->email }}</td>
                            </tr>
                            <tr>
                                <th>Phone</th>
                                <td>{{ $customer->phone }}</td>
                            </tr>
                            <tr>
                                <th>Product</th>
                                <td>{{ $product['product_name'] }}</td>
                            </tr>
                            <tr>
                                <th>Product Description</th>
                                <td>{{ $product['description'] }}</td>
                            </tr>
                            <tr>
                                <th>Product Price</th>
                                <td>Rp {{ number_format($product['price']) }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-12" style="border-radius: 20px">
                <div class="shadow p-3" style="border-radius: 20px">
                    <form id="checkoutForm" action="{{ route('yourorder.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product['product_id'] }}">
                        <input type="hidden" name="total_amount" value="{{ $product['price'] }}">

                        <div>
                            <div>
                                <span class="stext-110 cl2">
                                    Payment Method :
                                </span>
                            </div>
                            <div>
                                <div>
                                    <div class="rs1-select2 rs2-select2 bor8 bg0 m-b-12 m-t-9">
                                        <select class="js-select2" name="payment_method">
                                            <option value="" selected disabled>Select a payment method</option>
                                            <option value="cash">Cash</option>
                                        </select>
                                        <div class="dropDownSelect2"></div>
                                    </div>
                                </div>
                            </div>
                            <div id="alertMessage" class="alert alert-danger" style="display:none;">
                                Please select a payment method.
                            </div>
                        </div>

                        <div class="flex-w flex-t p-t-27 p-b-33">
                            <div class="size-208">
                                <span class="mtext-101 cl2">
                                    Total:
                                </span>
                            </div>

                            <div class="size-209 p-t-1">
                                <span class="mtext-110 cl2">
                                    Rp {{ number_format($product['price']) }}
                                </span>
                            </div>
                        </div>


                        <button type="submit"
                            class="flex-c-m stext-101 cl0 size-116 bg3 bor14 p-lr-15 trans-04 mb-2 pointer">
                            Proceed to Checkout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('checkoutForm').addEventListener('submit', function(event) {
            var selectElement = document.querySelector('select[name="payment_method"]');
            var alertMessage = document.getElementById('alertMessage');
            if (!selectElement.value) {
                alertMessage.style.display = 'block';
                event.preventDefault();
            } else {
                alertMessage.style.display = 'none';
            }
        });
    </script>
@endsection
