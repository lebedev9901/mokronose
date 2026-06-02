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
        Schema::table('pets', function (Blueprint $table) {
            $table->string('age_group')->nullable()->after('birth_date');
            $table->string('breed_size')->nullable()->after('age_group');
            $table->decimal('weight', 5, 2)->nullable()->after('breed_size');
            $table->text('notes')->nullable()->after('weight');
        });
    }

    public function down(): void
    {
        Schema::table('pets', function (Blueprint $table) {
            $table->dropColumn([
                'age_group',
                'breed_size',
                'weight',
                'notes',
            ]);
        });
    }
};
