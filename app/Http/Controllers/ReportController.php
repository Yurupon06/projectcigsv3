<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\ApplicationSetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class ReportController extends Controller
{
    public function index(Request $request){
        $filter = $request->input('filter', 'Hari');
        
        if ($filter == 'Hari') {
            $payments = Payment::whereDate('created_at', Carbon::today())->get();
        } elseif ($filter == 'Minggu') {
            $payments = Payment::whereBetween('created_at', [Carbon::now()->subWeek(), Carbon::now()])->get();
        } elseif ($filter == 'Bulan') {
            $payments = Payment::whereMonth('created_at', Carbon::now()->month)->get();
        }

        return view('report-admin.index', compact('payments', 'filter'));
    }

    public function report(Request $request){
        $filter = $request->input('filter', 'Hari');
        
        if ($filter == 'Hari') {
            $payments = Payment::whereDate('created_at', Carbon::today())->get();
        } elseif ($filter == 'Minggu') {
            $payments = Payment::whereBetween('created_at', [Carbon::now()->subWeek(), Carbon::now()])->get();
        } elseif ($filter == 'Bulan') {
            $payments = Payment::whereMonth('created_at', Carbon::now()->month)->get();
        }

        $app = ApplicationSetting::pluck('app_name')->first();
        $total = $payments->sum('amount');
        $totalAmount = number_format($total);

        $message = "penghasilan *$app* di *$filter* ini : *Rp $totalAmount*";

        $api = Http::baseUrl('https://app.japati.id/')
            ->withToken('API-TOKEN-tDby9Tpokldf0Xc03om7oNgkX45zJTFtLZ94oNsITsD828VJdZq112')
            ->post('/api/send-message', [
                'gateway' => '6283836949076',
                'number' => '081293962019',
                'type' => 'text',
                'message' => $message,
            ]);

        return redirect()->back()->with('status', 'Message sent successfully!');
    }
}
