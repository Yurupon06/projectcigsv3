<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Member;
use App\Models\Membercheckin;
use App\Models\Order;
use App\Models\complement;
use Carbon\Carbon;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LandingController extends Controller
{
    public function index()
    {
        $products = Product::with('productcat')->get();
        $user = Auth::user();
        $customer = $user ? Customer::where('user_id', $user->id)->first() : null;
        $member = $customer ? Member::where('customer_id', $customer->id)->first() : null;
        return view('landing.index', compact('products', 'user', 'customer', 'member'));
    }

    public function profile()
    {
        $user = Auth::user();
        if ($user && $user->role === 'customer') {
            $customer = Customer::where('user_id', $user->id)->first();
            $member = $customer ? Member::where('customer_id', $customer->id)->first() : null;
            return view('landing.profile', compact('user', 'customer', 'member'));
        }

        abort(403);
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
        
        if ($user && $user->role === 'customer') {
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

        return redirect()->route('landing.profile')->with('success', 'Profile updated successfully.');
    }
    abort(403);
}


    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:3|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->route('landing.profile')->with('warning', 'Current password does not match.');
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('landing.profile')->with('success', 'Password updated successfully.');
    }

    public function order(Request $request)
    {
        $user = Auth::user();
        $search = $request->input('search');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        if ($user && $user->role === 'customer') {
            $customer = Customer::where('user_id', $user->id)->first();
            $member = $customer ? Member::where('customer_id', $customer->id)->first() : null;

            if (!$startDate && !$endDate) {
                $allOrders = Order::where('customer_id', $customer->id)->get();
            }

            $ordersQuery = Order::where('customer_id', $customer->id)
                                ->orderBy('created_at', 'desc');

            if ($search) {
                $ordersQuery->whereHas('product', function ($query) use ($search) {
                    $query->where('product_name', 'like', "%{$search}%");
                });
            }

            if ($startDate && $endDate) {
                $ordersQuery->whereDate('order_date', '>=', $startDate)
                            ->whereDate('order_date', '<=', $endDate);
            } elseif ($startDate) {
                $ordersQuery->whereDate('order_date', '>=', $startDate);
            } elseif ($endDate) {
                $ordersQuery->whereDate('order_date', '<=', $endDate);
            }

            $orders = $ordersQuery->get();

            return view('landing.order', compact('orders', 'customer', 'member', 'search', 'startDate', 'endDate'));
        }

        abort(403);
    }


    public function orderStore(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);
        $qrToken = Str::random(10);

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

    public function orderCancel($id)
    {
        $order = Order::findOrFail($id);
        $order->update(['status' => 'canceled']);
        return redirect()->route('yourorder.index')->with('success', 'Successfully Cancel The Order.');
    }

    public function checkout($id)
    {
        $order = Order::with('customer', 'product')->find($id);
        $user = Auth::user();
        $customer = Customer::where('user_id', $user->id)->first();
        $member = $customer ? Member::where('customer_id', $customer->id)->first() : null;
        if (auth()->id() !== $order->customer->user_id) {
            abort(404); 
        }

        return view('landing.checkout', compact('order', 'member'));
    }

    public function beforeOrder(Request $request)
    {
        $product = $request->only(['product_id', 'product_name', 'description', 'price']);
        $user = Auth::user();
        $customer = Customer::where('user_id', $user->id)->first();
        $member = $customer ? Member::where('customer_id', $customer->id)->first() : null;
        if (!$customer || !$customer->phone || !$customer->born || !$customer->gender) {
            return redirect()->route('landing.profile')->with('warning', 'Please complete your profile before Join The Gym.');
        }

        return view('landing.beforeOrder', compact('product', 'user', 'customer', 'member'));
    }

    public function membership($id)
    {
        $currentDate = Carbon::now('Asia/Jakarta');

        Member::where('end_date', '<', $currentDate)
            ->where('status', '<>', 'expired')
            ->update(['status' => 'expired']);

        Member::where('visit', 0)
            ->where('status', '<>', 'expired')
            ->update(['status' => 'expired']);

            $user = Auth::user();

    if ($user && $user->role === 'customer') {
        $customer = Customer::where('user_id', $user->id)->first();

        if (!$customer) {
            abort(403);
        }

        $member = Member::with('customer.user')->findOrFail($id);

        if ($member->customer_id !== $customer->id) {
            abort(403);
        }
        return view('landing.membership', compact('member'));
    }
    abort(403);

    }

    public function history()
    {
        $user = Auth::user();
        $customer = Customer::where('user_id', $user->id)->first();
        $member = $customer ? Member::where('customer_id', $customer->id)->first() : null;
        
        if ($member) {
            $memberckin = MemberCheckin::where('member_id', $member->id)->with('member.customer')->orderBy('created_at', 'desc')->get();
        } else {
            $memberckin = collect();
        }
    
        return view('landing.history', compact('memberckin', 'member'));
    }

    public function complement(Request $request)
    {
        $category = $request->get('category');
    
        // Check if a category is selected, otherwise show all complements
        $complement = $category ? Complement::where('category', $category)->get() : Complement::all();

        $user = Auth::user();
        $customer = $user ? Customer::where('user_id', $user->id)->first() : null;
        $member = $customer ? Member::where('customer_id', $customer->id)->first() : null;
        return view('landing.complement.index', compact('complement', 'user', 'customer', 'member', 'category'));
    }
    public function complementDetail($id)
    {
        $complement = complement::findOrFail($id);
        $user = Auth::user();
        $customer = $user ? Customer::where('user_id', $user->id)->first() : null;
        $member = $customer ? Member::where('customer_id', $customer->id)->first() : null;
        return view('landing.complement.detail', compact('complement', 'user', 'customer', 'member'));
    }
}
