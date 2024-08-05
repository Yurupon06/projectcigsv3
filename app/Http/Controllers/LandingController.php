<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Order;
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
        return view('landing.index', compact('products'));
    }

    public function profile(){
        $user = Auth::user();
        $customer = Customer::where('user_id', $user->id)->first();
        return view('landing.profile', compact('user', 'customer'));
    }

    public function profileUpdate(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:20',
            'born' => 'required|date',
            'gender' => 'required|in:men,women',
        ]);

        $user = Auth::user();
        $customer = Customer::updateOrCreate(
            ['user_id' => $user->id],
            [
                'phone' => $request->phone,
                'born' => $request->born,
                'gender' => $request->gender,
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
