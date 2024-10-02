<?php

namespace App\Http\Controllers;

use App\Models\LandingSetting;
use Illuminate\Http\Request;

class LandingSettingController extends Controller
{
    public function index()
    {
        return view('landing_settings.index');
    }

    // Menyimpan landing settings ke dalam database
    public function store(Request $request, LandingSetting $landingSetting)
    {
        $request->validate([
            'banner_image' => 'nullable|string|max:255',
            'banner_h1_text' => 'nullable|string|max:255',
            'banner_p_text' => 'nullable|string',
            'banner_button_text' => 'nullable|string|max:255',
            'banner_button_color' => 'nullable|string|max:7',
            'banner_button_bg_color' => 'nullable|string|max:7',
            'banner_h1_color' => 'nullable|string|max:7',
            'banner_p_color' => 'nullable|string|max:7',
            'about_us_text' => 'nullable|string',
            'about_us_text_color' => 'nullable|string|max:7',

            'product_image_1' => 'nullable|string|max:255',
            'product_h1_text_1' => 'nullable|string|max:255',
            'product_h1_color_1' => 'nullable|string|max:7',
            'product_p_text_1' => 'nullable|string',
            'product_p_color_1' => 'nullable|string|max:7',
            'product_link_1' => 'nullable|string|max:255',
            'product_link_color_1' => 'nullable|string|max:7',

            'product_image_2' => 'nullable|string|max:255',
            'product_h1_text_2' => 'nullable|string|max:255',
            'product_h1_color_2' => 'nullable|string|max:7',
            'product_p_text_2' => 'nullable|string',
            'product_p_color_2' => 'nullable|string|max:7',
            'product_link_2' => 'nullable|string|max:255',
            'product_link_color_2' => 'nullable|string|max:7',

            'product_image_3' => 'nullable|string|max:255',
            'product_h1_text_3' => 'nullable|string|max:255',
            'product_h1_color_3' => 'nullable|string|max:7',
            'product_p_text_3' => 'nullable|string',
            'product_p_color_3' => 'nullable|string|max:7',
            'product_link_3' => 'nullable|string|max:255',
            'product_link_color_3' => 'nullable|string|max:7',

            'phone_number' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255',
            'facebook' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('banner_image') && $request->file('banner_image')->isValid()) {
            $request->file('banner_image')->store('banners', 'public');
            $path = $request->file('banner_image')->hashName();
            $landingSetting->banner_image = "banners/{$path}";
        }
        
        if ($request->hasFile('product_image_1') && $request->file('product_image_1')->isValid()) {
            $request->file('product_image_1')->store('banners', 'public');
            $path = $request->file('product_image_1')->hashName();
            $landingSetting->product_image_1 = "banners/{$path}";
        }

        if ($request->hasFile('product_image_2') && $request->file('product_image_2')->isValid()) {
            $request->file('product_image_2')->store('banners', 'public');
            $path = $request->file('product_image_2')->hashName();
            $landingSetting->product_image_2 = "banners/{$path}";
        }

        if ($request->hasFile('product_image_3') && $request->file('product_image_3')->isValid()) {
            $request->file('product_image_3')->store('banners', 'public');
            $path = $request->file('product_image_3')->hashName();
            $landingSetting->product_image_3 = "banners/{$path}";

            $landingSetting->save();
        }

        $landingSetting->update($request->except('banner_image', 'product_image_1', 'product_image_2', 'product_image_3')); // Mengupdate semua kecuali gambar

        return redirect()->route('landing-settings.index')->with('success', 'Landing settings created successfully.');
    }
    // Memperbarui landing settings di dalam database
    public function update(Request $request, LandingSetting $landingSetting)
    {
        $request->validate([
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'banner_h1_text' => 'nullable|string|max:255',
            'banner_p_text' => 'nullable|string',
            'banner_button_text' => 'nullable|string|max:255',
            'banner_button_color' => 'nullable|string|max:7',
            'banner_button_bg_color' => 'nullable|string|max:7',
            'banner_h1_color' => 'nullable|string|max:7',
            'banner_p_color' => 'nullable|string|max:7',

            'about_us_text' => 'nullable|string',
            'about_us_text_color' => 'nullable|string|max:7',

            'product_image_1' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'product_h1_text_1' => 'nullable|string|max:255',
            'product_h1_color_1' => 'nullable|string|max:7',
            'product_p_text_1' => 'nullable|string',
            'product_p_color_1' => 'nullable|string|max:7',
            'product_link_1' => 'nullable|string|max:255',
            'product_link_color_1' => 'nullable|string|max:7',

            'product_image_2' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'product_h1_text_2' => 'nullable|string|max:255',
            'product_h1_color_2' => 'nullable|string|max:7',
            'product_p_text_2' => 'nullable|string',
            'product_p_color_2' => 'nullable|string|max:7',
            'product_link_2' => 'nullable|string|max:255',
            'product_link_color_2' => 'nullable|string|max:7',

            'product_image_3' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'product_h1_text_3' => 'nullable|string|max:255',
            'product_h1_color_3' => 'nullable|string|max:7',
            'product_p_text_3' => 'nullable|string',
            'product_p_color_3' => 'nullable|string|max:7',
            'product_link_3' => 'nullable|string|max:255',
            'product_link_color_3' => 'nullable|string|max:7',

            'phone_number' => 'nullable|string|max:15',
            'email' => 'nullable|email|max:255',
            'facebook' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
        ]);
        
        if ($request->hasFile('banner_image') && $request->file('banner_image')->isValid()) {
            $request->file('banner_image')->store('banners', 'public');
            $path = $request->file('banner_image')->hashName();
            $landingSetting->banner_image = "banners/{$path}";
        }
        
        if ($request->hasFile('product_image_1') && $request->file('product_image_1')->isValid()) {
            $request->file('product_image_1')->store('banners', 'public');
            $path = $request->file('product_image_1')->hashName();
            $landingSetting->product_image_1 = "banners/{$path}";
        }

        if ($request->hasFile('product_image_2') && $request->file('product_image_2')->isValid()) {
            $request->file('product_image_2')->store('banners', 'public');
            $path = $request->file('product_image_2')->hashName();
            $landingSetting->product_image_2 = "banners/{$path}";
        }

        if ($request->hasFile('product_image_3') && $request->file('product_image_3')->isValid()) {
            $request->file('product_image_3')->store('banners', 'public');
            $path = $request->file('product_image_3')->hashName();
            $landingSetting->product_image_3 = "banners/{$path}";

            $landingSetting->save();
        }

        $landingSetting->update($request->except('banner_image', 'product_image_1', 'product_image_2', 'product_image_3')); // Mengupdate semua kecuali gambar

        return redirect()->back()->with('success', 'Settings updated successfully');
    }
}
