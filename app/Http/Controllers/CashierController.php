<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Customer;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\ApplicationSetting;
use App\Models\Payment;
use App\Models\Complement;
use App\Models\Cart;
use App\Models\OrderComplement;
use App\Models\OrderDetail;
use App\Models\Product_categorie;
use App\Models\MemberCheckin;
use BaconQrCode\Encoder\QrCode;
use DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CashierController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 5);
        $filterType = $request->input('filter', 'membership');
    
        // Initialize query builder for orders (not collection)
        $ordersQuery = null;
    
        // Check the filter type and retrieve corresponding orders
        if ($filterType === 'membership') {
            $ordersQuery = Order::with(['customer.user', 'product'])
                ->when($search, function ($query, $search) {
                    return $query->where(function ($q) use ($search) {
                        $q->whereHas('customer.user', function ($q) use ($search) {
                            $q->where('name', 'like', "%{$search}%");
                        })
                        ->orWhereHas('product', function ($q) use ($search) {
                            $q->where('product_name', 'like', "%{$search}%");
                        })
                        ->orWhere('order_date', 'like', "%{$search}%")
                        ->orWhere('total_amount', 'like', "%{$search}%")
                        ->orWhere('status', 'like', "%{$search}%");
                    });
                })
                ->where('status', 'unpaid') // Only unpaid memberships
                ->orderBy('order_date', 'desc');
        } elseif ($filterType === 'complement') {
            $ordersQuery = OrderComplement::where('status', 'unpaid')->with('user')
                ->when($search, function ($query, $search) {
                    return $query->where(function ($q) use ($search) {
                        $q->where('id', 'like', "%{$search}%")
                          ->orWhere('total_amount', 'like', "%{$search}%");

                    });
                })
                ->orderBy('created_at', 'desc');
        }

        if ($ordersQuery) {
            $orders = $ordersQuery->paginate($perPage)->appends([
                'search' => $search,
                'filter' => $filterType,
                'per_page' => $perPage
            ]);
        } else {
            $orders = new \Illuminate\Pagination\LengthAwarePaginator([], 0, $perPage);
        }
    
        return view('cashier.index', compact('orders'));
    }
    

    public function show($qr_token)
    {
        $order = order::with('customer', 'product')->findOrFail($qr_token)->get();
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

    public function payment(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 5);
        $filter = $request->input('filter');
    
        $payments = Payment::with(['order.customer.user', 'order.product'])
            ->where(function($query) use ($search, $filter) {
                if ($filter === 'membership') {
                    $query->whereNotNull('order_id'); 
                } elseif ($filter === 'complement') {
                    $query->whereNotNull('order_complement_id'); 
                }
                
                if ($search) {
                    $query->whereHas('order.customer.user', function($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('order.product', function($q) use ($search) {
                        $q->where('product_name', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('order', function($q) use ($search) {
                        $q->where('id', 'like', '%' . $search . '%')
                          ->orWhere('status', 'like', '%' . $search . '%');
                    })
                    ->orWhere('amount', 'like', '%' . $search . '%')
                    ->orWhere('amount_given', 'like', '%' . $search . '%')
                    ->orWhere('change', 'like', '%' . $search . '%')
                    ->orWhere('payment_date', 'like', '%' . $search . '%');
                }
            })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage);
    
        return view('cashier.payment', compact('payments'));
    }
    

    public function detailpayment($id)
    {
        $dpayment = Payment::with(['order.customer.user', 'order.product'])
        ->where('id', $id)
        ->firstOrFail();

    return view('cashier.detailpayment', compact('dpayment'));
    }


    public function store(Request $request, Order $order)
    {
        if ($request->input('action') === 'cancel') {
            $order->update(['status' => 'canceled']);
            return redirect()->route('cashier.index')->with('success', 'Order canceled successfully.');
        }

        $request->validate([
            'amount_given' => 'required|numeric|min:0',
        ]);

        $amountGiven = $request->input('amount_given');

        if ($amountGiven < $order->total_amount) {
            return redirect()->back()->with('error', 'The amount given is less than the total amount.');
        }

        $paymentQrToken = Str::random(10);
        $memberQrToken = Str::random(10);
        $change = $amountGiven - $order->total_amount;

        Payment::create([
            'order_id' => $order->id,
            'payment_date' => Carbon::now('Asia/Jakarta'),
            'amount' => $order->total_amount,
            'amount_given' => $amountGiven,
            'change' => $change,
            'qr_token' => $paymentQrToken,
        ]);

        $order->update(['status' => 'paid']);

        // Proses pembaruan atau pembuatan anggota
        $productCategory = $order->product->productcat;
        $cycle = (int) $productCategory->cycle;
        $visit = (int) $productCategory->visit;

        $startDate = Carbon::now('Asia/Jakarta');
        $endDate = $startDate->copy()->addDays($cycle);

        $existingMember = Member::where('customer_id', $order->customer_id)->first();

        if ($existingMember) {
            if ($existingMember->status === 'expired' || $existingMember->status === 'inactive') {
                $existingMember->update([
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'status' => 'active',
                    'qr_token' => $memberQrToken,
                    'visit' => $visit,
                ]);
            } elseif ($existingMember->status === 'active') {
                $newVisit = $existingMember->visit + $visit;
                $existingEndDate = Carbon::parse($existingMember->end_date);
                $newEndDate = $existingEndDate->copy()->addDays($cycle);
                $existingMember->update([
                    'end_date' => $newEndDate,
                    'visit' => $newVisit,
                ]);
            }
        } else {
            Member::create([
                'customer_id' => $order->customer_id,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => 'active',
                'qr_token' => $memberQrToken,
                'visit' => $visit,
                'product_category_id' => $order->product->product_category_id,
            ]);
        }

        return redirect()->route('struk_gym', ['id' => $order->id])->with('success', 'Payment processed and membership created successfully!');
    }


    public function showStruk($id)
    {
        $order = Order::with('customer', 'product')->findOrFail($id);
        $customer = $order->customer; 
        $phone = $customer->phone;

        // Ambil data pembayaran, member, dan produk terkait
        $payment = Payment::where('order_id', $id)->first();
        $member = Member::where('customer_id', $order->customer_id)->first();
        $product = $order->product;
        $productcat = $product->productcat;
        $visit = $productcat->visit;
        $user = Auth::user();
        $appSetting = ApplicationSetting::first();

        // Ambil detail customer, token QR, dan informasi aplikasi
        $customerName = $order->customer->user->name;
        $memberQrToken = $member ? $member->qr_token : null;
        $appName = $appSetting ? $appSetting->app_name : 'App Name';

        // Menyimpan QR Code di storage
        $fileName = 'qrcode_order/qrcode_' . $memberQrToken . '.png';
        $filePath = storage_path('app/public/' . $fileName);

        // Format detail pesanan
        $orderDate = Carbon::now('Asia/Jakarta')->format('Y-m-d H:i:s');
        $productName = $payment->order->product->product_name;
        $amount = $payment->amount;
        $qrToken = $memberQrToken;
        
        // Generate QR code dan simpan
        $qrcode = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')->size(250)->margin(1)->generate($qrToken);
        Storage::disk('public')->put($fileName, $qrcode);

        // Buat pesan yang akan dikirim melalui WhatsApp
        $message = "Dear *$customerName*, your order for *$productName* on *$orderDate* with an amount of *Rp $amount* has been processed. Please use this QR token for check-in: *$qrToken*. Thank you for using *$appName*!";

        // Mengirimkan pesan menggunakan API WhatsApp
        $api = Http::baseUrl($appSetting->japati_url)
            ->withToken($appSetting->japati_token)
            ->attach('media_file', fopen($filePath, 'r'), basename($filePath))
            ->post('/api/send-message', [
                'gateway' => $appSetting->japati_gateway, 
                'number' => $phone, 
                'type' => 'media',
                'message' => $message,
                // 'media_file' => Storage::url($fileName), 
                // 'media_file' => 'https://files.f-g.my.id/images/dummy/buku-2.jpg',
            ]);

        // Cek apakah pengiriman berhasilk
        if (!$api->successful()) {
            \Log::error('Failed to send message', ['response' => $api->body()]);
            throw new \Exception('Failed to send message');
        }

        // Kembalikan view setelah berhasil
        return view('cashier.struk_gym', compact('order', 'appSetting', 'visit','payment', 'member', 'product', 'productcat', 'visit', 'user', 'appSetting', 'customerName', 'memberQrToken', 'appName', 'orderDate', 'productName', 'amount', 'qrToken'));

    }
        
    public function membercashier(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 5);
    
        $members = Member::join('customers', 'members.customer_id', '=', 'customers.id')
            ->join('users', 'customers.user_id', '=', 'users.id')
            ->where(function ($query) use ($search) {
                $query->where('users.name', 'LIKE', "%{$search}%")
                      ->orWhere('members.start_date', 'LIKE', "%{$search}%")
                      ->orWhere('members.end_date', 'LIKE', "%{$search}%")
                      ->orWhere('members.visit', 'LIKE', "%{$search}%")
                      ->orWhere('members.status', 'LIKE', "%{$search}%");
            })
            ->orderByRaw(
                "CASE
                    WHEN members.status = 'active' THEN 1
                    WHEN members.status = 'expired' THEN 2
                    ELSE 4
                END,
                users.name ASC") 
            ->select('members.*') 
            ->paginate($perPage);
    
        $currentDate = Carbon::now('Asia/Jakarta');
        Member::where('end_date', '<', $currentDate)
            ->where('status', '<>', 'inactive')
            ->update(['status' => 'expired']);

        Member::where('visit', 0)
            ->where('status', '<>', 'inactive')
            ->update(['status' => 'expired']);
        
        $member = Member::with('customer')->get();
    
        return view('membercash.membercashier', compact('member', 'members'));
    }
    
    

    public function storeCustomer(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255|unique:users',
        'phone' => 'required|string|max:15',
    ]);


    // Membuat user baru
    $user = User::create([
        'name' => $request->name,
        'phone' => $request->phone,
        'role' => 'customer',
    ]);

    // Menyimpan customer ke tabel customer
    $customer = Customer::create([
        'user_id' => $user->id,
        'phone' => $request->phone,
    ]);

    $token = Str::random(60);
    DB::table('password_reset_tokens')->insert([
        'phone' => $request->phone,
        'token' => $token,
        'created_at' => now(),
    ]);

    // Logika untuk mengirim pesan WhatsApp
    $setting = ApplicationSetting::first();
    $appName = $setting ? $setting->app_name : 'App Name';
    $showForgotForm = ENV('APP_URL') . '/reset/'.$token.'?phone='.$request->phone;
    

    $message = "Hello, ". $user->name . "! Welcome to our application *$appName*. To set your password, please visit: ". $showForgotForm;

    // Mengirim pesan WhatsApp
    $api = Http::baseUrl($setting->japati_url)
        ->withToken($setting->japati_token)  
        ->post( '/api/send-message', [ 
            'gateway' => $setting->japati_gateway, 
            'number' => $request->phone,
            'type' => 'text',
            'message' => $message,
        ]);


    return redirect()->route('cashier.order')->with([
        'success' => 'Customer added successfully.',
        'new_customer_id' => $customer->id,
    ]);
}


    public function order()
    {
        $customer = Customer::whereHas('user', function ($query) {
            $query->where('role', 'customer'); 
        })
        ->whereDoesntHave('members', function ($query) {
            $query->where('status', 'inactive'); 
        })
        ->with('user')

        ->orderBy(User::select('name')->whereColumn('users.id', 'customers.user_id'))
        ->get();

        $product = Product::with('productcat')->get();
        return view('cashier.addorder', compact('customer', 'product', ));
    }

    public function makeOrder(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'price' => 'required|numeric',
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

    public function profile()
    {
        $user = Auth::user();
        $customer = Customer::where('user_id', $user->id)->first();
        return view('cashier.profile', compact('user', 'customer'));
    }

    public function profileUpdate(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'born' => 'required|date',
            'gender' => 'required|in:men,women',
        ]);

        $user = Auth::user();
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

        return redirect()->route('cashier.profile')->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:3|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->route('cashier.profile')->with('warning', 'Current password does not match.');
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

        return redirect()->route('cashier.profile')->with('success', 'Password updated successfully.');
    }

    public function struk($paymentId)
    {
        $payment = Payment::with('order')->findOrFail($paymentId);
        $payment->payment_date = Carbon::parse($payment->payment_date);
        $appSetting = ApplicationSetting::first();
        $user = Auth::user();

        return view('cashier.struk_gym', compact('payment', 'appSetting', 'user'));
    }

    public function detailMember($id)
    {
        $member = Member::with('customer')->findOrFail($id);
        return view('membercash.detail', compact('member'));
    }

    public function actionMember(Request $request, $id)
    {
        $member = Member::find($id);
        if ($request->input('action') === 'cancel') {
            $member->update(['status' => 'inactive']);
            return redirect()->route('membercashier.membercash')->with('success', 'Member Banned successfully.');
        }
        if ($request->input('action') === 'unban') {
            $currentDate = Carbon::now('Asia/Jakarta');
            if ($member->end_date < $currentDate) {
                $member->update(['status' => 'expired']);
            }else {
                $member->update(['status' => 'active']);
            }
            return redirect()->route('membercashier.membercash')->with('success', 'Member successfully Unban.');
        }

        return redirect()->route('cashier.order');
    }

    public function membercheckin(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 5);
        $membercheckins = MemberCheckin::with('member.customer.user')
            ->when($search, function ($query) use ($search) {
                $query->whereHas('member.customer.user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('member.customer', function ($q) use ($search) {
                    $q->where('phone', 'like', "%{$search}%");
                })
                ->orWhere('created_at', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate($perPage)
            ->appends(['search' => $search]);

        return view('cashier.membercheckin', compact('membercheckins'));
    }

    public function getMemberDetails($qr_token)
    {
        $member = Member::where('qr_token', $qr_token)
            ->with('customer.user')
            ->first();

        if (!$member) {
            $checkin = MemberCheckin::where('qr_token', $qr_token)->first();

            if ($checkin) {
                return response()->json(['error' => 'QR Code already used'], 403);
            }

            return response()->json(['error' => 'Invalid QR Code'], 403);
        }

        return response()->json([
            'name' => $member->customer->user->name,
            'phone' => $member->customer->phone,
            'expired_date' => Carbon::parse($member->end_date)->format('d/M/Y'),
        ]);
    }

    public function qrscanner()
    {
        return view('cashier.checkinscanner');
    }

    public function storeCheckin(Request $request)
    {
        // Validasi input
        $request->validate([
            'qr_token' => 'required|string',
            'image' => 'nullable|string', 
        ]);

        $qrToken = $request->input('qr_token');

        // Cek apakah QR code sudah pernah digunakan
        $existingCheckin = MemberCheckin::where('qr_token', $qrToken)->first();
        if ($existingCheckin) {
            return response()->json(['success' => false, 'message' => 'QR code has already been used.']);
        }

        // Ambil data member berdasarkan qr_token
        $member = Member::where('qr_token', $qrToken)->first();
        if (!$member) {
            return response()->json(['success' => false, 'message' => 'Member not found.']);
        }

        $member->decrement('visit');

        // Proses penyimpanan gambar jika ada
        $imagePath = null;
        if ($request->filled('image')) {
            $imageData = $request->input('image');
            $image = str_replace('data:image/png;base64,', '', $imageData);
            $image = str_replace(' ', '+', $image);
            $imageName = 'checkin_' . time() . '.png';
            $imagePath = 'checkins/' . $imageName;
            Storage::disk('public')->put($imagePath, base64_decode($image));
        }

        // Simpan data check-in ke database
        $checkin = MemberCheckin::create([
            'member_id' => $member->id,
            'qr_token' => $qrToken,
            'image' => $imagePath,
        ]);

        // Generate QR token baru
        $newQrToken = Str::random(10);
        $member->update(['qr_token' => $newQrToken]);

        $phone = $member->customer->phone;
        $setting = ApplicationSetting::first();
        $customerName = $member->customer->user->name;
        $checkInDate = $checkin->created_at->setTimezone('Asia/Jakarta')->format('Y-m-d H:i:s');

        // Cek keberadaan file gambar sebelum mengirim
        $fullImagePath = storage_path('app/public/' . $imagePath);
        if (!file_exists($fullImagePath)) {
            \Log::error('Image file not found: ' . $fullImagePath);
            return response()->json(['success' => false, 'message' => 'Image file not found.'], 500);
        }

        $phoneNumber = preg_replace('/[^0-9]/', '', $phone); 
        $phoneNumber = '+62' . substr($phoneNumber, 1);

        $message = "Hello *$customerName*, you have successfully checked in on *$checkInDate*. Here is your check-in image: $imagePath";
        $apiCustomer = Http::baseUrl($setting->japati_url)
            ->withToken($setting->japati_token)
            ->attach('media_file', fopen(storage_path('app/public/'.$imagePath), 'r'), basename($imagePath))
            ->post('/api/send-message', [
                'gateway' => $setting->japati_gateway,
                'number' => $phone,
                'type' => 'media',
                'message' => $message,
                // 'media_file' => Storage::url($checkin->image),
                // 'media_file' => 'https://files.f-g.my.id/images/dummy/buku-2.jpg',
            ]);

        // Ambil respons dari API customer
        $responseCustomer = $apiCustomer->json();
        $httpStatusCustomer = $apiCustomer->status();

        
        if ($httpStatusCustomer == 200 && isset($responseCustomer['success']) && $responseCustomer['success'] == true) {
            // Jika pengiriman ke customer berhasil, kirim pesan ke admin
            $admins = User::where('role', 'admin')->get();
        
            foreach ($admins as $admin) {
                $adminPhone = $admin->phone;
                $messageAdmin = "Hello Admin, customer $customerName has successfully checked in on $checkInDate. Image path: $imagePath.";
        
                // Kirim pesan ke admin
                $apiAdmin = Http::baseUrl($setting->japati_url)
                    ->withToken($setting->japati_token)
                    ->attach('media_file', fopen(storage_path('app/public/'.$imagePath), 'r'), basename($imagePath))
                    ->post('/api/send-message', [
                        'gateway' => $setting->japati_gateway,
                        'number' => $adminPhone,
                        'type' => 'media',
                        'message' => $messageAdmin,
                        // 'media_file' => Storage::url($checkin->image),
                        // 'media_file' => 'https://files.f-g.my.id/images/dummy/buku-2.jpg', 
                    ]);
        
                $responseAdmin = $apiAdmin->json();
                $httpStatusAdmin = $apiAdmin->status();
        
                // Log status pengiriman ke admin
                if ($httpStatusAdmin == 200 && isset($responseAdmin['success']) && $responseAdmin['success'] == true) {
                    \Log::info("Notification sent to admin (phone: $adminPhone) successfully.");
                } else {
                    \Log::error("Failed to send notification to admin (phone: $adminPhone). Status: " . $httpStatusAdmin);
                }
            }
        } else {
            // Jika pengiriman ke customer gagal, catat ke dalam log
            \Log::error('Failed to send check-in message to customer. Status: ' . $httpStatusCustomer);
        }
        

        return response()->json([
            'success' => true,
            'message' => 'Check-in recorded successfully',
            'new_qr_token' => $newQrToken,
        ]);
    }

        public function showCheckIn()
        {
            return view('cashier.checkinscanner');  
        }

    public function orderComplement(Request $request){
        $user = Auth::user();
        $category = $request->get('category');
        $complement = $category ? Complement::where('category', $category)->get() : Complement::all();
        $cartItems = cart::where('user_id', $user->id)->with('complement')->get();
        return view('cashier.ordercomplement', compact('complement', 'cartItems'));
    }


    public function addToCart(Request $request, $complementId)
    {
        $user = Auth::user();
        
        $complement = complement::findOrFail($complementId);
    
        $quantity = $request->input('quantity', 1);
    
        if ($complement->stok < $quantity) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi.');
        }
    
        $cartItem = cart::where('user_id', $user->id)
                        ->where('complement_id', $complement->id)
                        ->first();
    
        if ($cartItem) {
            $newQuantity = $cartItem->quantity + $quantity;
            if ($complement->stok < $newQuantity) {
                return redirect()->back()->with('error', 'Stok tidak mencukupi untuk menambahkan lebih banyak.');
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
    
        return redirect()->route('cashier.complement')->with('success', 'Item berhasil ditambahkan ke keranjang.');
    }
    
    public function deleteCart($id)
    {
        $cartItem = cart::findOrFail($id);
    
        $complement = complement::findOrFail($cartItem->complement_id);
    
        $cartItem->delete();
    
        return redirect()->route('cashier.complement')->with('success', 'Item berhasil dihapus dari keranjang');
    }
    
    

    public function updateQuantity(Request $request, $id)
    {
        $cartItem = Cart::findOrFail($id);
        $newQuantity = $request->input('quantity');
        $currentQuantity = $cartItem->quantity;
    
        $complement = complement::findOrFail($cartItem->complement_id);
    
        if ($newQuantity > $currentQuantity) {
            $difference = $newQuantity - $currentQuantity;
    
            if ($complement->stok < $difference) {
                return response()->json(['error' => 'Stok tidak mencukupi!'], 400);
            }
    

        }
    
        if ($newQuantity < $currentQuantity) {
            $difference = $currentQuantity - $newQuantity;
    

        }
    
        $cartItem->quantity = $newQuantity;
        $cartItem->total = $newQuantity * $complement->price; 
    
        $cartItem->save();
    
        return response()->json([
            'success' => 'Quantity updated successfully!',
            'total' => $cartItem->total,
            'complement_id' => $complement->id,
            'new_stock' => $complement->stok
        ]);
    }
    
    

    public function checkoutProccess() {
        $user = Auth::user();
        $app = ApplicationSetting::first();
        $cartItems = Cart::where('user_id', $user->id)->with('complement')->get();
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }
    
        $totalAmount = $cartItems->sum('total');
        $qrToken = Str::random(10);
        $orderComplement = OrderComplement::create([
            'user_id' => $user->id,
            'total_amount' => $totalAmount,
            'status' => 'unpaid', 
            'quantity' => $cartItems->count(),
            'qr_token' => $qrToken, 
        ]);
    
        foreach ($cartItems as $item) {
            $price = $item->complement->price;
            $subTotal = $price * $item->quantity;
            $complement = $item->complement;
    
            if ($complement->stok < $item->quantity) {
                return redirect()->back()->with('error', "Stok untuk {$complement->name} tidak mencukupi sisa {$complement->stok}.");
            }
    
            $complement->stok -= $item->quantity;
    
            if ($complement->stok == 0) {
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
    
            $complement->save(); 
    
            OrderDetail::create([
                'order_complement_id' => $orderComplement->id,
                'complement_id' => $item->complement->id,
                'quantity' => $item->quantity,
                'sub_total' => $subTotal, 
            ]);
        }
    
        Cart::where('user_id', $user->id)->delete();
    
        return redirect()->route('cashier.checkout', ['qr_token' => $orderComplement->qr_token]);
    }
    
    


    public function checkoutComplement($qr_token){
        $orderComplement = OrderComplement::where('qr_token', $qr_token)->first();
    
    $orderDetails = OrderDetail::where('order_complement_id', $orderComplement->id)->with('complement')->get();

    return view('cashier.checkoutcomplement', compact('orderComplement', 'orderDetails'));
    }




    public function paymentComplement(Request $request, $id)
    {
        $orderComplement = OrderComplement::findOrFail($id);
        $orderDetails = OrderDetail::where('order_complement_id', $orderComplement->id)->get();

        if ($request->input('action') === 'cancel') {
            foreach ($orderDetails as $detail) {
                $complement = Complement::findOrFail($detail->complement_id);
                $complement->update([
                    'stok' => $complement->stok + $detail->quantity,
                ]);
        
                $detail->delete();
            }
            $orderComplement->delete();
            return redirect()->route('cashier.complement')->with('success', 'Order canceled successfully.');
        }

        $request->validate([
            'amount_given' => 'required|numeric|min:0',
        ]);

        $amountGiven = $request->input('amount_given');

        if ($amountGiven < $orderComplement->total_amount) {
            return redirect()->back()->with('error', 'The amount given is less than the total amount.');
        }

        $paymentQrToken = Str::random(10);
        $change = $amountGiven - $orderComplement->total_amount;

        Payment::create([
            'order_complement_id' => $orderComplement->id,
            'payment_date' => Carbon::now('Asia/Jakarta'),
            'amount' => $orderComplement->total_amount,
            'amount_given' => $amountGiven,
            'change' => $change,
            'qr_token' => $paymentQrToken,
        ]);

        $orderComplement->update(['status' => 'paid']);

        $items = '';
        foreach ($orderDetails as $detail) {
            $complement = Complement::find($detail['complement_id']);

            $items .= $complement->name . ' (' . $detail['quantity'] . ' x Rp. ' . number_format($complement->price, 0, '.', '.') . ') = *Rp. ' . number_format($detail['sub_total'], 0, '.', '.') . "*\n";
        }

        $setting = ApplicationSetting::first();
        $message = "*Successfuly Paid!*\n\n*Product*:\n" . $items . "\n*Total Amount*: *Rp. " . number_format($orderComplement->total_amount, 0, ',', '.') . "*\n*Amount Given*: *Rp. " . number_format($amountGiven, 0, ',', '.') . "*\n*Change*: *Rp. " . number_format($change, 0, ',', '.') . "*\n\nThank you for order!";
        $api = Http::baseUrl($setting->japati_url)
        ->withToken($setting->japati_token)
        ->post('/api/send-message', [
            'gateway' => $setting->japati_gateway,
            'number' => $orderComplement->user->phone,
            'type' => 'text',
            'message' => $message,
        ]);

        return redirect()->route('struk_complement', ['id' => $orderComplement->id])->with('success', 'Payment processed and membership created successfully!');
    }


    public function strukComplement($id){
        $orderComplement = OrderComplement::with('user')->findOrFail($id);
        $payment = Payment::where('order_complement_id', $id)->first();
        $orderDetails = OrderDetail::where('order_complement_id', $orderComplement->id)->with('complement')->get();
        $payment->payment_date = Carbon::parse($payment->payment_date);
        $appSetting = ApplicationSetting::first();
        $user = Auth::user();

        return view('cashier.struk_complement', compact('payment', 'appSetting', 'user', 'orderDetails', 'orderComplement'));
    }
    
    

    
    

}
