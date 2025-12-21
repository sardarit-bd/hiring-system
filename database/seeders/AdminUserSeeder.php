<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@gamil.com',
            'password' => Hash::make('shimanto'),
            'role' => 'admin',
            'is_super_admin' => 1 ,
            'email_verified_at' => now(),
        ]);

        // Create sample employer
        User::create([
            'name' => 'Tech Solutions Inc.',
            'email' => 'employer@gmail.com',
            'password' => Hash::make('shimanto'),
            'role' => 'employer',
            'company_name' => 'Tech Solutions Inc.',
            'industry' => 'Information Technology',
            'website' => 'https://techsolutions.com',
            'phone' => '+12345678900',
            'email_verified_at' => now(),
        ]);

        // Create sample job seeker
        User::create([
            'name' => 'John Doe',
            'email' => 'john@gamil.com',
            'password' => Hash::make('shimanto'),
            'role' => 'job_seeker',
            'phone' => '+12345678901',
            'skills' => json_encode(['PHP', 'Laravel', 'MySQL', 'JavaScript']),
            'experience' => '5 years of web development experience',
            'education' => 'Bachelor of Computer Science',
            'email_verified_at' => now(),
        ]);
    }
}