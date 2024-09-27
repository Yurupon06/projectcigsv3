<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'banner_text', 
        'banner_button', 
        'about_us_text', 
        'product_card_image_1', 
        'product_card_image_2', 
        'product_card_image_3',
        'product_card_text_1', 
        'product_card_text_2', 
        'product_card_text_3',
        'product_card_link_1', 
        'product_card_link_2', 
        'product_card_link_3',
        'footer_phone', 
        'footer_email', 
        'footer_facebook', 
        'footer_twitter', 
        'footer_instagram',
        'button_color', 
        'link_color', 
        'text_color'
    ];
}
