<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeePayment extends Model
{
    use HasFactory;

    protected $table = 'fee_payments';

    protected $fillable = [
        'student_fee_id',
        'receipt_number',
        'amount',
        'payment_date',
        'payment_method',
        'transaction_reference',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount' => 'decimal:2',
    ];

public function receipt()
{
    return $this->hasOne(Receipt::class);
}

    // Relationship: A payment belongs to a student fee record
    public function studentFee()
    {
        return $this->belongsTo(StudentFee::class);
    }

    // Relationship: A payment was created by a user (admin/accountant)
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Accessor: Get formatted receipt number
    public function getFormattedReceiptAttribute()
    {
        return 'RCP-' . str_pad($this->receipt_number, 8, '0', STR_PAD_LEFT);
    }

    // Accessor: Get formatted amount
    public function getFormattedAmountAttribute()
    {
        return number_format($this->amount, 2);
    }

    // Scope: Filter by payment method
    public function scopeByMethod($query, $method)
    {
        return $query->where('payment_method', $method);
    }

    // Scope: Filter by date range
    public function scopeDateBetween($query, $startDate, $endDate)
    {
        return $query->whereBetween('payment_date', [$startDate, $endDate]);
    }
}