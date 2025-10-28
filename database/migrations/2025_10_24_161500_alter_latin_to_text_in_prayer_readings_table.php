<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $driver = DB::connection()->getDriverName();
        if ($driver === 'mysql') {
            DB::statement('ALTER TABLE prayer_readings MODIFY COLUMN latin TEXT');
        } elseif ($driver === 'pgsql') {
            DB::statement('ALTER TABLE prayer_readings ALTER COLUMN latin TYPE TEXT');
        } elseif ($driver === 'sqlite') {
            // SQLite tidak membatasi panjang VARCHAR, sehingga cukup menghapus validasi max:255.
            // Tidak perlu ALTER TABLE di sini.
        }
    }

    public function down(): void
    {
        $driver = DB::connection()->getDriverName();
        if ($driver === 'mysql') {
            DB::statement('ALTER TABLE prayer_readings MODIFY COLUMN latin VARCHAR(255)');
        } elseif ($driver === 'pgsql') {
            DB::statement('ALTER TABLE prayer_readings ALTER COLUMN latin TYPE VARCHAR(255)');
        } elseif ($driver === 'sqlite') {
            // Tidak ada perubahan yang dibuat saat up() untuk sqlite.
        }
    }
};