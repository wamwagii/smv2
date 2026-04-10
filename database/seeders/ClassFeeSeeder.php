<?php

namespace Database\Seeders;

use App\Models\ClassFee;
use App\Models\ClassRoom;
use App\Models\FeeType;
use Illuminate\Database\Seeder;

class ClassFeeSeeder extends Seeder
{
    public function run(): void
    {
        $classes = ClassRoom::where('is_active', true)->get();
        $feeTypes = FeeType::all();
        
        // Define base fees by class level (you can customize)
        $feeStructure = [
            'Grade' => ['tuition' => 5000, 'activity' => 1000, 'lunch' => 3000, 'library' => 500, 'sports' => 500, 'ict' => 500, 'medical' => 500],
            'Form' => ['tuition' => 8000, 'activity' => 1500, 'lunch' => 3500, 'library' => 1000, 'sports' => 1000, 'ict' => 1000, 'medical' => 1000],
            'Nursery' => ['tuition' => 4000, 'activity' => 800, 'lunch' => 2500, 'library' => 300, 'sports' => 300, 'ict' => 300, 'medical' => 300],
        ];
        
        foreach ($classes as $class) {
            $academicYearId = $class->academic_year_id;
            $className = $class->name;
            
            // Determine fee multiplier based on class type
            $multiplier = 1;
            if (str_contains($className, 'Form')) $multiplier = 1.5;
            if (str_contains($className, 'Grade')) $multiplier = 1;
            if (str_contains($className, 'Nursery')) $multiplier = 0.8;
            
            foreach ($feeTypes as $feeType) {
                $amount = match($feeType->code) {
                    'TUITION' => 5000 * $multiplier,
                    'ACTIVITY' => 1000 * $multiplier,
                    'LUNCH' => 3000 * $multiplier,
                    'TRANSPORT' => 2000 * $multiplier,
                    'TOURS' => 1500 * $multiplier,
                    'LIBRARY' => 500 * $multiplier,
                    'SPORTS' => 500 * $multiplier,
                    'ICT' => 500 * $multiplier,
                    'MEDICAL' => 500 * $multiplier,
                    default => 0,
                };
                
                if ($amount > 0) {
                    ClassFee::create([
                        'class_room_id' => $class->id,
                        'fee_type_id' => $feeType->id,
                        'academic_year_id' => $academicYearId,
                        'amount' => $amount,
                        'frequency' => 'term',
                        'is_mandatory' => !$feeType->is_optional,
                        'is_active' => true,
                    ]);
                }
            }
        }
        
        $this->command->info('Class fees seeded successfully!');
    }
}