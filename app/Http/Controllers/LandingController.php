<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Member;
use App\Models\Membercheckin;
use App\Models\Order;
use App\Models\complement;
use App\Models\cart;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class LandingController extends Controller
{
    public function getUniqueCartItemCount()
    {
        $user = Auth::user();
        return $user ? cart::where('user_id', $user->id)->distinct('complement_id')->count('complement_id') : 0;
    }

    public function profile2()
    {
        $user = Auth::user();
        if ($user && $user->role === 'customer') {
            $customer = Customer::where('user_id', $user->id)->first();
            $member = $customer ? Member::where('customer_id', $customer->id)->first() : null;
            $cartCount = $this->getUniqueCartItemCount();
            return view('landing.profile.index', compact('user', 'customer', 'member', 'cartCount'));
        }
    }

    public function index()
    {
        $currentDate = Carbon::now('Asia/Jakarta');
        Member::where('end_date', '<', $currentDate)
        ->where('status', '<>', 'inactive')
        ->update(['status' => 'expired']);

        Member::where('visit', 0)
            ->where('status', '<>', 'inactive')
            ->update(['status' => 'expired']);

        $products = Product::with('productcat')->get();
        $user = Auth::user();
        $customer = $user ? Customer::where('user_id', $user->id)->first() : null;
        $member = $customer ? Member::where('customer_id', $customer->id)->first() : null;
        $cartCount = $this->getUniqueCartItemCount();
        return view('landing.index', compact('products', 'user', 'customer', 'member', 'cartCount'));
    }

    public function profile()
    {
        $user = Auth::user();
        if ($user && $user->role === 'customer') {
            $customer = Customer::where('user_id', $user->id)->first();
            $member = $customer ? Member::where('customer_id', $customer->id)->first() : null;
            $cartCount = $this->getUniqueCartItemCount();
            return view('landing.profile', compact('user', 'customer', 'member', 'cartCount'));
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
        
        $cartCount = $this->getUniqueCartItemCount();
        $search = $request->input('search');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        if ($user && $user->role === 'customer') {
            $customer = Customer::where('user_id', $user->id)->first();
            $member = $customer ? Member::where('customer_id', $customer->id)->first() : null;

            if ($member && $member->status == 'inactive') {
                return redirect()->route('landing.index')
                                 ->with('warning', 'You got banned. Please contact support.');
            }

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

            $orders = $ordersQuery->paginate(5);

            return view('landing.order', compact('orders', 'customer', 'member', 'search', 'startDate', 'endDate', 'cartCount'));
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
        $cartCount = $this->getUniqueCartItemCount();
        if (auth()->id() !== $order->customer->user_id) {
            abort(404); 
        }

        return view('landing.checkout', compact('order', 'member', 'cartCount'));
    }

    public function beforeOrder(Request $request)
    {
        $product = $request->only(['product_id', 'product_name', 'description', 'price']);
        $user = Auth::user();
        $customer = Customer::where('user_id', $user->id)->first();
        $member = $customer ? Member::where('customer_id', $customer->id)->first() : null;
        $cartCount = $this->getUniqueCartItemCount();

        if ($member && $member->status == 'inactive') {
            return redirect()->route('landing.index')
                             ->with('warning', 'You got banned. Please contact support.');
        }

        if (!$customer || !$customer->phone || !$customer->born || !$customer->gender) {
            return redirect()->route('landing.profile')->with('warning', 'Please complete your profile before Join The Gym.');
        }

        return view('landing.beforeOrder', compact('product', 'user', 'customer', 'member', 'cartCount'));
    }

    public function membership($id)
    {
        $currentDate = Carbon::now('Asia/Jakarta');

        Member::where('end_date', '<', $currentDate)
            ->where('status', '<>', 'inactive')
            ->update(['status' => 'expired']);

        Member::where('visit', 0)
            ->where('status', '<>', 'inactive')
            ->update(['status' => 'expired']);

            $user = Auth::user();

    if ($user && $user->role === 'customer') {
        $customer = Customer::where('user_id', $user->id)->first();

        if (!$customer) {
            abort(403);
        }

        $member = Member::with('customer.user')->findOrFail($id);
        $cartCount = $this->getUniqueCartItemCount();

        if ($member->customer_id !== $customer->id) {
            abort(403);
        }
        return view('landing.membership', compact('member', 'cartCount'));
    }
    abort(403);

    }

    public function history()
    {
        $user = Auth::user();
        $customer = Customer::where('user_id', $user->id)->first();
        $member = $customer ? Member::where('customer_id', $customer->id)->first() : null;
        $cartCount = $this->getUniqueCartItemCount();
        
        if ($member) {
            $memberckin = MemberCheckin::where('member_id', $member->id)->with('member.customer')->orderBy('created_at', 'desc')->paginate(5);
        } else {
            $memberckin = collect();
        }
    
        return view('landing.history', compact('memberckin', 'member', 'cartCount'));
    }

    public function complement(Request $request)
    {
        $category = $request->get('category');
    
        $complement = $category ? Complement::where('category', $category)->get() : Complement::all();
        

        $user = Auth::user();
        $customer = $user ? Customer::where('user_id', $user->id)->first() : null;
        $member = $customer ? Member::where('customer_id', $customer->id)->first() : null;
        $cartCount = $this->getUniqueCartItemCount();

        return view('landing.complement.index', compact('complement', 'user', 'customer', 'member', 'category','cartCount'));
    }
    public function complementDetail($id, request $request)
    {
        $complement = complement::findOrFail($id);
        $user = Auth::user();
        $customer = $user ? Customer::where('user_id', $user->id)->first() : null;
        $member = $customer ? Member::where('customer_id', $customer->id)->first() : null;
        $cartCount = $this->getUniqueCartItemCount();
        return view('landing.complement.detail', compact('complement', 'user', 'customer', 'member', 'cartCount'));
    }

    public function addToCart(Request $request, $complementId)
    {
        $user = Auth::user();
        
        $complement = complement::findOrFail($complementId);
    
        $quantity = $request->input('quantity', 1);
    
        $cartItem = cart::where('user_id', $user->id)
                        ->where('complement_id', $complement->id)
                        ->first();
    
        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $quantity;
            $cartItem->update([
                'quantity' => $newQuantity,
                'total' => $newQuantity * $complement->price
            ]);
        } else {
            cart::create([
                'user_id' => $user->id,
                'complement_id' => $complement->id,
                'quantity' => $quantity,
                'total' => $quantity * $complement->price
            ]);
        }
    
        return redirect()->route('cart.index')->with('success', 'Item added to cart successfully!');
    }


    public function cart ()
    {
        $user = Auth::user();
    
        // Ambil customer dan member seperti sebelumnya
        $customer = $user ? Customer::where('user_id', $user->id)->first() : null;
        $member = $customer ? Member::where('customer_id', $customer->id)->first() : null;
        
        // Ambil data cart berdasarkan user yang sedang login
        $cartItems = cart::where('user_id', $user->id)->with('complement')->get();
        $cartCount = $this->getUniqueCartItemCount();

    
        return view('landing.cart.index', compact('user', 'customer', 'member', 'cartItems', 'cartCount'));
    }


    public function deleteCart($id)
    {
        $cartItem = cart::findOrFail($id);

        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Item removed from cart successfully!');
    }

    public function home()
    {
        return view('landing.home.index');
    }
}
