<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('students')) {
            Schema::create('students', function (Blueprint $table) {
                $table->id();
                $table->foreignId('school_id')->constrained()->cascadeOnDelete();
                $table->string('admission_number')->unique();
                $table->string('first_name');
                $table->string('last_name');
                $table->string('email')->unique();
                $table->string('phone')->nullable();
                $table->date('date_of_birth');
                $table->enum('gender', ['male', 'female', 'other']);
                $table->text('address')->nullable();
                $table->string('city')->nullable();
                $table->date('enrollment_date');
                $table->string('parent_name')->nullable();
                $table->string('parent_phone')->nullable();
                $table->string('parent_email')->nullable();
                $table->boolean('is_active')->default(true);
                $table->text('medical_notes')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};