@extends('cashier.master')
@section('title', isset($setting) ? $setting->app_name . ' - Add Order' : 'Add Order')
@section('sidebar')
    @include('cashier.sidebar')
@endsection
@section('page-title', 'Add Order')
@section('page', 'Customer / Create')
@section('main')
    @include('cashier.main')
    <div class="container mt-4">
        <h1 class="mb-4">Order Details - Order # {{ $orderComplement->id }}</h1>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Order # {{ $orderComplement->id }}</h5>
            </div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Complement</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-right">Sub Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orderDetails as $dt)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ asset('storage/' . $dt->complement->image) }}" alt="{{ $dt->complement->name }}" class="img-thumbnail" style="width: 50px; height: 50px; margin-right: 10px;">
                                        {{ $dt->complement->name }}
                                    </div>
                                </td>
                                <td class="text-center">{{ $dt->quantity }}</td> 
                                <td class="text-right">Rp {{ number_format($dt->sub_total) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2" class="text-right"><strong>Total</strong></td>
                            <td class="text-right"><strong>Rp {{ number_format($orderDetails->sum('sub_total')) }}</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            @if ($orderComplement->status === 'paid')
            <div class="card-footer d-flex justify-content-end gap-2">
                <a href="{{ route('cashier.payment', ['filter' => 'complement', 'per_page' => request('per_page')]) }}" name="action" value="process" class="btn btn-primary">Back</a>
            </div>
            @else
            <div class="card-footer d-flex justify-content-end gap-2">
                <form action="{{ route('payments.complement', $orderComplement->id) }}" method="POST">
                    @csrf
                    <div class="amount-input">
                        <label for="amount_given">Amount Given:</label>
                        <input type="number" name="amount_given" id="amount_given"
                            min="0" step="0.01" oninput="calculateChange()"
                            onkeydown="inputE(event)">
                    </div>
                    <div class="change-display" id="change-display">
                        Change: <span id="change-amount">Rp 0</span>
                    </div>
                    <br>
                    <button type="submit" name="action" value="cancel"  class="btn btn-danger">Cancel</button>
                    <button type="submit" name="action" value="process" class="btn btn-primary">Proceed to Payment</button>
                </form>
            </div>
            @endif
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
            const totalAmount = {{$orderComplement->total_amount}};
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
@endsection
