<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Http;

class api extends Controller
{
   public function api(){
    $user = User::all();
    $userNames = $user->pluck('name')->implode(', ');
    $api = Http::baseUrl('https://app.japati.id/')
    ->withToken('API-TOKEN-tDby9Tpokldf0Xc03om7oNgkX45zJTFtLZ94oNsITsD828VJdZq112')
    ->post('/api/send-message', [
        'gateway' => '6283836949076',
        'number' => '6281293962019',
        'type' => 'text',
        'message' => 'list user ' . $userNames,
    ]);
    return redirect()->route('test-api')->with('success', 'berhasi terkirim.');
   }
}
