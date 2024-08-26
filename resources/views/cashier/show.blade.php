@extends('dashboard.master')
@section('title', 'Order Details')
@section('sidebar')
    @include('cashier.sidebar')
@endsection
@section('page-title', 'Order Detail')
@section('page', 'Order Details')
@section('main')
    @include('cashier.main')

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
    </style>

    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card my-4">
                    <div class="card-header pb-0 navigation-links">
                        <a href="{{ route('cashier.index') }}">Back</a>
                    </div>
                    <div class="card-header pb-0">
                        <h6>Order Details</h6>
                    </div>
                    <div class="card-body px-0 pb-2">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
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
                                    <td>{{ \Carbon\Carbon::parse($order->order_date)->translatedFormat('d F Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <th>Total Amount</th>
                                    <td>Rp {{ number_format($order->total_amount) }}</td>
                                </tr>
                                <tr>
                                    <th>Status</th>
                                    <td style="color: {{ $order->status === 'unpaid' ? 'red' : ($order->status === 'paid' ? 'green' : 'black') }}">
                                        {{ $order->status }}
                                    </td>
                                </tr>
                                <tr>

                                </tr>
                                @if ($order->status === 'unpaid')
                                <tr>
                                    <td colspan="2">
                                        <form action="{{ route('payments.store', $order->id) }}" method="POST" class="text-end">
                                            @csrf
                                            <div class="amount-input">
                                                <label for="amount_given">Amount Given:</label>
                                                <input type="number" name="amount_given" id="amount_given" min="0" step="0.01" oninput="calculateChange()">
                                            </div>
                                            <div class="change-display" id="change-display">
                                                Change: <span id="change-amount">Rp 0</span>
                                            </div>
                                            <button type="submit" name="action" value="cancel" class="btn btn-danger" onclick="return confirm('Are you sure you want to cancel this Order ?')">Cancel Order</button>
                                            <button type="submit" name="action" value="process" class="btn btn-success">Process Payment</button>
                                        </form>
                                    </td>
                                </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
    </script>
@endsection
