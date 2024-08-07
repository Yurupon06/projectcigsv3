@extends('landing.master')
@include('landing.header')


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
</style>

<br>
<div class="mb-50">
    <div class="row">
        <div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
            <div>
                <div class="navigation-links">
                    <a href="{{ route('landing.index') }}">Back</a>
                </div>
                <br>
                <table>
                    <tr class="table_head">
                        <th class="column-1">Profile</th>
                    </tr>
                    <tr class="table_row">
                        <td>
                            {{ $order->customer->user->name }} ( {{ $order->customer->phone }} )
                        </td>
                        <td class="cell-padding">
                            {{ $order->customer->user->email }}
                        </td>
                    </tr>
                </table>
            </div>
        </div>
        <br>
        <div class="col-lg-10 col-xl-7 m-lr-auto m-b-50">
            <div class="wrap-table-shopping-cart">
                <table class="table-shopping-cart">
                    <tr class="table_head">
                        <th class="column-1">Name</th>
                        <th class="column-1">Product Name</th>
                        <th class="column-1">Order Date</th>
                        <th class="column-1">Total</th>
                    </tr>
                    <tr class="table_row">
                        <td class="column-1">
                            {{ $order->customer->user->name }}
                        </td>
                        <td class="column-1">
                            {{ $order->product->product_name }}
                        </td>
                        <td class="column-1">
                            {{ \Carbon\Carbon::parse($order->order_date)->translatedFormat('d F Y H:i') }}
                        </td>
                        <td class="column-1">
                            Rp.{{ number_format($order->total_amount) }}
                        </td>
                    </tr>
                </table>
            </div>
            <br>
            <div class="flex-w flex-t p-t-27 p-b-33">
                <div class="size-208">
                    <span class="mtext-101 cl2">
                        Total:
                    </span>
                </div>
                <div class="size-209 p-t-1 flex-w flex-sb">
                    <span class="mtext-110 cl2">
                        Rp.{{ number_format($order->total_amount) }}
                    </span>
                    <span class="mtext-110 cl2" style="color: rgb(211, 32, 32); font-weight: bold;">
                        {{ ucfirst($order->status) }}
                    </span>
                    <button type="button" class="flex-c-m stext-101 cl0 size-11 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer" data-bs-toggle="modal" data-bs-target="#qrModal">
                        Qr Code
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="qrModal" tabindex="-1" aria-labelledby="qrModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="qrModalLabel">Go To Cashier To Pay</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                {!! QrCode::size(200)->generate(route('order.qrscan', ['qr_token' => $order->qr_token])) !!}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
