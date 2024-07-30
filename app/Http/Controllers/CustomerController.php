<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $customer = Customer::with('user')->get();

        return view('customer.index', compact('customer'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        $user = User::where('role', 'customer')->get();
        return view('customer.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $customer = Customer::findOrFail($id);
        $user = User::where('role', 'customer')->get();
        return view('customer.edit', compact('user', 'customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id, )
    {
        //
        $request->validate([
            'user_id' => 'required',
            'phone' => 'required|string|max:15',
            'born' => 'required',
            'gender' => 'required',
        ]);

        
        $customer = Customer::findOrFail($id);
        $customer->user_id = $request->user_id;
        $customer->phone = $request->phone;
        $customer->born = $request->born;
        $customer->gender = $request->gender;
        $customer->save();
    
        return redirect()->route('customer.index')->with('success', 'customer edit successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
        $customer = customer::findOrFail($id);
        $customer->delete();
        return redirect()->route('customer.index')->with('success', 'customer berhasil dihapus.');
    }
}
