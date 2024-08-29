<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $order = order::with('customer', 'product')->get();
        return view('order.index', compact('order'));
    }

    public function show()
    {
        $order = order::with('customer', 'product')->get();
        return view('order.show', compact('order'));
    }

    public function qrscan($qr_token)
    {
        $order = Order::where('qr_token', $qr_token)->first();

        if (!$order) {
            return redirect()->route('order.index')->with('error', 'Order not found');
        }

        return view('order.show', compact('order'));
    }
}
