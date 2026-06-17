<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

return new class extends Migration
{
    public function up(): void
    {
        $driver = DB::getDriverName();

        if ($driver === 'sqlite') {
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