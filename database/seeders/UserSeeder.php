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
        // 1. Dosen (Responden) - Slamet Handoko
        $dosen1 = User::create([
            'name' => 'SLAMET HANDOKO',
            'email' => 'slamet@mindscans.com',
            'phone' => '628111111111',
            'password' => Hash::make('password'),
            'role' => 'responden',
            'sub_role' => 'lecturer',
            'whatsapp_verified' => true,
        ]);

        Biodata::create([
            'user_id' => $dosen1->id,
            'jenis_kelamin' => 'male',
            'nama_kampus' => 'Politeknik Negeri Semarang',
            'prodi' => 'Teknik Informatika',
            'status' => 'Aktif',
        ]);

        // 2. Mahasiswa (Responden) - Ahmad Muzakki
        $mhs1 = User::create([
            'name' => 'AHMAD MUZAKKI AHSAN',
            'email' => 'ahmad@mindscans.com',
            'phone' => '628222222222',
            'password' => Hash::make('password'),
            'role' => 'responden',
            'sub_role' => 'student',
            'whatsapp_verified' => false,
        ]);

        Biodata::create([
            'user_id' => $mhs1->id,
            'jenis_kelamin' => 'male',
            'nama_kampus' => 'Universitas Negeri Semarang',
            'prodi' => 'Teknik Informatika',
            'status' => 'Aktif',
        ]);

        // 3. Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@mindscans.com',
            'phone' => '628523456789',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 4. Dosen 2
        $dosen2 = User::create([
            'name' => 'Aji Purwinarko',
            'email' => 'aji@gmail.com',
            'phone' => '08333333333333',
            'password' => Hash::make('password'),
            'role' => 'responden',
            'sub_role' => 'lecturer',
            'whatsapp_verified' => false,
        ]);

        Biodata::create([
            'user_id' => $dosen2->id,
            'jenis_kelamin' => 'male',
            'nama_kampus' => 'Universitas Negeri Semarang',
            'prodi' => 'Teknik Informatika',
            'status' => 'Tugas Belajar',
        ]);

        // 5. Mahasiswa 2
        $mhs2 = User::create([
            'name' => 'Alif Najmi Raihan Putra Hidayat',
            'email' => 'raihan@gmail.com',
            'phone' => '0844444444444',
            'password' => Hash::make('password'),
            'role' => 'responden',
            'sub_role' => 'student',
            'whatsapp_verified' => false,
        ]);

        Biodata::create([
            'user_id' => $mhs2->id,
            'jenis_kelamin' => 'male',
            'nama_kampus' => 'Universitas Negeri Semarang',
            'prodi' => 'Teknik Informatika',
            'status' => 'Aktif',
        ]);
    }
}
