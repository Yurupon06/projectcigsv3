<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LandingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $products = Product::with('productcat')->get();
        return view('landing.index', compact('products'));
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
        // Fetch orders for the authenticated user
        $orders = Order::where('customer_id', Auth::id())->get();

        // Pass orders to the view
        return view('landing.order', compact('orders'));
    }

    public function orderStore(Request $request)
    {
        // Validate the request data
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        // Create a new order
        Order::create([
            'customer_id' => Auth::id(),
            'product_id' => $request->product_id,
            'order_date' => now(),
            'total_amount' => $request->total_amount,
            'status' => 'unpaid',
        ]);

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Order created successfully.');
        
    }
}
