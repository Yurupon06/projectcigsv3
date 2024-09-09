<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $perPage = $request->input('per_page', 5);
        $customer = Customer::select('customers.*')
        ->join('users', 'customers.user_id', '=', 'users.id')
        ->where('users.role', 'customer') 
        ->where(function ($query) use ($search) {
            if ($search) {
                $query->where('users.name', 'LIKE', "%{$search}%");
            }
        })
        ->with('user')
        ->orderBy('users.name', 'asc')
        ->paginate($perPage);
        return view('customer.index', compact('customer'));
    }

    public function create()
    {
        $user = User::where('role', 'customer')->get();
        return view('customer.create', compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'phone' => 'required|string|max:15',
            'born' => 'required',
            'gender' => 'required',
        ]);

        $customer = new Customer();
        $customer->user_id = $request->user_id;
        $customer->phone = $request->phone;
        $customer->born = $request->born;
        $customer->gender = $request->gender;
        $customer->save();

        return redirect()->route('customer.index')->with('success', 'customer created successfully.');
    }

    public function edit($id)
    {
        $customer = Customer::findOrFail($id);

        // if (Auth::user()->role === 'customer' && Auth::id() !== $customer->user_id) {
        //     abort(403);
        // }

        $user = User::all();
        return view('customer.edit', compact('user', 'customer'));
    }

    public function update(Request $request, $id, )
    {
        $request->validate([
            'user_id' => 'required',
            'phone' => 'required|string|max:15',
            'born' => 'required',
            'gender' => 'required',
        ]);

        $customer = Customer::findOrFail($id);

        if (Auth::user()->role === 'customer' && Auth::id() !== $customer->user_id) {
            abort(403);
        }

        $customer->user_id = $request->user_id;
        $customer->phone = $request->phone;
        $customer->born = $request->born;
        $customer->gender = $request->gender;
        $customer->save();

        return redirect()->route('customer.index')->with('success', 'customer edit successfully.');
    }

    public function destroy($id)
    {
        $customer = customer::findOrFail($id);

        if (Auth::user()->role === 'customer' && Auth::id() !== $customer->user_id) {
            abort(403);
        }
        
        $customer->delete();
        return redirect()->route('customer.index')->with('success', 'customer berhasil dihapus.');
    }
}
