<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeType extends Model
{
    protected $fillable = ['name', 'code', 'description', 'is_optional', 'is_active', 'sort_order'];
    
    protected $casts = [
        'is_optional' => 'boolean',
        'is_active' => 'boolean',
    ];
    
    public function classFees()
    {
        return $this->hasMany(ClassFee::class);
    }
}