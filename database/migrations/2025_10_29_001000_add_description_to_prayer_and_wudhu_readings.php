<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('prayer_readings') && ! Schema::hasColumn('prayer_readings', 'description')) {
            Schema::table('prayer_readings', function (Blueprint $table) {
                $table->text('description')->nullable()->after('latin');
            });
        }

        if (Schema::hasTable('wudhu_readings') && ! Schema::hasColumn('wudhu_readings', 'description')) {
            Schema::table('wudhu_readings', function (Blueprint $table) {
                $table->text('description')->nullable()->after('latin');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('prayer_readings') && Schema::hasColumn('prayer_readings', 'description')) {
            Schema::table('prayer_readings', function (Blueprint $table) {
                $table->dropColumn('description');
            });
        }

        if (Schema::hasTable('wudhu_readings') && Schema::hasColumn('wudhu_readings', 'description')) {
            Schema::table('wudhu_readings', function (Blueprint $table) {
                $table->dropColumn('description');
            });
        }
    }
};