<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->string('receipt_number')->unique();
            $table->foreignId('student_fee_id')->constrained()->onDelete('cascade');
            $table->foreignId('fee_payment_id')->constrained()->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->string('payment_method'); // mpesa, bank_equity, bank_coop, cash
            $table->string('transaction_reference')->nullable();
            $table->date('payment_date');
            $table->string('printed_by')->nullable();
            $table->timestamp('printed_at');
            $table->integer('print_count')->default(1);
            $table->text('notes')->nullable();
            $table->timestamps();
            
            // Add indexes for better performance
            $table->index('receipt_number');
            $table->index('payment_method');
            $table->index('printed_at');
        });
    }

    public function down()
    {
        Schema::dropIfExists('receipts');
    }
};