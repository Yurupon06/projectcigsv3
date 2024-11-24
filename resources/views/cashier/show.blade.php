@extends('dashboard.master')
@section('title', isset($setting) ? $setting->app_name . ' - Order Detail' : 'Order Detail')
@section('sidebar')
    @include('cashier.sidebar')
@endsection
@section('page-title', 'Order Detail')
@section('page', 'Order Details')
@section('main')
    @include('cashier.main')

    @if (session('success'))
        <div style="color: green;">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div style="color: red;">
            {{ session('error') }}
        </div>
    @endif

    <style>
        .navigation-links {
            display: flex;
            justify-content: space-between;
        }

        .navigation-links a {
            text-decoration: none;
            color: #007BFF;
            font-weight: bold;
        }

        .navigation-links a:hover {
            text-decoration: underline;
        }

        .change-display {
            margin-bottom: 1rem;
            text-align: right;
            font-weight: bold;
        }

        .change-display span {
            color: green;
        }

        .amount-input {
            margin-bottom: 1rem;
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        .amount-input input {
            width: 200px;
            padding: 0.5rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-left: 10px;
        }

        .amount-input label {
            font-weight: bold;
        }

        .number-buttons {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 10px;
            margin-top: 20px;
            padding: 20px;
        }

        .number-buttons button {
            width: 100%;
            height: 60px;
            font-size: 24px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #f8f9fa;
            color: #495057;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.2s;
        }

        .number-buttons button:hover {
            background-color: #e2e6ea;
        }

        .number-buttons button:active {
            transform: scale(0.95);
        }

        .card-custom {
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .btn-delete {
            background-color: #dc3545;
            color: white;
            font-size: 24px;
        }

        .btn-delete:hover {
            background-color: #c82333;
        }
    </style>

    <div class="container-fluid py-6">
        <div class="row">
            <div class="col-md-8">
                <div class="card my-4">
                    <div class="card-header pb-0 navigation-links">
                        <a href="{{ route('cashier.index') }}">Back</a>
                    </div>
                    <div class="card-header pb-0 py-1">
                        <h6>Order Details</h6>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <tbody>
                                    <tr>
                                        <th>Customer Name</th>
                                        <td>{{ $order->customer->user->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Product</th>
                                        <td>{{ $order->product->product_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Order Date</th>
                                        <td>{{ \Carbon\Carbon::parse($order->order_date)->translatedFormat('d F Y H:i') }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Total Amount</th>
                                        <td>Rp {{ number_format($order->total_amount) }}</td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td
                                            style="color: {{ $order->status === 'unpaid' ? 'red' : ($order->status === 'paid' ? 'green' : 'black') }}">
                                            {{ $order->status }}
                                        </td>
                                    </tr>
                                    <tr>
                                        
                                    </tr>
                                    @if ($order->status === 'unpaid')
                                    <tr>
                                        <td colspan="3">
                                            <form action="{{ route('payments.store', $order->id) }}" method="POST">
                                            <!-- Container untuk Amount Input dan Change Display -->
                                            <div class="mb-3">
                                                <div class="amount-input mb-2">
                                                    <label for="amount_given">Amount Given:</label>
                                                    <input type="number" name="amount_given" id="amount_given" min="0" step="0.01"
                                                           oninput="calculateChange()" onkeydown="inputE(event)">
                                                </div>
                                                <div class="change-display" id="change-display">
                                                    Change: <span id="change-amount">Rp 0</span>
                                                </div>
                                            </div>
                                    
                                            <!-- Container untuk Tombol dalam satu baris -->
                                            <div class="d-flex align-items-center justify-content-end gap-2">
                                                <!-- Form untuk Cancel dan Process Payment -->
                                                
                                                    @csrf
                                                    <!-- Cancel Order Button -->
                                                    <button type="submit" name="action" value="cancel" class="btn btn-danger"
                                                            onclick="return confirm('Are you sure you want to cancel this Order?')">Cancel Order</button>
                                    
                                                    <!-- Process Payment Button -->
                                                    <button type="submit" name="action" value="process" class="btn btn-success" id="processPaymentBtn">Process Payment</button>
                                                </form>
                                    
                                                <!-- Pay Button di luar form -->
                                                <button name="action" type="button" id="pay-button" class="btn btn-warning">Transfer</button>
                                            </div>
                                        </td>
                                    </tr>
                                    
                                    
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- New Column for Number Buttons -->
            <div class="col-md-4">
                <div class="card card-custom mt-4" style="height: 92%">
                    <div class="card-header">
                        <h6 class="mb-0">Number Pad</h6>
                    </div>
                    <div class="card-body">
                        <div class="number-buttons">
                            @for ($i = 1; $i <= 9; $i++)
                                <button type="button"
                                    onclick="appendNumber('{{ $i }}')">{{ $i }}</button>
                            @endfor
                            <button type="button" onclick="appendNumber('0')">0</button>
                            <button type="button" onclick="appendNumber('.')">.</button>
                            <button type="button" class="btn-delete" onclick="deleteLastDigit()">C</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
    <script type="text/javascript">
        document.getElementById('pay-button').onclick = function(){
          // SnapToken acquired from previous step
          snap.pay('{{ $order->snap_token }}', {
            // Optional
            onSuccess: function(result){
                // alert("payment successful");
                window.location.href = '{{ route('struk_gym', ['id' => $order->id]) }}';
                console.log("Payment Success:", result);
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


    <!-- Include SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Display SweetAlert based on session flash data or validation errors -->
    <script>
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: '{{ session('success') }}',
            });
        @endif

        @if ($errors->any())
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: '{{ $errors->first() }}',
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
            });
        @endif
    </script>

    <script>
        function calculateChange() {
            const amountGiven = parseFloat(document.getElementById('amount_given').value) || 0;
            const totalAmount = {{ $order->total_amount }};
            const change = amountGiven - totalAmount;

            document.getElementById('change-amount').textContent = 'Rp ' + change.toLocaleString('id-ID');
        }

        function inputE(e) {
            if (e.key === 'e' || e.key === 'E' || e.key === '-') {
                e.preventDefault();
            }
        }

        function appendNumber(number) {
            const input = document.getElementById('amount_given');
            if (number === '.' && input.value.includes('.')) return; // Prevent multiple dots
            input.value = (input.value || '') + number;
            input.focus();
            calculateChange();
        }

        function deleteLastDigit() {
            const input = document.getElementById('amount_given');
            input.value = input.value.slice(0, -1);
            calculateChange();
        }
    </script>

    <script>
        const data = {
        phone: '{{ $order->customer->phone }}',
        customer_name: '{{ $order->customer->user->name }}',
        amount: totalAmount,
        order_date: '{{ \Carbon\Carbon::parse($order->order_date)->toDateString() }}',
        _token: '{{ csrf_token() }}'
    };

    // Kirim request AJAX ke server
    $.ajax({
        url: '{{ route('send.payment.message') }}',
        type: 'POST',
        data: data,
        success: function(response) {
            if (response.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Payment Processed',
                    text: 'Payment notification sent to WhatsApp!',
                }).then(() => {
                    // Redirect setelah sukses
                    window.location.href = '{{ route('cashier.index') }}';
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: response.message,
                });
            }
        },
        error: function(response) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to send WhatsApp notification.',
            });
        }
    });
    </script>
@endsection
