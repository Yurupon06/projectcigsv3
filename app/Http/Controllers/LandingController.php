<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Order;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LandingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $products = Product::with('productcat')->get();
        $user = Auth::user();
        $customer = $user ? Customer::where('user_id', $user->id)->first() : null;
        return view('landing.index', compact('products', 'user', 'customer'));
    }

    public function profile(){
        $user = Auth::user();
        $customer = Customer::where('user_id', $user->id)->first();
        return view('landing.profile', compact('user', 'customer'));
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
        $rules['password'] = 'required|string|min:8|confirmed';
        $rules['password_confirmation'] = 'required|string|min:8';
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

    return redirect()->route('landing.profile')->with('success', 'Profile updated successfully.');
}


    public function order()
    {
        $user = Auth::user();
        $customer = Customer::where('user_id', $user->id)->first();
    
        $orders = $customer ? Order::where('customer_id', $customer->id)->get() : collect([]);
    
        return view('landing.order', compact('orders', 'customer'));
    }

    public function orderStore(Request $request)
    {
        // Validate the request data
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);
        $qrToken = Str::random(10);

        $user = Auth::user();
        $customer = Customer::where('user_id', $user->id)->first();


        $user = Auth::user();
        $customer = Customer::where('user_id', $user->id)->first();
        if (!$customer || !$customer->phone || !$customer->born || !$customer->gender) {
            return redirect()->route('landing.profile')->with('warning', 'Please complete your profile before Join The Gym.');
        }

        $order = Order::create([
            'customer_id' => $customer->id,
            'product_id' => $request->product_id,
            'order_date' => Carbon::now('Asia/Jakarta'),
            'total_amount' => $request->total_amount,
            'status' => 'unpaid',
            'qr_token' => $qrToken,

        ]);

        return redirect()->route('checkout', ['id' => $order->id])->with('success', 'Order created successfully.');
    }

    public function orderCancel($id){
        $order = Order::findOrFail($id);
        $order->update(['status' => 'canceled']);
        return redirect()->route('yourorder.index')->with('success', 'Successfully Cancel The Order.');
    }




    public function checkout($id){
        $order = Order::with('customer', 'product')->find($id);
        return view('landing.checkout', compact('order'));
    }


    public function beforeOrder(Request $request){
        $product = $request->only(['product_id', 'product_name', 'description', 'price']);
        $user = Auth::user();
        $customer = Customer::where('user_id', $user->id)->first();
        if (!$customer || !$customer->phone || !$customer->born || !$customer->gender) {
            return redirect()->route('landing.profile')->with('warning', 'Please complete your profile before Join The Gym.');
        }
    
        return view('landing.beforeOrder', compact('product', 'user', 'customer'));
    }
}
