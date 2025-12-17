<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class TestUsersSeeder extends Seeder
{
    public function run(): void
    {
        // Create default practice
        $practiceId = DB::table('practices')->insertGetId([
            'name' => 'NymoDental Demo Practice',
            'address' => '123 High Street',
            'city' => 'London',
            'state' => 'Greater London',
            'postal_code' => 'W1A 1AA',
            'country' => 'United Kingdom',
            'phone' => '+44 20 1234 5678',
            'email' => 'contact@nymodental.com',
            'timezone' => 'Europe/London',
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $users = [
            // Practice Owner
            [
                'name' => 'Practice Owner',
                'email' => 'owner@nymodental.com',
                'role_id' => 'ROLE_PRACTICE_OWNER',
            ],
            // Practice Admin
            [
                'name' => 'Admin User',
                'email' => 'admin@nymodental.com',
                'role_id' => 'ROLE_PRACTICE_ADMIN',
            ],
            // Practice Manager
            [
                'name' => 'Manager User',
                'email' => 'manager@nymodental.com',
                'role_id' => 'ROLE_PRACTICE_MANAGER',
            ],
            // Dentist
            [
                'name' => 'Dr. John Smith',
                'email' => 'dentist@nymodental.com',
                'role_id' => 'ROLE_DENTIST',
            ],
            // Hygienist
            [
                'name' => 'Jane Doe',
                'email' => 'hygienist@nymodental.com',
                'role_id' => 'ROLE_HYGIENIST',
            ],
            // Dental Assistant
            [
                'name' => 'Emily Brown',
                'email' => 'assistant@nymodental.com',
                'role_id' => 'ROLE_DENTAL_ASSISTANT',
            ],
            // Front Desk
            [
                'name' => 'Sarah Johnson',
                'email' => 'frontdesk@nymodental.com',
                'role_id' => 'ROLE_FRONT_DESK',
            ],
            // Billing Specialist
            [
                'name' => 'Mark Williams',
                'email' => 'billing@nymodental.com',
                'role_id' => 'ROLE_BILLING_SPECIALIST',
            ],
            // Insurance Coordinator
            [
                'name' => 'Lisa Davis',
                'email' => 'insurance@nymodental.com',
                'role_id' => 'ROLE_INSURANCE_COORDINATOR',
            ],
            // Lab Technician
            [
                'name' => 'Tech Lab',
                'email' => 'lab@nymodental.com',
                'role_id' => 'ROLE_LAB_TECHNICIAN',
            ],
            // Marketing Coordinator
            [
                'name' => 'Amy Marketing',
                'email' => 'marketing@nymodental.com',
                'role_id' => 'ROLE_MARKETING_COORDINATOR',
            ],
            // Patient
            [
                'name' => 'Michael Brown',
                'email' => 'patient@nymodental.com',
                'role_id' => 'ROLE_PATIENT',
            ],
            // Referring Provider
            [
                'name' => 'Dr. External Referrer',
                'email' => 'referrer@external.com',
                'role_id' => 'ROLE_REFERRING_PROVIDER',
            ],
        ];

        foreach ($users as $userData) {
            $userId = DB::table('users')->insertGetId([
                'practice_id' => $practiceId,
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => Hash::make('password'),
                'is_active' => true,
                'is_locked' => false,
                'failed_login_attempts' => 0,
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::table('user_roles')->insert([
                'user_id' => $userId,
                'role_id' => $userData['role_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
