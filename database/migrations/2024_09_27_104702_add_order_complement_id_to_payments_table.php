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
        Schema::table('payments', function (Blueprint $table) {
            $table->unsignedBigInteger('order_complement_id')->nullable()->after('order_id');
            $table->foreign('order_complement_id')->references('id')->on('order_complements')->ondelete('cascade')->onupdate('cascade'); 
            $table->unsignedBigInteger('order_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('order_complement_id'); 
            $table->unsignedBigInteger('order_id')->nullable(false)->change();
        });
    }
};
