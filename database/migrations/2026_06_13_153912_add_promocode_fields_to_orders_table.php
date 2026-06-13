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
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('promocode_id')->nullable()->after('user_id')->constrained('promocodes')->nullOnDelete();
            $table->string('promocode_code')->nullable()->after('promocode_id');
            $table->decimal('total_before_discount', 10, 2)->default(0)->after('total_price');
            $table->decimal('discount_amount', 10, 2)->default(0)->after('total_before_discount');
            $table->decimal('total_after_discount', 10, 2)->default(0)->after('discount_amount');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropConstrainedForeignId('promocode_id');
            $table->dropColumn([
                'promocode_code',
                'total_before_discount',
                'discount_amount',
                'total_after_discount',
            ]);
        });
    }
};
