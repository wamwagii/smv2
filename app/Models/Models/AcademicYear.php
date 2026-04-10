<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicYear extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_id',
        'name',
        'start_date',
        'end_date',
        'is_current',
        'description',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_current' => 'boolean',
    ];

    // Relationships
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function classes()
    {
        return $this->hasMany(ClassRoom::class);
    }

    // Scope for current academic year
    public function scopeCurrent($query)
    {
        return $query->where('is_current', true);
    }

    // Check if date is within academic year
    public function isDateInYear($date)
    {
        return $date >= $this->start_date && $date <= $this->end_date;
    }
}