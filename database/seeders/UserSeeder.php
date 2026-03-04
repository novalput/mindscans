<?php

namespace Database\Seeders;

use App\Models\Lecturer;
use App\Models\Student;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Buat User Dokter (Lecturer)
        $dokterUser = User::create([
            'name' => 'Drg. Lia',
            'email' => 'dokter@liasdent.com',
            'phone' => '628123456789',
            'password' => Hash::make('password'),
            'role' => 'lecturer',
            'whatsapp_verified' => true,
        ]);

        Lecturer::create([
            'user_id' => $dokterUser->id,
            'nip' => 'SIP-12345/2026',
            'education' => 'Perguruan Tinggi',
            'specialization' => 'Spesialis Periodonsia',
            'bio' => 'Dokter gigi berpengalaman.',
        ]);

        // 2. Buat User Pasien
        $pasienUser = User::create([
            'name' => 'Siti Aminah',
            'email' => 'siti@gmail.com',
            'phone' => '628987654321',
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);

        Student::create([
            'user_id' => $pasienUser->id,
            'nik' => '3201234567890001',
            'dob' => '1995-05-20',
            'gender' => 'female',
            'address' => 'Jl. Kebahagiaan No. 10',
            'education' => 'SMA',
            'trimester' => 'II',
            'pregnancy_week' => 20,
            'last_period_date' => '2025-12-01',
        ]);

        // 3. Buat User Admin
        $adminUser = User::create([
            'name' => 'Admin',
            'email' => 'admin@liasdent.com',
            'phone' => '628523456789',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
    }
}
