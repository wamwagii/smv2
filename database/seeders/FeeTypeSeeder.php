<?php

namespace Database\Seeders;

use App\Models\FeeType;
use Illuminate\Database\Seeder;

class FeeTypeSeeder extends Seeder
{
    public function run(): void
    {
        $feeTypes = [
            ['name' => 'Tuition Fee', 'code' => 'TUITION', 'is_optional' => false, 'sort_order' => 1],
            ['name' => 'Activity Fee', 'code' => 'ACTIVITY', 'is_optional' => false, 'sort_order' => 2],
            ['name' => 'Lunch Fee', 'code' => 'LUNCH', 'is_optional' => false, 'sort_order' => 3],
            ['name' => 'Transport Fee', 'code' => 'TRANSPORT', 'is_optional' => true, 'sort_order' => 4],
            ['name' => 'Tours & Trips', 'code' => 'TOURS', 'is_optional' => true, 'sort_order' => 5],
            ['name' => 'Library Fee', 'code' => 'LIBRARY', 'is_optional' => false, 'sort_order' => 6],
            ['name' => 'Sports Fee', 'code' => 'SPORTS', 'is_optional' => false, 'sort_order' => 7],
            ['name' => 'ICT Fee', 'code' => 'ICT', 'is_optional' => false, 'sort_order' => 8],
            ['name' => 'Medical Fee', 'code' => 'MEDICAL', 'is_optional' => false, 'sort_order' => 9],
        ];
        
        foreach ($feeTypes as $feeType) {
            FeeType::create($feeType);
        }
        
        $this->command->info('Fee types seeded successfully!');
    }
}