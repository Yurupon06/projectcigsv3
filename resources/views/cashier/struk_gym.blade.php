<!DOCTYPE html>
<html>

<head>
	<title>Struk Gym</title>
	<style>
		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}

		body {
			font-family: Verdana, Geneva, Tahoma, sans-serif;
			font-size: 10pt;
		}

		.container {
			width: 300px;
			margin: 0 auto;
			border: 1px solid #000;
		}

		.table {
			width: 100%;
			border-collapse: collapse;
		}

		.table th,
		.table td {
			text-align: left;
		}

		.align-right {
			text-align: right !important;
		}

		.align-center {
			text-align: center !important;
		}

		.receipt-header,
		.receipt-footer,
		.qr-code {
			text-align: center;
		}

		.receipt-footer {
			text-align: center;
			/* Center-align footer content */
		}

		.print-button {
			text-align: center;
			margin-top: 20px;
		}

		@media print {
			@page {
				size: 58mm auto;
			}

			.container {
				margin: 0;
				width: 58mm;
				border: none;
			}

			.print-button {
				display: none;
			}
		}

		hr {
			border: 1px solid #000;
			margin: 7px 0;
		}
	</style>
</head>

<body>
	<?php
	// Data struk dummy
	$receipt = [
		"member_name" => "John Doe",
		"date" => "2024-08-07",
		"cashier_name" => "John Doe",
		"items" => [
			["description" => "Monthly Membership", "price" => 123456700],
		],
		"total" => 123456700,
		"cash" => 125000000,
		"change" => 1543300
	];
	?>

	<div class="container">
        <table class="table">
            <tr>
                <td colspan="2" class="align-center">
                    <img width='100' src='../../assets/images/2.png'>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="align-center">
                    <h1>{{ $appSetting->app_name }}</h1>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="align-center">
                    {{ $appSetting->app_address }}<br>
                </td>
            </tr>
        </table>
        <hr>
        <table class="table">
        <tr>
            <td>Cashier</td>
            <td class="align-right">{{ $payment->cashier_name }}</td>
        </tr>
        <tr>
            <td>Order ID</td>
            <td class="align-right">GYM{{ $payment->order->id }}</td>
        </tr>
        <tr>
            <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('Y-m-d') }}</td>
            <td class="align-right">{{ \Carbon\Carbon::parse($payment->payment_date)->format('H:i:s') }}</td>
        </tr>
    </table>

        <hr>
        <table class="table">
            <tr>
                <td>{{ $payment->order->product->product_name }}</td>
                <td class="align-right">{{ number_format($payment->order->product->price, 0, ',', '.') }}</td>
            </tr>
        </table>
        <hr>
        <table class="table">
            <tr>
                <td><b>Total</b></td>
                <td class="align-right">
                    <h1><b>Rp {{ number_format($payment->amount, 0, ',', '.') }}</b></h1>
                </td>
            </tr>
        </table>
        <hr>
        <table class="table">
            <tr>
                <td>Cash</td>
                <td class="align-right">Rp {{ number_format($payment->amount_given, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Change</td>
                <td class="align-right"><b>Rp {{ number_format($payment->change, 0, ',', '.') }}</b></td>
            </tr>
        </table>
        <hr>
        @if($visit == 30)
            <table class="table">
                <tr>
                    <td>Member</td>
                    <td class="align-right"><b>{{ $payment->order->customer->user->name }}</b></td>
                </tr>
                <tr>
                    <td>No Hp</td>
                    <td class="align-right">{{ $payment->order->customer->phone }}</td>
                </tr>
            </table>
        @elseif($visit == 1)
            <table class="table">
                <tr>
                    <td colspan="2">
                        <div class="qr-code">
                            {!! QrCode::size(100)->generate(route('cashier.qrscan', ['qr_token' => $payment->qr_token])) !!}
                            <p>Thank you, please come again</p>
                        </div>
                    </td>
                </tr>
            </table>
        @endif
        <h6 style="text-align: right;margin-top: 10px"><i>Print 
            {{ now()->format('Y-m-d H:i:s') }}</i></h6>
    </div>
    <div class="print-button">
        <button onclick="window.print()">Print Struk</button>
    </div>
{{-- 
	<script type="text/javascript">
		window.print();
	</script> --}}
</body>

</html>