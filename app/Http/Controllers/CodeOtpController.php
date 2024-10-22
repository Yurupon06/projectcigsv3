<?php

namespace App\Http\Controllers;

use App\Models\CodeOtp;
use App\Models\User;
use App\Models\ApplicationSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class CodeOtpController extends Controller
{
    public function sendOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:13',
        ]);

        $phone = $request->phone;

        $userExists = User::where('phone', $phone)->exists();

        if ($userExists) {
            return response()->json(['success' => false, 'message' => 'Phone already exists!'], 409);
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

        return response()->json(['success' => true, 'message' => 'OTP sent successfully']);
    }

    public function sendOtpForgotPassword(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|max:13',
        ]);

        $phone = $request->phone;
        session(['phone' => $phone]);

        $userExists = User::where('phone', $phone)->exists();

        if (!$userExists) {
            return redirect()->back()->with('error', 'Phone not found');
        }

        CodeOtp::where('phone', $phone)->delete();
        DB::table('password_reset_tokens')->where('phone', $phone)->delete();

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

        return redirect()->route('validate-otp')->with('success', 'OTP sent successfully');
    }

    public function validateOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric|digits:6',
        ]);

        $otp = $request->otp;
        $phone = session('phone');

        $codeOtp = CodeOtp::where('phone', $phone)->first();

        if ($codeOtp && $codeOtp->otp == $otp) {
            $token = Str::random(60);
            DB::table('password_reset_tokens')->insert([
                'phone' => $phone,
                'token' => $token,
                'created_at' => now(),
            ]);
            $codeOtp->delete();
            return redirect()->route('password.reset',['token' => $token, 'phone' => $phone])->with('success', 'OTP verified successfully');
        } else {
            return redirect()->back()->with('error', 'Invalid OTP');
        }
    }
}

