<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 5);
        $payment = Payment::with(['order.customer.user', 'order.product'])
        ->where(function($query) use ($search) {
            $query->whereHas('order.customer.user', function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            })
            ->orWhereHas('order.product', function($q) use ($search) {
                $q->where('product_name', 'like', '%' . $search . '%');
            })
            ->orWhereHas('order', function($q) use ($search) {
                $q->where('id', 'like', '%' . $search . '%')
                  ->orWhere('status', 'like', '%' . $search . '%');
            })
            ->orWhere('amount', 'like', '%' . $search . '%')
            ->orWhere('amount_given', 'like', '%' . $search . '%')
            ->orWhere('change', 'like', '%' . $search . '%')
            ->orWhere('payment_date', 'like', '%' . $search . '%');
        })
        ->orderBy('created_at', 'desc')
        ->paginate($perPage);
        
        return view('payment.index', compact('payment'));
    }
}
