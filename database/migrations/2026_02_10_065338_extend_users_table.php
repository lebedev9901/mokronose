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
        Schema::table('users', function (Blueprint $table)
        {
            $table->string('first_name')->after('id');
            $table->string('last_name')->after('first_name');
            $table->string('middle_name')->nullable()->after('last_name');

            $table->date('birth_date')->nullable()->after('middle_name');

            $table->string('phone')->nullable()->unique()->after('email');

            $table->string('avatar')->nullable()->after('phone');

            $table->string('role')->default('user')->after('password');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table)
        {
            $table->dropColumn([
                'first_name',
                'last_name',
                'middle_name',
                'birth_date',
                'phone',
                'avatar',
                'role',
            ]);
        });
    }
};
