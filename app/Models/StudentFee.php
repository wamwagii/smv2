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