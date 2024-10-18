<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\User;
use App\Models\Member;
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

    public function report(Request $request) {
        $filter = $request->input('filter', 'Hari');
        $app = ApplicationSetting::first();
        $startDate = Carbon::today(); 
        $endDate = Carbon::today();  
    
        if ($filter == 'Hari') {
            $payments = Payment::whereDate('created_at', Carbon::today())->get();
            $user = User::whereDate('created_at', Carbon::today())->get();
            $startDate = Carbon::yesterday()->format('d-m-Y');
            $endDate = Carbon::today()->format('d-m-Y');
        } elseif ($filter == 'Minggu') {
            $payments = Payment::whereBetween('created_at', [Carbon::now()->subWeek(), Carbon::now()])->get();
            $user = User::whereBetween('created_at', [Carbon::now()->subWeek(), Carbon::now()])->get();
            $startDate = Carbon::now()->subWeek()->format('d-m-Y');
            $endDate = Carbon::now()->format('d-m-Y');
        } elseif ($filter == 'Bulan') {
            $payments = Payment::whereMonth('created_at', Carbon::now()->month)->get();
            $user = User::whereMonth('created_at', Carbon::now()->month)->get();
            $startDate = Carbon::now()->startOfMonth()->format('d-m-Y');
            $endDate = Carbon::now()->format('d-m-Y');
        }
    

        $total = $payments->sum('amount');
        $totalAmount = number_format($total);
    
        $message = "Data *$app->app_name* *$filter* ini dari *$startDate* - *$endDate* : *Rp $totalAmount*";
    
        $api = Http::baseUrl($app->japati_url)
        ->withToken($app->japati_token)
        ->post('/api/send-message', [
            'gateway' => $app->japati_gateway,
                'number' => '081293962019',
                'type' => 'text',
                'message' => $message,
            ]);
    
        return redirect()->route('report.send')->with('success', 'Message sent successfully!');
    }
}
