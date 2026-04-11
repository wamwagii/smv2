<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Receipt extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'receipt_number',
        'student_fee_id',
        'fee_payment_id',
        'amount',
        'payment_method',
        'transaction_reference',
        'payment_date',
        'printed_by',
        'printed_at',
        'print_count',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date',
        'printed_at' => 'datetime',  // Fixed: missing closing quote
    ];

    public function studentFee()
    {
        return $this->belongsTo(StudentFee::class);
    }
    
    public function feePayment()
    {
        return $this->belongsTo(FeePayment::class);
    }
    
    public static function generateReceiptNumber()
    {
        $year = date('Y');
        $month = date('m');
        
        $lastReceipt = self::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('created_at', 'desc')
            ->first();

        if ($lastReceipt) {
            $lastNumber = (int) substr($lastReceipt->receipt_number, -4);
            $count = $lastNumber + 1;
        } else {
            $count = 1;
        }

        return 'RCP-' . $year . $month . '-' . str_pad($count, 4, '0', STR_PAD_LEFT);
    }
}