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
        $hashed = hash("sha512", $request->order_id.$request->status_code.$request->gross_amount.$serverKey);
        if($hashed == $request->signature_key){
            if($request->transaction_status == 'capture'){
                $order = Order::find($request->order_id);
                $amountGiven = $request->gross_amount;
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
        }
    }
}
