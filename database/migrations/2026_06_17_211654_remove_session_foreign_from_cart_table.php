<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'sqlite') {
            return;
        }

        if ($driver === 'pgsql') {
            DB::statement('ALTER TABLE cart DROP CONSTRAINT IF EXISTS cart_session_id_foreign');
            return;
        }

        DB::statement('ALTER TABLE cart DROP FOREIGN KEY cart_session_id_foreign');
    }

    public function down(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'sqlite') {
            return;
        }

        DB::statement('
            ALTER TABLE cart
            ADD CONSTRAINT cart_session_id_foreign
            FOREIGN KEY (session_id)
            REFERENCES sessions(id)
            ON DELETE CASCADE
        ');
    }
};