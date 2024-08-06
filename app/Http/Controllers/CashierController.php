<?php

namespace App\Http\Controllers;

use App\Models\Cashier;
use App\Models\User;
use Illuminate\Http\Request;

class CashierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengembalikan view dengan data cashier
        return view('cashier.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Menampilkan form untuk membuat resource baru
        // (Implementasi sesuai kebutuhan)
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Menyimpan resource baru ke dalam storage
        // (Implementasi sesuai kebutuhan)
    }

    /**
     * Display the specified resource.
     */
    public function show(Cashier $cashier)
    {
        // Menampilkan detail resource yang ditunjuk
        // (Implementasi sesuai kebutuhan)
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Menampilkan form untuk mengedit resource yang ditunjuk
        // (Implementasi sesuai kebutuhan)
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Memperbarui resource yang ditunjuk dalam storage
        // (Implementasi sesuai kebutuhan)
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Menghapus resource yang ditunjuk dari storage
        // (Implementasi sesuai kebutuhan)
    }
}
