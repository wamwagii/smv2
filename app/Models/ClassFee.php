<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassFee extends Model
{
    protected $fillable = [
        'class_room_id', 'fee_type_id', 'academic_year_id', 'amount', 
        'frequency', 'is_mandatory', 'notes', 'is_active'
    ];
    
    protected $casts = [
        'amount' => 'decimal:2',
        'is_mandatory' => 'boolean',
        'is_active' => 'boolean',
    ];
    
    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class);
    }
    
    public function feeType()
    {
        return $this->belongsTo(FeeType::class);
    }
    
    public function academicYear()
    {
        return $this->belongsTo(AcademicYear::class);
    }
    
    public function studentFees()
    {
        return $this->hasMany(StudentFee::class);
    }
}