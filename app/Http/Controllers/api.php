<?php

namespace App\Http\Controllers;

use App\Models\ApplicationSetting;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ApplicationSettings;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class api extends Controller
{
   public function api(){
    $app = ApplicationSetting::first();
    $user = Auth::user()->first();
    $appName = ApplicationSetting::first();
    $api = Http::baseUrl($app->japati_url)
    ->withToken($app->japati_token)
    ->post('/api/send-message', [
        'gateway' => $app->japati_gateway,
        'number' => '6281293962019',
        'type' => 'text',
        'message' => 'Hai *'.$user->name. '* Welcome To *' .$appName->app_name.'*',
    ]);
    if (!$api->successful()) {
        Log::error('Failed to send message', ['response' => $api->body()]);
        throw new \Exception('Failed to send message');
    }
    return redirect()->route('test-api')->with('success', 'berhasi terkirim.');
   }
}
