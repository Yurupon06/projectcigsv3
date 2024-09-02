<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.home');
    }

    public function profile()
    {
        $user = Auth::user();
        $customer = Customer::where('user_id', $user->id)->first();

        if (!$customer) {
            abort(403);
        }


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
        if (!$customer) {
            abort(403);
        }
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
