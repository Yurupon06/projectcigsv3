@extends('landing.master')
@section('title', isset($setting) ? $setting->app_name . ' - Checkout Complement' : 'Checkout Complement')
@section('main')

    <style>
        .cell-padding {
            padding-left: 10px;
            padding-right: 10px;
        }

        .flex-w {
            display: flex;
            flex-wrap: wrap;
        }

        .flex-sb {
            justify-content: space-between;
        }

        .mtext-110 {
            margin-right: 10px;
        }

        .mb-50 {
            margin-bottom: 50px;
        }

        .navigation-links {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .navigation-links a {
            text-decoration: none;
            color: #007BFF;
            font-weight: bold;
        }

        .navigation-links a:hover {
            text-decoration: underline;
        }

        .qr-code-container {
            text-align: center;
            margin-top: 30px;
        }

        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }

        .card-title {
            font-size: 18px;
            font-weight: bold;
        }

        .card-subtitle {
            font-size: 16px;
            color: #6c757d;
        }

        .card-text {
            font-size: 14px;
        }

        .status-badge {
            font-weight: bold;
        }

        .custom-button {
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .custom-button:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        @media (max-width: 576px) {
            .card-title {
                font-size: 16px;
            }

            .card-subtitle {
                font-size: 14px;
            }

            .card-text {
                font-size: 12px;
            }

            .navigation-links {
                flex-direction: column;
                align-items: flex-start;
            }
        }

        @media (min-width: 992px) {
            .container {
                display: flex;
                justify-content: center;
            }

            .row {
                max-width: 900px;
                width: 100%;
            }
        }

        .container {
            padding-bottom: 100px;
        }

        .img-complement {
            max-width: 40px;
            max-height: 40px;
            object-fit: contain;
        }
    </style>

    <div class="container mt-4">
        <div class="row">
            <!-- Navigation Back Link -->
            <div class="col-12 mb-3">
                <div class="navigation-links">
                    <a href="{{ route('yourorder.index') }}">Back</a>
                </div>
            </div>

            <!-- Profile Section -->
            <div class="col-12 mb-4">
                <div class="card ">
                    <h5 class="card-title">Profile</h5>
                    <div class="card-text">
                        <p>{{ $orderComplement->user->name }} ( {{ $customer->phone }} )</p>
                        <p>{{ $orderComplement->user->email }}</p>
                    </div>
                </div>
            </div>

            <!-- Order Details Section -->
            <div class="col-12 mb-4">
                <div class="card  total-summary">
                    <h5 class="card-title">Order Details</h5>

                    <table>
                        @foreach ($complementItems as $item)
                            <tr>
                                <td class="text-center">
                                    <img src="{{ asset('storage/' . $item->complement->image) }}" alt="Complement Image"
                                        class="img-complement">
                                </td>
                                <td>
                                    {{ $item->complement->name }} ({{ $item->quantity }} x Rp.
                                    {{ number_format($item->complement->price, 0, '.', '.') }})
                                </td>
                                <td class="text-end">
                                    Rp. {{ number_format($item->sub_total, 0, '.', '.') }}
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <div>
                            <strong>Subtotal:</strong>
                        </div>
                        <div>
                            <strong id="subtotal">Rp. <span
                                    id="subtotal-price">{{ number_format($orderComplement->total_amount, 0, '.', '.') }}</span></strong>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 mb-4">
                @if ($orderComplement->status === 'unpaid')
                    <div class="alert alert-warning">
                        Complete your payment.
                    </div>
                @endif
            </div>

            <div class="col-12 mb-4">
                @if ($orderComplement->payment_method === 'cash')
                    <div class="qr-code-container">
                        <div class="mt-3">Go To Cashier And Show The QrCode To Pay</div>
                        <br>
                        {!! QrCode::size(200)->generate('CHECKOUT_' . $orderComplement->qr_token) !!}
                    </div>
                    <br>
                @elseif ($orderComplement->payment_method === 'transfer')
                    @if ($orderComplement->status === 'paid')
                    <div class="qr-code-container">
                        <div class="mt-3">Go To Cashier And Show The QrCode To get your Complement</div>
                        <br>
                        {!! QrCode::size(200)->generate('CHECKOUT_' . $orderComplement->qr_token) !!}
                    </div>
                    <br>
                        
                    @endif
                @endif

                <div class="d-flex">
                    <div class="size-208">
                        <span class="mtext-101 cl2">
                            Total:
                        </span>
                    </div>
                    <div class="size-209 p-t-1 flex-w flex-sb">
                        <span class="mtext-110 cl2">
                            Rp {{ number_format($orderComplement->total_amount) }}
                        </span>
                        <span class="mtext-110 cl2"
                            style="color: {{ $orderComplement->status == 'unpaid' ? 'red' : ($orderComplement->status == 'canceled' ? 'gray' : 'green') }}; font-weight: bold;">
                            {{ ucfirst($orderComplement->status) }}
                        </span>
                    </div>
                </div>
                
                @if ($orderComplement->status === 'unpaid')
                @if ($orderComplement->payment_method === 'transfer')
                <div class="d-flex justify-content-center mt-2">
                        <button type="submit" id="pay-button" class="btn btn-success w-100 rounded-0">Pay</button>
                </div>
                @endif
                <div class="d-flex justify-content-center mt-2">
                        <form action="{{ route('complement.cancel', $orderComplement->id) }}" method="POST"
                            class="mt-3 w-100">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-dark w-100 rounded-0"
                                onclick="return confirm('Are you sure you want to cancel this order?')">Cancel
                                Order</button>
                        </form>
                </div>
                @endif
            </div>
        </div>
    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
<script type="text/javascript">
    document.getElementById('pay-button').onclick = function(){
      // SnapToken acquired from previous step
      snap.pay('{{ $orderComplement->snap_token }}', {
        // Optional
        onSuccess: function(result){
            // alert("payment successful");
            window.location.reload();
            console.log(result);
        },
        // Optional
        onPending: function(result){
          /* You may add your own js here, this is just example */ document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
        },
        // Optional
        onError: function(result){
          /* You may add your own js here, this is just example */ document.getElementById('result-json').innerHTML += JSON.stringify(result, null, 2);
        }
      });
    };
  </script>
@endsection
