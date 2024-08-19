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
        if ($request->input('action') === 'cancel') {
            $order->update(['status' => 'canceled']);
            return redirect()->route('cashier.index')->with('success', 'Order canceled successfully.');
        }
    
        // Validation and payment processing only for the "Process Payment" action
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


        return redirect()->route('struk_gym', ['id' => $order->id])->with('success', 'Payment processed successfully!');
    }

    public function showStruk($id)
    {
        $order = Order::with('customer', 'product')->findOrFail($id);
        $payment = Payment::where('order_id', $id)->first();
        $product = $order->product;
        $productcat = $product->productcat;
        $visit = $productcat->visit;

        $appSetting = ApplicationSetting::first();

        return view('cashier.struk_gym', compact('order', 'payment', 'appSetting', 'visit'));
    }


    public function membercashier()
    {
        $member = Order::with('customer', 'product')->get();
        return view('membercash.membercashier', compact('member'));
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
            'product_id' => 'required|exists:products,id',
            'price' => 'required|numeric',
        ]);
    
        $qrToken = Str::random(10);
    
        $customer = Customer::where('user_id', Auth::user()->id)->first();
    
        if (!$customer) {
            $customer = Customer::create([
                'user_id' => Auth::user()->id,
                'name' => Auth::user()->name,
            ]);
        }
    
        $order = Order::create([
            'customer_id' => Auth::user()->id,
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
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . Auth::id(),
            'phone' => 'required|string|max:20',
            'born' => 'required|date',
            'gender' => 'required|in:men,women',
        ]);

        $user = Auth::user();
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $customer = Customer::updateOrCreate(
            ['user_id' => $user->id],
            [
                'phone' => $request->phone,
                'born' => $request->born,
                'gender' => $request->gender,
            ]
        );

        return redirect()->route('cashier.profill')->with('success', 'Profile updated successfully.');
    }

        public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:3|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->route('cashier.profill')->with('warning', 'Current password does not match.');
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('cashier.profill')->with('success', 'Password updated successfully.');
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
