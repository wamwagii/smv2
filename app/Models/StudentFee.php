<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentFee extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'class_fee_id',
        'amount',
        'discount',
        'total_payable',
        'paid_amount',
        'balance',
        'status',
        'due_date',
        'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'discount' => 'decimal:2',
        'total_payable' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'balance' => 'decimal:2',
        'due_date' => 'date',
    ];

    // Boot method to handle automatic calculations
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($studentFee) {
            // Ensure balance is calculated before saving
            if ($studentFee->balance === null) {
                $totalPayable = $studentFee->total_payable ?? ($studentFee->amount - ($studentFee->discount ?? 0));
                $paidAmount = $studentFee->paid_amount ?? 0;
                $studentFee->balance = $totalPayable - $paidAmount;
                
                if ($studentFee->balance < 0) {
                    $studentFee->balance = 0;
                }
            }
            
            // Auto-set status if not set
            if ($studentFee->status === null) {
                if ($studentFee->balance <= 0) {
                    $studentFee->status = 'paid';
                } elseif ($studentFee->paid_amount > 0) {
                    $studentFee->status = 'partial';
                } else {
                    $studentFee->status = 'pending';
                }
            }
        });
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function classFee()
    {
        return $this->belongsTo(ClassFee::class);
    }

    public function feePayments()
    {
        return $this->hasMany(FeePayment::class);
    }
}