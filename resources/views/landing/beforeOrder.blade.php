@extends('landing.master')
@section('title', 'Before Order')
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
    .card-section {
        margin-bottom: 30px; /* Add margin between sections */
    }
    .shadow {
        box-shadow: 0 4px 8px rgba(0,0,0,0.1); /* Add shadow for a lifted effect */
    }
    .form-section {
        border-radius: 20px;
    }
    .container {
        min-height: 100vh;
        max-width: 800px;
        margin: 0 auto;
        padding: 20px;
    }

</style>

<div class="container mt-4">
    <div class="row">
        <!-- Order Details -->
        <div class="col-lg-10 col-xl-7 m-lr-auto m-b-50 card-section">
            <div class="m-l-25 m-r--38 m-lr-0-xl shadow form-section">
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

        <!-- Payment -->
        <div class="col-sm-10 col-lg-7 col-xl-5 m-lr-auto m-b-50 card-section">
            <div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm shadow form-section">
                <form id="checkoutForm" action="{{ route('yourorder.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product['product_id'] }}">
                    <input type="hidden" name="total_amount" value="{{ $product['price'] }}">

                    <div class="flex-w flex-t bor12 p-t-15 p-b-30">
                        <div class="size-208 w-full-ssm">
                            <span class="stext-110 cl2">
                                Payment Method :
                            </span>
                        </div>
                        <div class="size-209 p-r-18 p-r-0-sm w-full-ssm">
                            <div class="p-t-15">
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

                    <button type="submit" class="flex-c-m stext-101 cl0 size-116 bg3 bor14 p-lr-15 trans-04 mb-2 pointer">
                        Proceed to Checkout
                    </button>
                    <br>
                    <a href="{{route('landing.index')}}"><span>Cancel Order</span></a>
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
