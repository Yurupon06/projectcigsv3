<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Member;
use App\Models\Payment;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();

        // Today's Money (Total Payments Amount)
        $todaysMoney = Payment::whereDate('created_at', $today)->sum('amount');
        $yesterdaysMoney = Payment::whereDate('created_at', $yesterday)->sum('amount');
        $todaysMoneyComparison = ($todaysMoney - $yesterdaysMoney) / $yesterdaysMoney * 100;

        // Today's Users (New Users Today)
        $todaysUsers = User::whereDate('created_at', $today)->count();
        $yesterdaysUsers = User::whereDate('created_at', $yesterday)->count();
        $todaysUsersComparison = ($todaysUsers - $yesterdaysUsers) / $yesterdaysUsers * 100;

        // New Members (Members registered today)
        $newMembers = Member::whereDate('created_at', $today)->count();
        $yesterdaysNewMembers = Member::whereDate('created_at', $yesterday)->count();
        $newMembersComparison = ($newMembers - $yesterdaysNewMembers) / $yesterdaysNewMembers * 100;

        // Total Sales Amount (All Time)
        $totalSales = Order::sum('total_amount');
        $todaysSales = Order::whereDate('created_at', $today)->sum('total_amount');
        $yesterdaysSales = Order::whereDate('created_at', $yesterday)->sum('total_amount');
        $salesComparison = ($todaysSales - $yesterdaysSales) / $yesterdaysSales * 100;

        // Get the last 7 days
        $startOfWeek = Carbon::now()->subDays(6); // 7 days including today
        $startOfMonth = Carbon::now()->subDays(30); // 30 days including today
        $endOfDate = Carbon::now();

        // Fetch daily orders for the past week
        $orders = Order::whereBetween('order_date', [$startOfMonth, $endOfDate])
            ->selectRaw('DATE(order_date) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date');

        // Fetch daily payments for the past week
        $payments = Payment::whereBetween('payment_date', [$startOfWeek, $endOfDate])
            ->selectRaw('DATE(payment_date) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date');

        // Fetch daily new members for the past week
        $members = Member::whereBetween('start_date', [$startOfWeek, $endOfDate])
            ->selectRaw('DATE(start_date) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date');

        // Ensure each day in the past has a value (0 if no data)
        $datesWeekly = [];
        $datesMonthly = [];
        $ordersData = [];
        $paymentsData = [];
        $membersData = [];

        // Prepare data for the last week (7 days)
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $datesWeekly[] = $date;
            $ordersData[] = $orders->get($date, 0);
            $paymentsData[] = $payments->get($date, 0);
            $membersData[] = $members->get($date, 0);
        }

        // Prepare data for the last month
        for ($i = 30; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->format('Y-m-d');
            $datesMonthly[] = $date;
            $ordersData[] = $orders->get($date, 0);
            $paymentsData[] = $payments->get($date, 0);
            $membersData[] = $members->get($date, 0);
        }

        return view('dashboard.home', compact(
            'datesWeekly',
            'datesMonthly',
            'ordersData',
            'paymentsData',
            'membersData',
            'todaysMoney',
            'todaysUsers',
            'newMembers',
            'totalSales',
            'todaysSales',
            'yesterdaysMoney',
            'yesterdaysUsers',
            'yesterdaysNewMembers',
            'yesterdaysSales',
            'todaysMoneyComparison',
            'todaysUsersComparison',
            'newMembersComparison',
            'salesComparison'
        ));
    }
    public function profile()
    {
        $user = Auth::user();
        $customer = Customer::where('user_id', $user->id)->first();



        return view('dashboard.profile', compact('user', 'customer'));
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
        $customer = Customer::where('user_id', $user->id)->first();
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

        return redirect()->route('dashboard.profil')->with('success', 'Profile updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:3|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->route('dashboard.profil')->with('warning', 'Current password does not match.');
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('dashboard.profil')->with('success', 'Password updated successfully.');
    }
}
