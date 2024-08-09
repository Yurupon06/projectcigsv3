<?php

namespace App\Http\Controllers;

use App\Models\Cashier;
use App\Models\User;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CashierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $order = order::with('customer', 'product')->get();
        return view('cashier.index', compact('order'));
    }

    public function show()
    {
        $order = order::with('customer', 'product')->get();
        return view('cashier.show', compact('order'));
    }

    public function qrscan($qr_token)
    {
        $order = Order::where('qr_token', $qr_token)->first();
    
        if (!$order) {
            return redirect()->route('cashier.index')->with('error', 'Order not found');
        }
    
        return view('cashier.show', compact('order'));
    }

    public function payment()
    {
        $payment = Payment::with('order')->get();
        return view('cashier.payment', compact('payment'));
    }

    public function store(Request $request, Order $order)
    {
        $request->validate([
            'amount_given' => 'required|numeric|min:0',
        ]);
        $qrToken = Str::random(10);

        $amountGiven = $request->input('amount_given');
        $change = $amountGiven - $order->total_amount;

        Payment::create([
            'order_id' => $order->id,
            'payment_date' => Carbon::now('Asia/Jakarta'),
            'amount' => $order->total_amount,
            'amount_given' => $amountGiven,
            'change' => $change,
            'qr_token' => $qrToken,
        ]);

        $order->update(['status' => 'paid']);

        return redirect()->route('cashier.payment')->with('success', 'Payment processed successfully!');
    }

    public function order()
    {

        $customer = Customer::with('user')->get();
        $product = Product::all();
        return view('cashier.addorder', compact('customer', 'product'));
    }

}
