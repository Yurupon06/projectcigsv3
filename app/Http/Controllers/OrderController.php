<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $order = order::with('customer', 'product')->get();
        return view('order.index', compact('order'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $order = order::with('customer', 'product')->get();
        return view('order.show', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
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
