<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    //
    public function index()
    {
        return view('dashboard.home');
    }

    public function profile(){
        $user = Auth::user();
        $customer = Customer::where('user_id', $user->id)->first();
        return view('dashboard.profile', compact('user', 'customer'));
    }

    public function profileUpdate(Request $request)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'born' => 'required|date',
            'gender' => 'required|in:men,women',
        ];

        // Validasi password hanya jika salah satu field password diisi
        if ($request->filled('password') || $request->filled('password_confirmation')) {
            $rules['current_password'] = 'required|string';
            $rules['password'] = 'required|string|confirmed';
            $rules['password_confirmation'] = 'required|string';
        }

        $validatedData = $request->validate($rules);

        $user = Auth::user();

        // Update user details
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];

        // Cek jika password baru diisi
        if ($request->filled('password')) {
            // Validasi password lama
            if (!Hash::check($validatedData['current_password'], $user->password)) {
                return back()->withErrors(['current_password' => 'The provided current password does not match our records.'])->withInput();
            }
            // Update password
            $user->password = Hash::make($validatedData['password']);
        }

        $user->save();

        // Update atau buat detail pelanggan
        Customer::updateOrCreate(
            ['user_id' => $user->id],
            [
                'phone' => $validatedData['phone'],
                'born' => $validatedData['born'],
                'gender' => $validatedData['gender'],
            ]
        );

        return redirect()->route('dashboard.profil')->with('success', 'Profile updated successfully.');
    }

}
