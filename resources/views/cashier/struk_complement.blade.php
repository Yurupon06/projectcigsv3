<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($setting) ? $setting->app_name . ' - Struk' : 'Struk' }}</title>
    <link rel="icon" type="image/png"
        href="{{ isset($setting) ? asset('storage/' . $setting->app_logo) : asset('assets/images/logo_gym.png') }}">
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
    
            .line {
                border: none;
                border-top: 1px solid #000;
                margin: 7px 0;
            }
    
            .margin {
                margin-bottom: 10px;
                margin-top: 10px;
            }
    
            img {
                filter: grayscale(100%);
            }
            .complement-name {
                word-wrap: break-word;
                word-break: break-all;
                max-width: 80px; 
            }

        </style>
</head>
<body>
    <div class="container">
        <table class="table">
            <tr>
                <td colspan="2" class="align-center">
                    <img width='100'
                        src={{ isset($appSetting) ? asset('storage/' . $appSetting->app_logo) : asset('assets/images/2.png') }}>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="align-center">
                    <h1>{{ isset($appSetting) ? $appSetting->app_name : 'FAYBAL' }}</h1>
                </td>
            </tr>
            <tr>
                <td colspan="2" class="align-center">
                    {{ isset($appSetting->app_address) ? $appSetting->app_address : 'Jl. Pemuda No. 1' }}<br>
                </td>
            </tr>
        </table>
        <hr>
        <table class="table">
            <tr>
                <td>Cashier:</td>
                <td class="align-right">{{$user->name}}</td>
            </tr>
            <tr>
                <td>Order ID:</td>
                <td class="align-right">{{$payment->order_complement_id}}</td>
            </tr>
            <tr>
                <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('Y-m-d') }}</td>
                <td class="align-right">{{ \Carbon\Carbon::parse($payment->payment_date)->format('H:i:s') }}</td>
            </tr>
        </table>
        <hr>
        <table class="table">
            <tr>
                <th colspan="2">Item</th>
                <th class="align-center">Price</th>
                <th class="align-right">Total</th>
            </tr>
            @foreach ($orderDetails as $dt)
            <tr>
                <td>{{$dt->quantity}} x</td>
                <td class="complement-name">{{$dt->complement->name}}</td>
                <td class="align-right">{{number_format($dt->complement->price)}}</td>
                <td class="align-right">{{number_format($dt->sub_total)}}</td>
                
            </tr>
            @endforeach
        </table>
        <hr>
        <table class="table">
            <tr>
                <td><b>Total Item:</b></td>
                <td>{{$payment->ordercomplement->quantity}}</td>
                <td class="align-right">
                    <h1><b>{{number_format($orderDetails->sum('sub_total'))}}</b></h1>
                </td>
            </tr>
        </table>
        <hr>
        <table class="table">
            <tr>
                <td>Cash Rp</td>
                <td class="align-right">{{number_format($payment->amount_given, 0, ',', '.')}}</td>
            </tr>
            <tr>
                <td>Change Rp</td>
                <td class="align-right"><b>{{number_format($payment->change, 0, ',', '.')}}</b></td>
            </tr>
        </table>
        <h6 style="text-align: right;margin-top: 10px">
            <i>Print {{ now()->format('Y-m-d H:i:s') }}</i>
        </h6>
    </div>
    <div class="print-button">
        <button onclick="window.print()">Print Struk</button>
    </div>
    <div class="print-button">
        <a href="{{ route('cashier.index') }}">
            <button>Back</button>
        </a>
    </div>

        
	{{-- <script type="text/javascript">
		window.print();
	</script> --}}
</body>
</html>
