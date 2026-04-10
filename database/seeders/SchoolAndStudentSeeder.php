<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\Student;
use Illuminate\Database\Seeder;

class SchoolAndStudentSeeder extends Seeder
{
    public function run(): void
    {
        // Create 3 schools
        $schools = [
            [
                'name' => 'Nairobi International School',
                'code' => 'NIS001',
                'email' => 'info@nairobiinternational.sch.ke',
                'phone' => '+254 20 1234567',
                'address' => '123 Argwings Kodhek Road',
                'city' => 'Nairobi',
                'state' => 'Nairobi County',
                'postal_code' => '00100',
                'country' => 'Kenya',
                'principal_name' => 'Dr. Sarah Johnson',
                'website' => 'https://nairobiinternational.sch.ke',
                'is_active' => true,
            ],
            [
                'name' => 'Mombasa Academy',
                'code' => 'MBS002',
                'email' => 'admin@mombasaacademy.ac.ke',
                'phone' => '+254 41 2345678',
                'address' => '456 Mama Ngina Drive',
                'city' => 'Mombasa',
                'state' => 'Mombasa County',
                'postal_code' => '80100',
                'country' => 'Kenya',
                'principal_name' => 'Mr. James Otieno',
                'website' => 'https://mombasaacademy.ac.ke',
                'is_active' => true,
            ],
            [
                'name' => 'Kisumu Preparatory School',
                'code' => 'KSM003',
                'email' => 'contact@kisumuprep.sch.ke',
                'phone' => '+254 57 3456789',
                'address' => '789 Oginga Odinga Road',
                'city' => 'Kisumu',
                'state' => 'Kisumu County',
                'postal_code' => '40100',
                'country' => 'Kenya',
                'principal_name' => 'Ms. Mary Wanjiku',
                'website' => 'https://kisumuprep.sch.ke',
                'is_active' => true,
            ],
        ];

        foreach ($schools as $schoolData) {
            School::create($schoolData);
        }

        // Get all school IDs
        $schoolIds = School::pluck('id')->toArray();

        // First names and last names for variety
        $firstNames = [
            'James', 'Mary', 'John', 'Patricia', 'Robert', 'Jennifer', 'Michael', 'Linda', 
            'William', 'Elizabeth', 'David', 'Susan', 'Joseph', 'Jessica', 'Charles', 'Sarah',
            'Thomas', 'Karen', 'Christopher', 'Nancy', 'Daniel', 'Lisa', 'Paul', 'Margaret',
            'Mark', 'Sandra', 'Donald', 'Ashley', 'George', 'Kimberly', 'Kenneth', 'Emily',
            'Steven', 'Donna', 'Edward', 'Michelle', 'Brian', 'Carol', 'Ronald', 'Amanda'
        ];

        $lastNames = [
            'Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Garcia', 'Miller', 'Davis',
            'Rodriguez', 'Martinez', 'Hernandez', 'Lopez', 'Gonzalez', 'Wilson', 'Anderson',
            'Thomas', 'Taylor', 'Moore', 'Jackson', 'Martin', 'Lee', 'Perez', 'Thompson',
            'White', 'Harris', 'Sanchez', 'Clark', 'Ramirez', 'Lewis', 'Robinson', 'Walker',
            'Young', 'Allen', 'King', 'Wright', 'Scott', 'Torres', 'Nguyen', 'Hill', 'Flores'
        ];

        $genders = ['male', 'female', 'other'];
        $cities = ['Nairobi', 'Mombasa', 'Kisumu', 'Nakuru', 'Eldoret', 'Thika', 'Malindi', 'Kitale'];

        // Create 40 students
        for ($i = 1; $i <= 40; $i++) {
            $firstName = $firstNames[array_rand($firstNames)];
            $lastName = $lastNames[array_rand($lastNames)];
            $schoolId = $schoolIds[array_rand($schoolIds)];
            
            // Generate admission number (e.g., STU2024001)
            $admissionNumber = 'STU' . date('Y') . str_pad($i, 3, '0', STR_PAD_LEFT);
            
            // Random date of birth (between 10-18 years ago)
            $dateOfBirth = now()->subYears(rand(10, 18))->subDays(rand(0, 365));
            
            // Random enrollment date (within last 3 years)
            $enrollmentDate = now()->subYears(rand(0, 3))->subDays(rand(0, 365));
            
            Student::create([
                'school_id' => $schoolId,
                'admission_number' => $admissionNumber,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => strtolower($firstName . '.' . $lastName . $i . '@example.com'),
                'phone' => '+254' . rand(700000000, 799999999),
                'date_of_birth' => $dateOfBirth,
                'gender' => $genders[array_rand($genders)],
                'address' => rand(1, 999) . ' ' . ['Main St', 'Kenya Ave', 'Independence Rd', 'Moi Ave'][array_rand(['Main St', 'Kenya Ave', 'Independence Rd', 'Moi Ave'])],
                'city' => $cities[array_rand($cities)],
                'enrollment_date' => $enrollmentDate,
                'parent_name' => 'Parent of ' . $firstName,
                'parent_phone' => '+254' . rand(700000000, 799999999),
                'parent_email' => 'parent.' . strtolower($firstName . '.' . $lastName) . '@example.com',
                'is_active' => rand(0, 1) ? true : false,
                'medical_notes' => rand(0, 3) === 0 ? 'Allergic to peanuts' . (rand(0, 1) ? ' and dust' : '') : null,
            ]);
        }

        $this->command->info('3 schools and 40 students created successfully!');
    }
}