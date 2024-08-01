<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('user.index', [
            'user' => User::all()
        ]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $roles = User::all();
        return view('user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,customer,cashier', // Validasi role
        ]);

        // Simpan data pengguna
        $user = new User();
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->role = $request->input('role'); 
        $user->save();

        return redirect()->route('user.index')->with('success', 'User created successfully.');
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
    public function edit(User $user)
{
    return view('user.edit', compact('user'));
}

public function update(Request $request, User $user)
{
    // Validasi input
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        'role' => 'required|in:admin,customer,cashier', // Validasi role
    ]);

    // Update data pengguna
    $user->name = $request->input('name');
    $user->email = $request->input('email');

    $user->role = $request->input('role');
    $user->save();

    return redirect()->route('user.index')->with('success', 'User updated successfully.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('user.index')->with('success', 'user berhasil dihapus.');

    }
}
