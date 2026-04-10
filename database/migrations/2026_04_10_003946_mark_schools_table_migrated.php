<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Check if schools table exists but not in migrations table
        if (Schema::hasTable('schools')) {
            $exists = DB::table('migrations')->where('migration', '2026_04_10_000228_create_schools_table')->exists();
            if (!$exists) {
                DB::table('migrations')->insert([
                    'migration' => '2026_04_10_000228_create_schools_table',
                    'batch' => 1
                ]);
            }
        }
    }

    public function down(): void
    {
        DB::table('migrations')->where('migration', '2026_04_10_000228_create_schools_table')->delete();
    }
};