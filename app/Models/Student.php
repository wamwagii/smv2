<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'class_room_id',  // ← ADD THIS to fillable
        'admission_number',
        'first_name',
        'last_name',
        'email',
        'phone',
        'date_of_birth',
        'gender',
        'address',
        'city',
        'enrollment_date',
        'parent_name',
        'parent_phone',
        'parent_email',
        'is_active',
        'medical_notes',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'enrollment_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    // ← ADD THIS RELATIONSHIP
    public function classRoom()
    {
        return $this->belongsTo(ClassRoom::class);
    }

    // ← ADD THIS RELATIONSHIP
    public function studentFees()
    {
        return $this->hasMany(StudentFee::class);
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}