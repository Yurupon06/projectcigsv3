<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
{   
    $user = Auth::user();
    $customer = Customer::where('user_id', $user->id)->first();

    return view('profile.index', compact('user', 'customer'));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = Auth::user();
        $customer = Customer::where('user_id', $user->id)->first();
        return view('profile.edit', compact('user', 'customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:20',
            'gender' => 'required|in:men,women',
            'born' => 'required|date',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $customer = Customer::where('user_id', $user->id)->firstOrFail();
        $customer->update([
            'phone' => $request->phone,
            'born' => $request->born,
            'gender' => $request->gender,
        ]);

        return redirect()->route('profile.index')->with('success', 'Profile updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
