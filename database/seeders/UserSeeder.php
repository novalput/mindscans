<?php

namespace Database\Seeders;

use App\Models\Biodata;
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
        // 1. Healthcare Professional (Respondent) - Maya Pratama
        $healthcareProfessional1 = User::create([
            'name' => 'Maya Pratama',
            'email' => 'maya.pratama@mindscans.test',
            'phone' => '628117654321',
            'password' => Hash::make('password'),
            'role' => 'responden',
            'sub_role' => 'lecturer',
            'whatsapp_verified' => true,
        ]);

        Biodata::create([
            'user_id' => $healthcareProfessional1->id,
            'jenis_kelamin' => 'male',
            'nama_kampus' => 'Universitas Kesehatan Nusantara',
            'prodi' => 'Keperawatan',
            'status' => 'Active',
        ]);

        // 2. Patient (Respondent) - Raka Wijaya
        $patient1 = User::create([
            'name' => 'Raka Wijaya',
            'email' => 'raka.wijaya@mindscans.test',
            'phone' => '628229876543',
            'password' => Hash::make('password'),
            'role' => 'responden',
            'sub_role' => 'student',
            'whatsapp_verified' => false,
        ]);

        Biodata::create([
            'user_id' => $patient1->id,
            'jenis_kelamin' => 'male',
            'nama_kampus' => 'Institut Teknologi Cendekia',
            'prodi' => 'Sistem Informasi',
            'status' => 'Active',
        ]);

        // 3. Admin
        User::create([
            'name' => 'MindScans Administrator',
            'email' => 'administrator@mindscans.test',
            'phone' => '628521234567',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 4. Healthcare Professional 2 - Dimas Saputra
        $healthcareProfessional2 = User::create([
            'name' => 'Dimas Saputra',
            'email' => 'dimas.saputra@mindscans.test',
            'phone' => '628133456789',
            'password' => Hash::make('password'),
            'role' => 'responden',
            'sub_role' => 'lecturer',
            'whatsapp_verified' => false,
        ]);

        Biodata::create([
            'user_id' => $healthcareProfessional2->id,
            'jenis_kelamin' => 'male',
            'nama_kampus' => 'Klinik Sehat Bersama',
            'prodi' => 'Psikologi Klinis',
            'status' => 'On Duty',
        ]);

        // 5. Patient 2 - Sinta Lestari
        $patient2 = User::create([
            'name' => 'Sinta Lestari',
            'email' => 'sinta.lestari@mindscans.test',
            'phone' => '628145678901',
            'password' => Hash::make('password'),
            'role' => 'responden',
            'sub_role' => 'student',
            'whatsapp_verified' => false,
        ]);

        Biodata::create([
            'user_id' => $patient2->id,
            'jenis_kelamin' => 'male',
            'nama_kampus' => 'Akademi Kesehatan Mandiri',
            'prodi' => 'Kesehatan Masyarakat',
            'status' => 'Active',
        ]);

        // 6. Other Respondent - Fajar Nugroho
        $others1 = User::create([
            'name' => 'Fajar Nugroho',
            'email' => 'fajar.nugroho@mindscans.test',
            'phone' => '628155678901',
            'password' => Hash::make('password'),
            'role' => 'responden',
            'sub_role' => 'others',
            'whatsapp_verified' => false,
        ]);

        Biodata::create([
            'user_id' => $others1->id,
            'jenis_kelamin' => 'male',
            'nama_kampus' => 'Pusat Layanan Sehat Harmoni',
            'status' => 'Active',
            'job_description' => 'Health Program Coordinator',
        ]);
    }
}
