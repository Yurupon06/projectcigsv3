<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\cart;
use App\Models\Order;
use App\Models\Member;
use App\Models\User;
use App\Models\Payment;
use App\Models\Product;
use App\Models\Customer;
use App\Models\complement;
use App\Models\ApplicationSetting;
use Illuminate\Support\Str;
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

class MidtransController extends Controller
{

    public function callback(Request $request)
    {
        $serverKey = config('midtrans.serverKey');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);
    
        // Validasi Signature Key
        if ($hashed !== $request->signature_key) {
            return response()->json(['error' => 'Invalid signature key'], 403);
        }
    
        // Cek status transaksi berhasil
        if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
            $orderType = $request->custom_field1; // Membaca custom field untuk tipe order
    
            // Kondisi berdasarkan `order_type`
            if ($orderType == 'order') {
                return $this->callbackOrder($request);
            } elseif ($orderType == 'order_complement') {
                return $this->callbackComplement($request);
            } else {
                return response()->json(['error' => 'Invalid order type'], 400);
            }
        }
    
        return response()->json(['message' => 'Transaction not captured or settled'], 200);
    }

    public function callbackOrder(Request $request)
    {
        $order = Order::find($request->order_id);
        $amountGiven = $request->gross_amount;
        $paymentQrToken = Str::random(10);
        $memberQrToken = Str::random(10);
        $change = $amountGiven - $order->total_amount;

        Payment::create([
            'order_id' => $order->id,
            'payment_date' => Carbon::now('Asia/Jakarta'),
            'amount' => $order->total_amount,
            'amount_given' => $order->total_amount,
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
    }


    public function callbackComplement(Request $request)
    {
        $orderComplement = OrderComplement::findOrFail($request->order_id);

        $amountGiven = $request->gross_amount;

        $paymentQrToken = Str::random(10);
        $change = $amountGiven - $orderComplement->total_amount;

        Payment::create([
            'order_complement_id' => $orderComplement->id,
            'payment_date' => Carbon::now('Asia/Jakarta'),
            'amount' => $orderComplement->total_amount,
            'amount_given' => $orderComplement->total_amount,
            'change' => $change,
            'qr_token' => $paymentQrToken,
        ]);

        $orderComplement->update(['status' => 'paid']);

    }
}
