<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLandingSettingsTable extends Migration
{
    public function up()
    {
        Schema::create('landing_settings', function (Blueprint $table) {
            $table->id();
            $table->string('banner_image')->nullable(); // Image URL for the banner
            $table->string('banner_h1_text')->nullable(); // Text for H1 in banner
            $table->text('banner_p_text')->nullable(); // Text for paragraph in banner
            $table->string('banner_button_text')->nullable(); // Text for button in banner
            $table->string('banner_button_color')->nullable(); // Color for button text
            $table->string('banner_button_bg_color')->nullable(); // Background color for button
            $table->string('banner_h1_color')->nullable(); // Color for H1 text in banner
            $table->string('banner_p_color')->nullable(); // Color for paragraph text in banner

            $table->text('about_us_text')->nullable(); // About Us section text
            $table->string('about_us_text_color')->nullable(); // Color for About Us text

            $table->string('product_image_1')->nullable(); // Product 1 image
            $table->string('product_h1_text_1')->nullable(); // Product 1 H1 text
            $table->string('product_h1_color_1')->nullable(); // Product 1 H1 color
            $table->text('product_p_text_1')->nullable(); // Product 1 paragraph text
            $table->string('product_p_color_1')->nullable(); // Product 1 paragraph color
            $table->string('product_link_1')->nullable(); // Product 1 link
            $table->string('product_link_color_1')->nullable(); // Product 1 link color

            $table->string('product_image_2')->nullable();// Product 2 image
            $table->string('product_h1_text_2')->nullable(); // Product 2 H1 text
            $table->string('product_h1_color_2')->nullable(); // Product 2 H1 color
            $table->text('product_p_text_2')->nullable(); // Product 2 paragraph text
            $table->string('product_p_color_2')->nullable(); // Product 2 paragraph color
            $table->string('product_link_2')->nullable(); // Product 2 link
            $table->string('product_link_color_2')->nullable(); // Product 2 link color

            $table->string('product_image_3')->nullable();// Product 3 image
            $table->string('product_h1_text_3')->nullable(); // Product 3 H1 text
            $table->string('product_h1_color_3')->nullable(); // Product 3 H1 color
            $table->text('product_p_text_3')->nullable();// Product 3 paragraph text
            $table->string('product_p_color_3')->nullable(); // Product 3 paragraph color
            $table->string('product_link_3')->nullable(); // Product 3 link
            $table->string('product_link_color_3')->nullable(); // Product 3 link color

            $table->string('phone_number')->nullable(); // Phone number for footer
            $table->string('email')->nullable(); // Email for footer
            $table->string('facebook')->nullable(); // Facebook link for footer
            $table->string('twitter')->nullable(); // Twitter link for footer
            $table->string('instagram')->nullable(); // Instagram link for footer

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('landing_settings');
    }
};
