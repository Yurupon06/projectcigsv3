<?php

namespace App\Http\Controllers;

use App\Models\ApplicationSetting;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ApplicationSettings;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class api extends Controller
{
   public function api(){
    $user = Auth::user();
    $appName = ApplicationSetting::all();
    $api = Http::baseUrl('https://app.japati.id/')
    ->withToken('API-TOKEN-tDby9Tpokldf0Xc03om7oNgkX45zJTFtLZ94oNsITsD828VJdZq112')
    ->post('/api/send-message', [
        'gateway' => '6283836949076',
        'number' => '6281293962019',
        'type' => 'text',
        'message' => 'Hai *'.$user->pluck('name')->first(). '* Welcome To *' .$appName->pluck('app_name')->first().'*',
    ]);
    return redirect()->route('test-api')->with('success', 'berhasi terkirim.');
   }
}
