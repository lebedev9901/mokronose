<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
             DB::statement("
            ALTER TABLE orders 
            MODIFY status ENUM(
                'new',
                'pending',
                'confirmed',
                'processing',
                'shipped',
                'delivered',
                'completed',
                'cancelled'
            ) NOT NULL DEFAULT 'new'
        ");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
             DB::statement("
            ALTER TABLE orders 
            MODIFY status ENUM(
                'new',
                'pending',
                'confirmed',
                'processing',
                'completed',
                'cancelled'
            ) NOT NULL DEFAULT 'new'
        ");
        });
    }
};
