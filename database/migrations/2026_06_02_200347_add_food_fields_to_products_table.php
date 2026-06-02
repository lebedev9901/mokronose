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
        Schema::table('products', function (Blueprint $table) {
            $table->string('proteins')->nullable()->after('description'); // белки
            $table->string('fats')->nullable()->after('proteins'); // жиры
            $table->string('carbohydrates')->nullable()->after('fats'); // углеводы
            $table->string('energy_value')->nullable()->after('carbohydrates'); // энергоценность
            $table->string('shelf_life')->nullable()->after('energy_value'); // срок годности
            $table->text('composition')->nullable()->after('shelf_life'); // состав
            $table->text('storage_conditions')->nullable()->after('composition'); // хранение
            $table->text('recommendations')->nullable()->after('storage_conditions'); // рекомендации
            $table->string('age_group')->nullable();
            $table->string('breed_size')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'proteins',
                'fats',
                'carbohydrates',
                'energy_value',
                'shelf_life',
                'composition',
                'storage_conditions',
                'recommendations',
            ]);
        });
    }
};
