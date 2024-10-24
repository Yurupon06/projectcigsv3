<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\CodeOtp;
use App\Models\ApplicationSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class ChangePhoneController extends Controller
{
    public function changePhone(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:13',
        ]);

        $user = Auth::user();
        $phone = $request->phone;
        session(['phone' => $phone]);

        $userExists = User::where('phone', $phone)->exists();

        if ($userExists) {
            return redirect()->back()->with('error', 'Phone already exists');
        }

        $otp = rand(100000, 999999);
        $setting = ApplicationSetting::first();

        CodeOtp::updateOrCreate(
            ['phone' => $phone],
            ['otp' => $otp]
        );

        $api = Http::baseUrl($setting->japati_url)
        ->withToken($setting->japati_token)
        ->post('/api/send-message', [
            'gateway' => $setting->japati_gateway,
            'number' => $phone,
            'type' => 'text',
            'message' => '*' . $otp. '* is your *' .$setting->app_name. '* Verivication code.',
        ]);

        if(Auth::user()->role === 'customer') {
            return redirect()->route('validate-otp-customer')->with('success', 'OTP sent successfully');
        }

        return redirect()->back()->with('send', 'OTP sent successfully');
    }

    public function validateOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric|digits:6',
        ]);

        $user = Auth::user();
        $otp = $request->otp;
        $phone = session('phone');

        $codeOtp = CodeOtp::where('phone', $phone)->first();
        $setting = ApplicationSetting::first();

        if ($codeOtp && $codeOtp->otp == $otp) {
            $codeOtp->delete();

            $message = "Hello, *" . $user->name . "*.\nYour *" . $setting->app_name . "* account is now connected with *" . $phone . "* number. If you didn't make this change, please contact us immediately.";
            $api = Http::baseUrl($setting->japati_url)
            ->withToken($setting->japati_token)
            ->post('/api/send-message', [
                'gateway' => $setting->japati_gateway,
                'number' => $user->phone,
                'type' => 'text',
                'message' => $message,
            ]);

            $message = "This phone number is now connected with *" . $user->name . "* account from *" . $setting->app_name . "*. If you have questions or need help, please contact us.";
            $api = Http::baseUrl($setting->japati_url)
            ->withToken($setting->japati_token)
            ->post('/api/send-message', [
                'gateway' => $setting->japati_gateway,
                'number' => $phone,
                'type' => 'text',
                'message' => $message,
            ]);

            $user->update([
                'phone' => $phone,
                'phone_verified_at' => now(),
            ]);

            if(Auth::user()->role === 'customer') {
                return redirect()->route('landing.index')->with('success', 'Phone number updated successfully!');
            }
            return redirect()->route('home.index')->with('success', 'Phone number updated successfully!');
        } else {
            return redirect()->back()->with('invalid-otp', 'Invalid OTP');
        }
    }
}
