<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\CodeOtp;
use App\Models\Customer;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:users',
            'phone' => 'required|string|max:13',
            'password' => 'required|string|min:3|confirmed',
            'otp' => 'required|numeric|digits:6',
        ], [
            'otp.digits' => 'OTP harus terdiri dari 6 digit.',
        ]);
        $otpRecord = CodeOtp::where('phone', $request->phone)->first();
    
        if (!$otpRecord || $otpRecord->otp != $request->otp) {
            return redirect()->route('register')->with('error', 'OTP tidak valid atau salah.')->withInput();
        }
    
        $user = User::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'phone_verified_at' => now(),
            'password' => bcrypt($request->password), 
            'role' => 'customer',
        ]);
    
        Customer::create([
            'user_id' => $user->id,
            'phone' => $user->phone,
        ]);
    
        $otpRecord->delete();
    
        return redirect()->route('login')->with('success', 'Registrasi berhasil! Silakan login.');
    }
    

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('phone', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect('dashboard');
            }
            if ($user->role === 'cashier') {
                return redirect('cashier');
            }
            if ($user->role === 'customer') {
                return redirect('/home');
            }
        }

        return redirect()->back()->withErrors(['phone' => 'Invalid credentials'])->withInput();
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }

    public function showResetForm(Request $request)
    {
        $token = $request->segment(2);
        $phone = $request->query('phone');

        $resetToken = DB::table('password_reset_tokens')
        ->where('phone', $phone)
        ->where('token', $token)
        ->first();

        if (!$resetToken) {
            if (Auth::check()) {
                $roleRedirects = [
                    'customer' => '/home',
                    'cashier' => '/cashier',
                    'admin' => '/dashboard',
                ];

                $role = Auth::user()->role;

                if (isset($roleRedirects[$role])) {
                    return redirect($roleRedirects[$role])->with('error', 'The reset link has expired or is invalid.');
                }
            }
            return redirect()->route('login')->with('error', 'The reset link has expired or is invalid.');
        }

        return view('auth.reset-password');
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'phone' => 'required|string|max:13',
            'password' => 'required|string|min:3|confirmed',
        ]);

        $token = $request->input('token');
        $phone = $request->input('phone');
        $password = $request->input('password');

        $resetToken = DB::table('password_reset_tokens')
        ->where('phone', $phone)
        ->where('token', $token)
        ->first();

        if (!$resetToken) {
            if (Auth::check()) {
                $roleRedirects = [
                    'customer' => '/home',
                    'cashier' => '/cashier',
                    'admin' => '/dashboard',
                ];

                $role = Auth::user()->role;

                if (isset($roleRedirects[$role])) {
                    return redirect($roleRedirects[$role])->with('error', 'Request parameters have been tampered with.');
                }
            }
            return redirect()->route('login')->with('error', 'Request parameters have been tampered with.');
        }

        $user = User::where('phone', $phone)->first();

        $user->update([
            'password' => Hash::make($password),
        ]);

        DB::table('password_reset_tokens')->where('phone', $phone)->delete();
        session()->forget('phone');

        if (Auth::check()) {
            $roleRedirects = [
                'customer' => '/home',
                'cashier' => '/cashier',
                'admin' => '/dashboard',
            ];

            $role = Auth::user()->role;

            if (isset($roleRedirects[$role])) {
                return redirect($roleRedirects[$role])->with('success', 'Password reset successfully');
            }
        }
        return redirect()->route('login')->with('success', 'Password reset successfully');
    }
}