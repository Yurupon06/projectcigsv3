<?php

namespace App\Http\Controllers;

use App\Models\LandingSetting;
use Illuminate\Http\Request;

class LandingSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */ public function index()
    {
        $settings = LandingSetting::first();
        return view('landing_settings.index', compact('settings'));
    }

    // Menyimpan data setting
    public function store(Request $request)
    {
        $data = $request->validate([
            'banner_text' => 'required|string',
            // validasi kolom lainnya
        ]);

        LandingSetting::updateOrCreate(['id' => 1], $data);

        return redirect()->back()->with('success', 'Settings updated successfully!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(LandingSetting $landingSetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LandingSetting $landingSetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LandingSetting $landingSetting)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LandingSetting $landingSetting)
    {
        //
    }
}
