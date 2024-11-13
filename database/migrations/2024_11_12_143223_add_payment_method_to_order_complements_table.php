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
        Schema::table('order_complements', function (Blueprint $table) {
            $table->enum('payment_method', ['cash', 'transfer'])->nullable()->after('total_amount');
            $table->string('snap_token')->nullable()->after('qr_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_complements', function (Blueprint $table) {
            $table->dropColumn('payment_method');
            $table->dropColumn('snap_token');
        });
    }
};
