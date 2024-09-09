<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page') ?? 5;

        $order = Order::with('customer', 'product')->when($search, function ($query) use ($search) {
            $query->whereHas('customer.user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })
            ->orWhereHas('product', function ($q) use ($search) {
                $q->where('product_name', 'like', "%{$search}%");
            })
            ->orWhere('order_date', 'like', "%{$search}%")
            ->orWhere('total_amount', 'like', "%{$search}%")
            ->orWhere('status', 'like', "%{$search}%");
        })
        ->orderBy('order_date', 'desc')
        ->paginate($perPage)
        ->appends(['search' => $search]);

        return view('order.index', compact('order'));
    }

    public function show()
    {
        $order = order::with('customer', 'product')->orderBy('order_date', 'desc')->get();
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
