<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 5);
        $user = User::where(function ($query) use ($search) {
            $query->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('phone', 'LIKE', "%{$search}%");
        })
        ->orderBy('name', 'asc')
        ->paginate($perPage);
            
        return view('user.index', compact('user'));
    }

    public function create()
    {
        $roles = User::all();
        return view('user.create', compact('roles'));
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:13',
            'password' => 'required|string|min:8',
            'role' => 'required|in:admin,customer,cashier', // Validasi role
        ]);

        // Simpan data pengguna
        $user = new User();
        $user->name = $request->input('name');
        $user->phone = $request->input('phone');
        $user->password = Hash::make($request->input('password'));
        $user->role = $request->input('role');
        $user->save();

        return redirect()->route('user.index')->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        if (Auth::user()->role === 'customer' && Auth::id() !== $user->id) {
            abort(403);
        }

        return view('user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {

        if (Auth::user()->role === 'customer' && Auth::id() !== $user->id) {
            abort(403);
        }

        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:13',
            'role' => 'required|in:admin,customer,cashier', 
        ]);

        // Update data pengguna
        $user->name = $request->input('name');
        $user->phone = $request->input('phone');
        $user->role = $request->input('role');
        $user->save();

        return redirect()->route('user.index')->with('success', 'User updated successfully.');
    }
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        if (Auth::user()->role === 'customer' && Auth::id() !== $user->id) {
            abort(403);
        }

        
        $user->delete();
        return redirect()->route('user.index')->with('success', 'user berhasil dihapus.');
    }
}