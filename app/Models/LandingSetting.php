<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingSetting extends Model
{
    use HasFactory;

    protected $table = 'landing_settings';

    // Menentukan kolom mana saja yang bisa diisi (mass-assignable)
    protected $fillable = [
        // Banner settings
        'banner_image',
        'banner_h1_text',
        'banner_h1_color',
        'banner_p_text',
        'banner_p_color',
        'banner_button_text',
        'banner_button_color',
        'banner_button_bg_color',

        // About us section
        'about_us_text',
        'about_us_text_color',

        // Produk 1-3
        'product_image_1',
        'product_h1_text_1',
        'product_h1_color_1',
        'product_p_text_1',
        'product_p_color_1',
        'product_link_1',
        'product_link_color_1',

        'product_image_2',
        'product_h1_text_2',
        'product_h1_color_2',
        'product_p_text_2',
        'product_p_color_2',
        'product_link_2',
        'product_link_color_2',

        'product_image_3',
        'product_h1_text_3',
        'product_h1_color_3',
        'product_p_text_3',
        'product_p_color_3',
        'product_link_3',
        'product_link_color_3',

        // Footer settings
        'phone_number',
        'email',
        'facebook',
        'twitter',
        'instagram',
    ];
}
