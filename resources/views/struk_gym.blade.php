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
		"items" => [
			["description" => "Monthly Membership", "price" => 1234567],
			["description" => "Drink", "price" => 10000]
		],
		"total" => 1244567,
		"cash" => 1250000,
		"change" => 5433
	];
	?>

	<div class="container">
		<table class="table">
			<tr>
				<td colspan="2" class="align-center">
					<img width='100' src='assets/images/2.png'>
				</td>
			</tr>
			<tr>
				<td colspan="2" class="align-center">
					<h1>Faybal GYM</h1>
				</td>
			</tr>
			<tr>
				<td colspan="2" class="align-center">
					Jl. CIGS No. P/3, Cimahi Sel, Kec. Baros, Cimahi Tengah<br>
					Telp: 0811972108 - Email: cigs@gmail.com
				</td>
			</tr>
		</table>
		<hr>
		<table class="table">
			<tr>
				<td><?= $receipt['date']; ?></td>
				<td class="align-right">12:00:00</td>
			</tr>
			<tr>
				<td>Order ID</td>
				<td class="align-right">GYM0001</td>
			</tr>
		</table>
		<hr>
		<table class="table">
			<?php foreach ($receipt['items'] as $item): ?>
				<tr>
					<td><?= $item['description']; ?></td>
					<td class="align-right"><?= number_format($item['price'], 0, ',', '.'); ?></td>
				</tr>
			<?php endforeach; ?>
		</table>
		<hr>
		<table class="table">
			<tr>
				<td><b>Total Rp</b></td>
				<td class="align-right">
					<h1><b><?= number_format($receipt['total'], 0, ',', '.'); ?></b></h1>
				</td>
			</tr>
		</table>
		<hr>
		<table class="table">
			<tr>
				<td>Cash Rp</td>
				<td class="align-right"><?= number_format($receipt['cash'], 0, ',', '.'); ?></td>
			</tr>
			<tr>
				<td>Change Rp</td>
				<td class="align-right"><b><?= number_format($receipt['change'], 0, ',', '.'); ?></b></td>
			</tr>
		</table>
		<hr>
		<table class="table">
			<tr>
				<td colspan="2">
					<div class="qr-code">
						<img width="200" src="assets/images/dummy_qr.jpg" alt="QR Code"><br>
						<p>Thank you, please come again</p>
					</div>
				</td>
			</tr>
		</table>
		<hr>
		<table class="table">
			<tr>
				<td>Member</td>
				<td class="align-right"><b>John Doe</b></td>
			</tr>
			<tr>
				<td>No Hp</td>
				<td class="align-right">08981234XXXX</td>
			</tr>
		</table>
		<h6 style="text-align: right;margin-top: 10px"><i>Print 
			<?php date_default_timezone_set("Asia/Jakarta");
			echo date("Y-m-d");
			echo " ";
			echo date("H:i:s"); ?></i></h6>
	</div>
	<div class="print-button">
		<button onclick="window.print()">Print Struk</button>
	</div>

	<script type="text/javascript">
		window.print();
	</script>
</body>

</html>