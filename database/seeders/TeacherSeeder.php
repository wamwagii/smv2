<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\Teacher;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        $schools = School::all();
        
        $firstNames = ['James', 'Mary', 'John', 'Patricia', 'Robert', 'Jennifer', 'Michael', 'Linda'];
        $lastNames = ['Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Garcia', 'Miller', 'Davis'];
        $qualifications = ['B.Ed', 'M.Ed', 'PhD', 'PGDE'];
        $specializations = ['Mathematics', 'English', 'Science', 'History', 'Physics', 'Chemistry', 'Biology'];
        
        foreach ($schools as $school) {
            for ($i = 1; $i <= 5; $i++) {
                $firstName = $firstNames[array_rand($firstNames)];
                $lastName = $lastNames[array_rand($lastNames)];
                
                Teacher::create([
                    'school_id' => $school->id,
                    'teacher_code' => 'TCH' . $school->id . str_pad($i, 2, '0', STR_PAD_LEFT),
                    'first_name' => $firstName,
                    'last_name' => $lastName,
                    'email' => strtolower($firstName . '.' . $lastName . '@' . str_replace(' ', '', $school->code) . '.sch.ke'),
                    'phone' => '+254' . rand(700000000, 799999999),
                    'date_of_birth' => now()->subYears(rand(25, 60)),
                    'gender' => rand(0, 1) ? 'male' : 'female',
                    'address' => rand(1, 999) . ' Staff Quarters',
                    'city' => $school->city,
                    'qualification' => $qualifications[array_rand($qualifications)],
                    'specialization' => $specializations[array_rand($specializations)],
                    'hire_date' => now()->subYears(rand(1, 15)),
                    'salary' => rand(30000, 150000),
                    'is_active' => true,
                ]);
            }
        }
        
        $this->command->info('Teachers seeded successfully!');
    }
}