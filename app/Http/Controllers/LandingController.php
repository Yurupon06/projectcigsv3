<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\cart;
use App\Models\Order;
use App\Models\Member;
use App\Models\User;
use App\Models\Product;
use App\Models\Customer;
use App\Models\complement;
use App\Models\ApplicationSetting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\MemberCheckin;
use App\Models\OrderComplement;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class LandingController extends Controller
{
    public function getUniqueCartItemCount()
    {
        $user = Auth::user();
        return $user ? cart::where('user_id', $user->id)->distinct('complement_id')->count('complement_id') : 0;
    }

    public function editProfile()
    {
        $user = Auth::user();
        if ($user && $user->role === 'customer') {
            $customer = Customer::where('user_id', $user->id)->first();
            $member = $customer ? Member::where('customer_id', $customer->id)->first() : null;
            $cartCount = $this->getUniqueCartItemCount();
            return view('landing.profile.editProfile', compact('user', 'customer', 'member', 'cartCount'));
        }
    }

    public function changePass()
    {
        $user = Auth::user();
        if ($user && $user->role === 'customer') {
            $customer = Customer::where('user_id', $user->id)->first();
            $member = $customer ? Member::where('customer_id', $customer->id)->first() : null;
            $cartCount = $this->getUniqueCartItemCount();
            return view('landing.profile.changepass', compact('user', 'customer', 'member', 'cartCount'));
        }
    }

    public function changePhoneCustomer()
    {
        $user = Auth::user();
        if ($user && $user->role === 'customer') {
            $customer = Customer::where('user_id', $user->id)->first();
            $member = $customer ? Member::where('customer_id', $customer->id)->first() : null;
            $cartCount = $this->getUniqueCartItemCount();
            return view('landing.change-phone', compact('user', 'customer', 'member', 'cartCount'));
        }
    }

    public function showValidateOtpCustomer()
    {
        $user = Auth::user();
        if ($user && $user->role === 'customer') {
            $customer = Customer::where('user_id', $user->id)->first();
            $member = $customer ? Member::where('customer_id', $customer->id)->first() : null;
            $cartCount = $this->getUniqueCartItemCount();
            return view('landing.validate-otp', compact('user', 'customer', 'member', 'cartCount'));
        }
    }

    public function getIn()
    {
        $user = Auth::user();
        if ($user && $user->role === 'customer') {
            $app = ApplicationSetting::first();
            $customer = Customer::where('user_id', $user->id)->first();
            $member = $customer ? Member::where('customer_id', $customer->id)->first() : null;
            $cartCount = $this->getUniqueCartItemCount();
            $qrToken = $member->qr_token;
            $fileName = 'qrcodes/qrcode_' . $qrToken . '.png';
            $filePath = storage_path('app/public/' . $fileName);

            if (Storage::disk('public')->exists($fileName)) {
                return view('landing.getin', compact('user', 'customer', 'member', 'cartCount'));
            }

            $qrcode = QrCode::format('png')->size(250)->margin(1)->generate($qrToken);
            Storage::disk('public')->put($fileName, $qrcode);
            $setting = ApplicationSetting::first();
            $message = "Here is your QR code.\nScan it to cashier and get in!";
            $api = Http::baseUrl($setting->japati_url)
            ->withToken($setting->japati_token)
            ->attach('media_file', fopen($filePath, 'r'), basename($filePath))
            ->post('/api/send-message', [
                'gateway' => $setting->japati_gateway,
                'number' => $user->phone,
                'type' => 'media',
                'message' => $message,
            ]);

            return view('landing.getin', compact('user', 'customer', 'member', 'cartCount'));
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
            'phone' => 'required|string|max:20',
            'born' => 'required|date|before:today',
            'gender' => 'required|in:men,women',
        ]);

        $user = Auth::user();

        if ($user && $user->role === 'customer') {
            $user->update([
                'name' => $request->name,
                'phone' => $request->phone,
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
            return redirect()->route('landing.change')->with('warning', 'Current password does not match.');
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        $setting = ApplicationSetting::first();
        $message = "Hello, *" . $user->name . "*.\nYour password has been changed successfully. If you didn't make this change, please contact us immediately.";
        $api = Http::baseUrl($setting->japati_url)
        ->withToken($setting->japati_token)
        ->post('/api/send-message', [
            'gateway' => $setting->japati_gateway,
            'number' => $user->phone,
            'type' => 'text',
            'message' => $message,
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
        $type = $request->input('type', 'membership');

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
            $orderComplementsQuery = OrderComplement::where('user_id', $user->id)
                ->orderBy('created_at', 'desc');

            if ($search) {
                $ordersQuery->whereHas('product', function ($query) use ($search) {
                    $query->where('product_name', 'like', "%{$search}%");
                });

                $orderComplementsQuery->where(function ($query) use ($search) {
                    $query->where('total_amount', 'like', "%{$search}%")
                        ->orWhere('status', 'like', "%{$search}%");
                });
            }

            if ($startDate && $endDate) {
                $ordersQuery->whereDate('order_date', '>=', $startDate)
                    ->whereDate('order_date', '<=', $endDate);
                $orderComplementsQuery->whereDate('created_at', '>=', $startDate)
                    ->whereDate('created_at', '<=', $endDate);
            } elseif ($startDate) {
                $ordersQuery->whereDate('order_date', '>=', $startDate);
                $orderComplementsQuery->whereDate('created_at', '>=', $startDate);
            } elseif ($endDate) {
                $ordersQuery->whereDate('order_date', '<=', $endDate);
                $orderComplementsQuery->whereDate('created_at', '<=', $endDate);
            }

            if (!$request->has('type')) {
                return redirect()->route('yourorder.index', [
                    'type' => $type,
                    'search' => $search,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                ]);
            }

            $orders = $ordersQuery->paginate(5);
            $orderComplements = $orderComplementsQuery->paginate(5);

            return view('landing.order', compact('orders', 'orderComplements', 'customer', 'member', 'type', 'search', 'startDate', 'endDate', 'cartCount',));
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

        $fileName = 'qrcodes/qrcode_' . $qrToken . '.png';
        $filePath = storage_path('app/public/' . $fileName);
        $qrcode = QrCode::format('png')->size(250)->margin(1)->generate('SCAN_' . $qrToken);
        Storage::disk('public')->put($fileName, $qrcode);
        $setting = ApplicationSetting::first();
        $message = "*Orders Details*:\n\nProduct Name: *" . $order->product->product_name . "*\nOrder Date: *" . $order->order_date . "*\nTotal Amount: *Rp. " . number_format($order->total_amount, 0, ',', '.') . "*\n\nThank you for order!\nScan the QR code to cashier to pay the order.";
        $api = Http::baseUrl($setting->japati_url)
        ->withToken($setting->japati_token)
        ->attach('media_file', fopen($filePath, 'r'), basename($filePath))
        ->post('/api/send-message', [
            'gateway' => $setting->japati_gateway,
            'number' => $user->phone,
            'type' => 'media',
            'message' => $message,
        ]);

        if (Storage::disk('public')->exists($fileName)) {
            Storage::disk('public')->delete($fileName);
        }

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

    public function showCheckoutComplement($id, Request $request)
    {
        $orderComplement = OrderComplement::with('user')->find($id);
        $user = Auth::user();
        $customer = Customer::where('user_id', $user->id)->first();
        $member = $customer ? Member::where('customer_id', $customer->id)->first() : null;
        $complementItems = OrderDetail::with('complement')->where('order_complement_id', $id)->get();

        return view('landing.checkout-complement', compact('orderComplement', 'customer', 'member', 'complementItems'));
    }

    public function complementCancel($id)
    {
        $orderComplement = OrderComplement::findOrFail($id);
        $orderDetails = OrderDetail::where('order_complement_id', $orderComplement->id)->get();
    
        foreach ($orderDetails as $detail) {
            $complement = Complement::findOrFail($detail->complement_id);
    
            $complement->update([
                'stok' => $complement->stok + $detail->quantity,
            ]);
    
            $detail->delete();
        }
    
        $orderComplement->delete();
    
        return redirect()->route('yourorder.index', ['type' => 'complement'])->with('success', 'Successfully Cancelled The Complement, Restored Stock, and Deleted the Order.');
    }

    public function updateCart(Request $request) 
    {
        $cartItems = cart::where('user_id', auth()->id())->get(); 
    
        foreach ($cartItems as $cartItem) {
            $complement = complement::findOrFail($cartItem->complement_id);
    
            $inputQuantity = $request->input("action-{$cartItem->id}");
            $newQuantity = $cartItem->quantity; 
    
            if ($inputQuantity === "plus") {
                $newQuantity += 1;
    
                if ($complement->stok < 1) {
                    return redirect()->back()->withErrors(['error' => 'Stok tidak mencukupi!']);
                }

    
            } else if ($inputQuantity === "minus" && $newQuantity > 1) {
                $newQuantity -= 1;
    

            }
    
            $cartItem->quantity = $newQuantity;
            $cartItem->total = $newQuantity * $complement->price;
            $cartItem->save();
        }
    
        return redirect()->back(); // Kembali ke halaman sebelumnya setelah update
    }
    

    public function checkoutComplement(Request $request)
    {
        $userId = auth()->id();
        
        

        return DB::transaction(function () use ($userId, $request) {
            $cartItems = Cart::where('user_id', $userId)->with('complement')->get();

            if ($cartItems->isEmpty()) {
                return redirect()->back()->with('error', 'Your cart is empty.');
            }

            $totalAmount = 0;
            $totalQuantity = 0;
            $qrToken = Str::random(10);
            $orderDetails = [];

            $orderComplement = OrderComplement::create([
                'user_id' => $userId,
                'total_amount' => 0,
                'status' => 'unpaid',
                'quantity' => 0,
                'qr_token' => $qrToken,
            ]);

            foreach ($cartItems as $item) {
                $complement = $item->complement; // Ambil data complement

                // Cek apakah stok mencukupi
                if ($complement->stok < $item->quantity) {
                    return redirect()->back()->with('error', "Stok untuk {$complement->name} tidak mencukupi sisa {$complement->stok}.");
                }
    
                // Kurangi stok
                $complement->stok -= $item->quantity;
                $complement->save();
                $itemTotal = $item->quantity * $item->complement->price;
                $totalAmount += $itemTotal;
                $totalQuantity += $item->quantity;

                $orderDetails[] = [
                    'order_complement_id' => $orderComplement->id,
                    'complement_id' => $item->complement->id,
                    'quantity' => $item->quantity,
                    'sub_total' => $item->total,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];

                if ($complement->stok == 0) {
                    $app = ApplicationSetting::first();
                    $adminUsers = User::where('role', 'admin')->get(); 
                    if ($adminUsers->isNotEmpty()) {
                        foreach ($adminUsers as $admin) {
                            if ($admin->phone) { 
                                $phone = $admin->phone;
                                $message = "Halo *$admin->name* Stok untuk *$complement->name* sudah habis.";
                
                                $api = Http::baseUrl($app->japati_url)
                                    ->withToken($app->japati_token)
                                    ->post('/api/send-message', [
                                        'gateway' => $app->japati_gateway,
                                        'number' => $phone,
                                        'type' => 'text',
                                        'message' => $message,
                                    ]);
                            }
                        }
                    } else {
                        return redirect()->back()->with('error', 'No admin users found.');
                    }
                }
            }

            $orderComplement->update([
                'total_amount' => $totalAmount,
                'quantity' => $totalQuantity,
            ]);

            OrderDetail::insert($orderDetails);

            Cart::where('user_id', $userId)->delete();

            $items = '';
            foreach ($orderDetails as $detail) {
                $complement = Complement::find($detail['complement_id']);

                $items .= $complement->name . ' (' . $detail['quantity'] . ' x Rp' . number_format($complement->price, 0, '.', '.') . ') = *Rp' . number_format($detail['sub_total'], 0, '.', '.') . "*\n";
            }

            $fileName = 'qrcodes/qrcode_' . $qrToken . '.png';
            $filePath = storage_path('app/public/' . $fileName);
            $qrcode = QrCode::format('png')->size(250)->margin(1)->generate($qrToken, $filePath);

            $user = Auth::user();
            $setting = ApplicationSetting::first();
            $message = "*Orders Details*:\n\n*Product*:\n" . $items . "\n*Total*: *Rp. " . number_format($totalAmount, 0, '.', '.') . "*\n\nThank you for order!\nScan the QR code to cashier to pay the order.";
            $api = Http::baseUrl($setting->japati_url)
            ->withToken($setting->japati_token)
            ->attach('media_file', fopen($filePath, 'r'), basename($filePath))
            ->post('/api/send-message', [
                'gateway' => $setting->japati_gateway,
                'number' => $user->phone,
                'type' => 'media',
                'message' => $message,
            ]);

            if (Storage::disk('public')->exists($fileName)) {
                Storage::disk('public')->delete($fileName);
            }

            return redirect()->route('checkout.complement', ['id' => $orderComplement->id])->with('success', 'Order created successfully.');
        });
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

        return view('landing.complement.index', compact('complement', 'user', 'customer', 'member', 'category', 'cartCount'));
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

        $quantity = $request->input('quantity');

        $cartItem = cart::where('user_id', $user->id)
            ->where('complement_id', $complement->id)
            ->first();

        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $quantity;
            if ($complement->stok < $newQuantity) {
                return redirect()->route('cart.index')->with('error', 'Stok tidak mencukupi untuk menambahkan lebih banyak.');
            }
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


    public function cart()
    {
        $user = Auth::user();

        $customer = $user ? Customer::where('user_id', $user->id)->first() : null;
        $member = $customer ? Member::where('customer_id', $customer->id)->first() : null;

        $cartItems = cart::where('user_id', $user->id)->with('complement')->get();
        $cartCount = $this->getUniqueCartItemCount();


        return view('landing.cart.index', compact('user', 'customer', 'member', 'cartItems', 'cartCount'));
    }


    public function deleteCart($id)
    {
        $cartItem = cart::findOrFail($id);
        $complement = complement::findOrFail($cartItem->complement_id);
    


        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Item removed from cart successfully!');
    }

    public function home()
    {
        return view('landing.home.index');
    }
}
