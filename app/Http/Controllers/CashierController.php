<?php

namespace App\Http\Controllers;

use App\Models\Cashier;
use App\Models\Customer;
use App\Models\User;
use App\Models\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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

    public function profile(){
        $user = Auth::user();
        $customer = Customer::where('user_id', $user->id)->first();
        return view('cashier.profile', compact('user', 'customer'));
    }

    public function profileUpdate(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'born' => 'required|date',
            'gender' => 'required|in:men,women',
        ];

        // Validasi password hanya jika salah satu field password diisi
        if ($request->filled('password') || $request->filled('password_confirmation')) {
            $rules['current_password'] = 'required|string';
            $rules['password'] = 'required|string|confirmed';
            $rules['password_confirmation'] = 'required|string';
        }

        $validatedData = $request->validate($rules);

        $user = Auth::user();

        // Update user details
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];

        // Cek jika password baru diisi
        if ($request->filled('password')) {
            // Validasi password lama
            if (!Hash::check($validatedData['current_password'], $user->password)) {
                return back()->withErrors(['current_password' => 'The provided current password does not match our records.'])->withInput();
            }
            // Update password
            $user->password = Hash::make($validatedData['password']);
        }

        $user->save();

        // Update atau buat detail pelanggan
        Customer::updateOrCreate(
            ['user_id' => $user->id],
            [
                'phone' => $validatedData['phone'],
                'born' => $validatedData['born'],
                'gender' => $validatedData['gender'],
            ]
        );

        return redirect()->route('cashier.profill')->with('success', 'Profile updated successfully.');
    }
}
