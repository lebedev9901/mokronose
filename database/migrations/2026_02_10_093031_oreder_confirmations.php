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
        Schema::create('order_confirmations', function(Blueprint $table){
            $table->id();
            $table->enum('assigned_to', ['support_user_id', 'manager']);
            $table->enum('status', ['pendeng', 'confirmed', 'canceled']);
            $table->longText('comment')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_confirmations');
    }
};
