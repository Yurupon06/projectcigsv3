<?php

namespace App\Http\Controllers;

use App\Models\Cashier;
use App\Models\Customer;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\ApplicationSetting;
use App\Models\Payment;
use App\Models\Product_categorie;
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
    public function membercashier()
    {
        $members = Order::with('customer', 'product')->get();
        return view('membercash.membercashier', compact('members'));
    }


    public function order()
    {

        $customer = Customer::whereHas('user', function ($role) {
            $role->where('role', 'customer');
        })->with('user')->get();
        $product = Product::all();
        return view('cashier.addorder', compact('customer', 'product'));
    }

    public function makeOrder(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'product_id' => 'required|exists:products,id',
        ]);

        $qrToken = Str::random(10);

        $order = Order::create([
            'customer_id' => $request->customer_id,
            'product_id' => $request->product_id,
            'order_date' => Carbon::now('Asia/Jakarta'),
            'total_amount' => $request->price,
            'status' => 'unpaid', 
            'qr_token' => $qrToken, 
        ]);

        return redirect()->route('cashier.qrscan', ['qr_token' => $order->qr_token]);
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

        $user = User::find(Auth::user()->id);


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


    public function struk($paymentId)
    {
        $payment = Payment::with('order')->findOrFail($paymentId);
        $payment->payment_date = Carbon::parse($payment->payment_date);
        $appSetting = ApplicationSetting::first();
    
        // Pass both payment and application setting data to the view
        return view('cashier.struk_gym', [
            'payment' => $payment,
            'appSetting' => $appSetting
        ]);
    }
}
