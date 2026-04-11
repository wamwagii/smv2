<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'postal_code',
        'country',
        'logo',
        'principal_name',
        'website',
        'is_active',
        'description',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // ADD THIS - A school has many students
    public function students()
    {
        return $this->hasMany(Student::class);
    }

    // ADD THIS - A school has many teachers
    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }

    // ADD THIS - A school has many classrooms
    public function classRooms()
    {
        return $this->hasMany(ClassRoom::class);
    }

    // ADD THIS - A school has many academic years
    public function academicYears()
    {
        return $this->hasMany(AcademicYear::class);
    }
}