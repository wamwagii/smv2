<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'teacher_code',
        'first_name',
        'last_name',
        'email',
        'phone',
        'date_of_birth',
        'gender',
        'address',
        'city',
        'qualification',
        'specialization',
        'hire_date',
        'salary',
        'is_active',
        'notes',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'hire_date' => 'date',
        'is_active' => 'boolean',
        'salary' => 'decimal:2',
    ];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    // ADD THIS - A teacher can be a class teacher for one class
    public function classRoom()
    {
        return $this->hasOne(ClassRoom::class, 'class_teacher_id');
    }

    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}