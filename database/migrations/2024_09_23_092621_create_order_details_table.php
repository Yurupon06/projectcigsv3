<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_complement_id');
            $table->foreign('order_complement_id')->references('id')->on('order_complements')->ondelete('cascade')->onupdate('cascade');
            $table->unsignedBigInteger('complement_id');
            $table->foreign('complement_id')->references('id')->on('complements')->ondelete('cascade')->onupdate('cascade');
            $table->integer('quantity')->default(1);
            $table->unsignedBigInteger('sub_total');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
