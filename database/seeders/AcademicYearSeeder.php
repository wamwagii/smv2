<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\School;
use Illuminate\Database\Seeder;

class AcademicYearSeeder extends Seeder
{
    public function run(): void
    {
        $schools = School::all();
        $currentYear = date('Y');
        
        foreach ($schools as $school) {
            // Create academic years from 5 years ago to 2 years in the future
            for ($year = $currentYear - 5; $year <= $currentYear + 2; $year++) {
                $isCurrent = ($year == $currentYear);
                $nextYear = $year + 1;
                
                AcademicYear::create([
                    'school_id' => $school->id,
                    'name' => "{$year}-{$nextYear}",
                    'start_date' => "{$year}-01-01",
                    'end_date' => "{$year}-12-31",
                    'is_current' => $isCurrent,
                    'description' => $isCurrent 
                        ? "Current academic year {$year}-{$nextYear}"
                        : ($year < $currentYear 
                            ? "Past academic year {$year}-{$nextYear}"
                            : "Upcoming academic year {$year}-{$nextYear}"),
                ]);
            }
        }

        $this->command->info('Academic years seeded successfully!');
        $this->command->info('Created ' . (AcademicYear::count()) . ' academic years total');
    }
}