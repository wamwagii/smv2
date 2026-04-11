<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('receipts')) {
            Schema::create('receipts', function (Blueprint $table) {
                $table->id();
                $table->string('receipt_number')->unique();
                $table->foreignId('student_fee_id')->constrained('student_fees')->onDelete('cascade');
                $table->foreignId('fee_payment_id')->constrained('fee_payments')->onDelete('cascade');
                $table->decimal('amount', 10, 2);
                $table->string('payment_method');
                $table->string('transaction_reference')->nullable();
                $table->date('payment_date');
                $table->string('printed_by')->nullable();
                $table->timestamp('printed_at');
                $table->integer('print_count')->default(1);
                $table->text('notes')->nullable();
                $table->timestamps();
                
                $table->index('receipt_number');
                $table->index('payment_method');
                $table->index('printed_at');
            });
            echo "Receipts table created successfully!\n";
        } else {
            echo "Receipts table already exists.\n";
        }
    }

    public function down()
    {
        Schema::dropIfExists('receipts');
    }
};