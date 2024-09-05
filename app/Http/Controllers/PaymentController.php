<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $payment = Payment::with('order')->orderBy('created_at', 'desc')->get();
        return view('payment.index', compact('payment'));
    }
}
