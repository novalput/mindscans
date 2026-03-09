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
        // 1. Buat User Dosen (Lecturer)
        $dokterUser = User::create([
            'name' => 'SLAMET HANDOKO',
            'email' => 'slamet@mindscans.com',
            'phone' => '628111111111',
            'password' => Hash::make('password'),
            'role' => 'lecturer',
            'whatsapp_verified' => true,
        ]);

        Lecturer::create([
            'user_id' => $dokterUser->id,
            'gender' => 'male',
            'kampus' => 'Politeknik Negeri Semarang',
            'program_studi' => 'Teknik Informatika',
            'jabatan_fungsional' => 'Lektor',
            'pendidikan_terakhir' => 'S2',
            'status_ikatan_kerja' => 'Dosen Tetap',
            'status_aktivitas' => 'Aktif',
        ]);

        // 2. Buat User Mahasiswa (Student)
        $pasienUser = User::create([
            'name' => 'AHMAD MUZAKKI AHSAN',
            'email' => 'ahmad@mindscans.com',
            'phone' => '628222222222',
            'password' => Hash::make('password'),
            'role' => 'student',
        ]);

        Student::create([
            'user_id' => $pasienUser->id,
            'nim' => '2304130079',
            'kampus' => 'Universitas Negeri Semarang',
            'jenjang' => 'Sarjana',
            'program_studi' => 'Teknik Informatika',
            'gender' => 'male',
            'status' => 'Aktif-2025/2026 Genap'
        ]);

        // 3. Buat User Admin
        $adminUser = User::create([
            'name' => 'Admin',
            'email' => 'admin@mindscans.com',
            'phone' => '628523456789',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);
    }
}
