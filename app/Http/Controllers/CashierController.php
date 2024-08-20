<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Customer;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\ApplicationSetting;
use App\Models\Payment;
use App\Models\Product_categorie;
use App\Models\MemberCheckin;
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
    
        $request->validate([
            'amount_given' => 'required|numeric|min:0',
        ]);
    
        $paymentQrToken = Str::random(10); 
        $memberQrToken = Str::random(10); 
        $amountGiven = $request->input('amount_given');
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
    
        $productCategory = $order->product->productcat;
        $cycle = (int) $productCategory->cycle; 
        $visit = (int) $productCategory->visit; 
    
        $startDate = Carbon::now('Asia/Jakarta');
        $endDate = $startDate->copy()->addDays($cycle);
    
        $existingMember = Member::where('customer_id', $order->customer_id)->first();
    
        if ($existingMember) {
            if ($existingMember->status === 'expired') {
                $existingMember->update([
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'status' => 'active',
                    'qr_token' => $memberQrToken,
                    'visit' => $visit, 
                ]);
            } elseif ($existingMember->status === 'inactive') {
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
        $payment = Payment::where('order_id', $id)->first();
        $product = $order->product;
        $productcat = $product->productcat;
        $visit = $productcat->visit;
        $user = Auth::user();
        $appSetting = ApplicationSetting::first();
    
        $member = Member::where('customer_id', $order->customer_id)->first();
        $memberQrToken = $member ? $member->qr_token : null;
    
        return view('cashier.struk_gym', compact('order', 'payment', 'appSetting', 'visit', 'user', 'memberQrToken'));
    }
    


    public function membercashier()
    {
    $currentDate = Carbon::now('Asia/Jakarta');

    Member::where('end_date', '<', $currentDate)
          ->where('status', '<>', 'expired') 
          ->update(['status' => 'expired']);
          
    Member::where('visit', 0)
          ->where('status', '<>', 'expired')
          ->update(['status' => 'expired']);


    $member = Member::with('customer')->get();

    return view('membercash.membercashier', compact('member'));
    }

public function storeCustomer(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'phone' => 'required|string|max:15',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'role' => 'customer', 
    ]);
    
    $customer = Customer::create([
        'user_id' => $user->id,
        'phone' => $user->phone,  
        'born' => $request->born,  
        'gender' => $request->gender, 
    ]);
    
    return redirect()->route('cashier.order')->with([
        'success' => 'Customer added successfully.',
        'new_customer_id' => $customer->id
    ]);
}



    public function order()
    {
        $customer = Customer::whereHas('user', function ($role) {
            $role->where('role', 'customer');
        })->with('user')->get();
    
        $product = Product::all();
    
        $usersWithoutCustomer = User::whereDoesntHave('customer')->where('role', 'customer')->get();
    
        return view('cashier.addorder', compact('customer', 'product', 'usersWithoutCustomer'));
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
            'order_date' => Carbon::now('Asia/Jakarta') ,
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
        $user = Auth::user();
    
        return view('cashier.struk_gym', compact('payment', 'appSetting', 'user'));
    }


    public function detailMember ($id)
    {
        $member = Member::with('customer')->findOrFail($id);
        return view('membercash.detail', compact('member'));
    }

    public function actionMember (Request $request, $id)
    {
        $member = Member::find($id);
        if ($request->input('action') === 'cancel') {
            $member->update(['status' => 'inactive']);
            return redirect()->route('membercashier.membercash')->with('success', 'Member canceled successfully.');
        }
        return redirect()->route('cashier.order');
    }

    public function showCheckIn()
    {
        return view('cashier.checkinscanner');  

   
    public function membercheckin()
    {
        $memberckin = MemberCheckin::with('member.customer')->get();
        return view('cashier.membercheckin', compact('memberckin'));

    }

    public function showCheckIn()
    {
        return view('cashier.checkinscanner');  

    }

    public function getMemberDetails($qr_token)
    {
        $member = Member::where('qr_token', $qr_token)
            ->with('customer.user')
            ->first();
    
        if (!$member) {
            return response()->json(['error' => 'Qr Code Already Used'], 404);
        }
    
        return response()->json([
            'name' => $member->customer->user->name,
            'phone' => $member->customer->phone,
            'expired_date' => Carbon::parse($member->end_date)->format('d/M/Y'),
        ]);
    }
    

    public function storeCheckin(Request $request)
    {
        $request->validate([
            'qr_token' => 'required|string',
            'image' => 'nullable|string',
        ]);
    
        $qrToken = $request->input('qr_token');
    
        $existingCheckin = MemberCheckin::where('qr_token', $qrToken)->first();
    
        if ($existingCheckin) {
            return response()->json(['success' => false, 'message' => 'QR code has already been used.']);
        }
    
        $member = Member::where('qr_token', $qrToken)->first();
    
        if (!$member) {
            return response()->json(['success' => false, 'message' => 'Member not found.']);
        }
    
        // Mengurangi visit dengan 1
        $member->decrement('visit');
    
        $checkin = MemberCheckin::create([
            'member_id' => $member->id,
            'qr_token' => $qrToken,
            'image' => $request->input('image'),
        ]);
    
        // Generate QR Token baru
        $newQrToken = Str::random(10);
        $member->update([
            'qr_token' => $newQrToken
        ]);
    
        return response()->json([
            'success' => true,
            'message' => 'Check-in recorded successfully',
            'new_qr_token' => $newQrToken
        ]);
    }
    
    

    
    
}
