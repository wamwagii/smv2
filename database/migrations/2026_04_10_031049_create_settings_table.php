<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('text');
            $table->string('group')->default('general');
            $table->timestamps();
        });
        
        // Insert default settings
        DB::table('settings')->insert([
            ['key' => 'app_name', 'value' => 'School Management System', 'type' => 'text', 'group' => 'general', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'dark_mode', 'value' => 'light', 'type' => 'select', 'group' => 'appearance', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'primary_color', 'value' => '#0D8F81', 'type' => 'color', 'group' => 'appearance', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'timezone', 'value' => 'Africa/Nairobi', 'type' => 'select', 'group' => 'general', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'date_format', 'value' => 'Y-m-d', 'type' => 'select', 'group' => 'general', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'school_name', 'value' => 'My School', 'type' => 'text', 'group' => 'school', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'school_address', 'value' => '', 'type' => 'textarea', 'group' => 'school', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'school_phone', 'value' => '', 'type' => 'text', 'group' => 'school', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'school_email', 'value' => '', 'type' => 'email', 'group' => 'school', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};