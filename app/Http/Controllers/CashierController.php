<?php

namespace App\Http\Controllers;

use App\Models\Cashier;
use App\Models\User;
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
            return redirect()->route('order.index')->with('error', 'Order not found');
        }
    
        return view('cashier.show', compact('order'));
    }

    public function store(Request $request, Order $order)
    {
        // Validate the request
        $request->validate([
            'amount_given' => 'required|numeric|min:0',
        ]);
        $qrToken = Str::random(10);

        // Calculate the change
        $amountGiven = $request->input('amount_given');
        $change = $amountGiven - $order->total_amount;

        // Create a new payment record
        Payment::create([
            'order_id' => $order->id,
            'payment_date' => Carbon::now('Asia/Jakarta'),
            'amount' => $order->total_amount,
            'amount_given' => $amountGiven,
            'change' => $change,
            'qr_token' => $qrToken,
        ]);

        // Update order status
        $order->update(['status' => 'paid']);

        // Redirect back with success message
        return redirect()->route('cashier.index')->with('success', 'Payment processed successfully!');
    }

}
