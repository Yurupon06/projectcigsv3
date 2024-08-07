<!DOCTYPE html>
<html>
<head>
    <title>Struk Gym</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .receipt {
            width: 300px;
            border: 1px solid #000;
            padding: 10px;
            margin: 0 auto;
        }
        .receipt-header {
            text-align: center;
        }
        .receipt-details, .receipt-footer {
            margin-top: 10px;
        }
        .receipt-footer {
            text-align: center;
        }
        .print-button {
            display: block;
            width: 100%;
            text-align: center;
            margin-top: 20px;
        }
        .qr-code {
            text-align: center;
            margin-top: 20px;
        }
        @media print {
            @page {
                size: 58mm auto; /* Ukuran kertas 58mm */
                margin: 0; /* Hapus margin */
            }
            .receipt {
                width: 58mm; /* Atur lebar struk */
                border: none; /* Hapus border jika diperlukan */
                padding: 0; /* Hapus padding jika diperlukan */
                margin: 0; /* Hapus margin jika diperlukan */
            }
            .print-button {
                display: none; /* Sembunyikan tombol print saat mencetak */
            }
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
            ["description" => "Monthly Membership", "price" => 500000],
            ["description" => "Drink", "price" => 10000]
        ],
        "total" => 510000,
        "cash" => 600000,
        "change" => 90000
    ];
    ?>

    <div class="receipt">
        <div class="receipt-header">
            <h2>Faybal GYM</h2>
            <p>Payment</p>
        </div>
        <div class="receipt-details">
            <p>User Name: <?= $receipt['member_name']; ?></p>
            <p>Date: <?= $receipt['date']; ?></p>
            <table width="100%">
                <thead>
                    <tr>
                        <th>Description</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($receipt['items'] as $item): ?>
                    <tr>
                        <td><?= $item['description']; ?></td>
                        <td><?= number_format($item['price'], 0, ',', '.'); ?> IDR</td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <div class="receipt-footer">
            <p>Total: <?= number_format($receipt['total'], 0, ',', '.'); ?> IDR</p>
            <p>Cash: <?= number_format($receipt['cash'], 0, ',', '.'); ?> IDR</p>
            <p>Change: <?= number_format($receipt['change'], 0, ',', '.'); ?> IDR</p>
        </div>
        <div class="qr-code">
            <img src="/assets/images/dummy_qr.jpg" alt="QR Code">
            <p>Scan and let us hear your feedback</p>
        </div>
    </div>

    <div class="print-button">
        <button onclick="window.print()">Print Struk</button>
    </div>

</body>
</html>
