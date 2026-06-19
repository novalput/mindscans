# 🧠 LoveCaring-Rr.Nursing

**LoveCaring-Rr.Nursing** adalah platform aplikasi web terintegrasi yang dirancang untuk pendataan, pemantauan (*monitoring*), dan skrining kesehatan mental mahasiswa. Aplikasi ini menghubungkan Mahasiswa dengan Dosen/Tenaga Medis melalui kuesioner psikologis (Depresi & Ansietas/Kecemasan).

---

## 🎯 Kegunaan Aplikasi
Aplikasi ini memfasilitasi mahasiswa dalam memantau kondisi kesehatan mental mereka melalui pengisian kuesioner secara berkala. Di sisi lain, aplikasi ini memberikan dashboard khusus bagi Dosen (Lecturer) untuk mengevaluasi riwayat skrining mahasiswa bimbingannya serta memberikan saran/intervensi edukatif secara profesional. Admin memiliki kontrol penuh terhadap manajemen pengguna, bank pertanyaan kuesioner, dan riwayat keseluruhan tes.

---

## ✨ Fitur Utama & Alur Kerja (Flow)

### 1. 🔑 Sistem Multi-Role & Hak Akses
Aplikasi ini dirancang dengan autentikasi berbasis peran (*role-based authorization*) yang disesuaikan untuk 3 aktor utama:

#### A. Mahasiswa (Student) & Umum (Others)
*   **Dashboard**: Menampilkan ringkasan informasi dan akses cepat untuk melakukan pengisian kuesioner evaluasi.
*   **Mental Health Screening**: Mengisi kuesioner kesehatan mental secara berkala (maksimal sekali dalam sehari). Kuesioner terdiri dari:
    *   **Kuesioner Depresi (16 pertanyaan)**: Terbagi ke dalam 4 subtipe (Depresi Emosional, Pikiran Negatif, Somatik, Menarik Diri).
    *   **Kuesioner Kecemasan/Ansietas (16 pertanyaan)**: Terbagi ke dalam 4 subtipe (Konflik Id & Ego, Konflik Ego & Superego, Ketakutan Ancaman Nyata, Respon Ego terhadap Kecemasan).
    *   **Dampak Fungsional (1 pertanyaan)**: Mengukur tingkat hambatan aktivitas akibat masalah psikologis.
*   **Riwayat & Grafik**: Melihat rekam jejak hasil tes sebelumnya beserta grafik skor secara kronologis untuk memantau tren kesehatan mental.
*   **Ekspor PDF**: Mengunduh riwayat skrining mandiri dalam berkas PDF standar A4.
*   **Feedback**: Memberikan rating dan masukan atau kritik/saran mengenai sistem.
*   **Pengaturan Profil**: Mengelola biodata profil dan data akun login.

#### B. Dosen (Lecturer / Tenaga Medis)
*   **Dashboard**: Menyajikan statistik bimbingan pada instansi kampus yang sama, meliputi:
    *   Total kuesioner yang telah diisi oleh mahasiswa bimbingan.
    *   Rata-rata skor kesehatan mental mahasiswa.
    *   Jumlah mahasiswa bimbingan yang membutuhkan perhatian khusus (*Warning Count* berdasarkan ambang batas skor dinamis).
    *   Grafik bulanan (Total Kuesioner vs Total Warning).
    *   Daftar 5 mahasiswa terakhir yang melakukan tes skrining.
*   **Daftar Mahasiswa Bimbingan**: Melihat data mahasiswa yang berada di bawah kampus/instansi yang sama dengan dosen tersebut (terfilter otomatis berdasarkan kampus dosen). Mendukung:
    *   Pencarian nama mahasiswa dan filter berdasarkan Program Studi (Prodi).
    *   Ekspor daftar mahasiswa bimbingan ke format PDF.
    *   Melihat riwayat lengkap pengisian kuesioner mahasiswa tertentu dan mengekspornya ke PDF.
*   **Evaluasi & Intervensi**:
    *   Membandingkan hasil kuesioner Pre-Test dan Post-Test mahasiswa.
    *   **Saran & Tindak Lanjut**: Memberikan rekomendasi atau catatan saran intervensi berdasarkan hasil kuesioner mahasiswa.
    *   **Cetak Laporan**: Mencetak lembar laporan hasil kuesioner mental health mahasiswa (Pre-Test, Post-Test, dan rekomendasi/saran dari Dosen).
*   **Lihat Feedback**: Membaca saran-saran masukan dan rating yang dikirimkan mahasiswa.
*   **Self-Screening**: Melakukan tes kesehatan mental untuk diri sendiri.

#### C. Admin (Administrator)
*   **Dashboard Admin**: Menampilkan metrik data statistik global aplikasi.
*   **Kelola Dosen**: Manajemen data CRUD (Create, Read, Update, Delete) akun dan biodata dosen.
*   **Kelola Mahasiswa**: Manajemen data CRUD akun dan biodata mahasiswa.
*   **Riwayat Kuesioner**: Memantau semua data respons kuesioner di sistem, melihat detail jawaban mahasiswa, serta memperbarui/mengubah catatan intervensi admin (*admin_intervention*).
*   **Kelola Pertanyaan (CMS)**: Manajemen data bank soal kuesioner (CRUD pertanyaan, mengedit teks, mengurutkan nomor soal, memetakan jenis/tipe kategori, dan opsi jawaban skala Likert).
*   **Self-Screening**: Melakukan tes kuesioner secara mandiri.

---

### 2. 🔌 Integrasi API & Keamanan Sistem
*   **PDDikti API Integration**: Form pendaftaran mahasiswa/dosen dan pengeditan profil terhubung dengan proxy API PDDikti untuk mencari dan mengautodefinisikan nama kampus serta prodi secara otomatis.
*   **WhatsApp OTP Gateway**: Mendukung integrasi dengan Fonnte API untuk pengiriman pesan kredensial akun dan verifikasi autentikasi OTP (One Time Password) via WhatsApp.

---

## 🛠️ Tech Stack
*   **Framework Backend**: [Laravel 12.x](https://laravel.com/) (PHP ^8.2)
*   **Frontend**: [Tailwind CSS 3.x](https://tailwindcss.com/) & [Alpine.js](https://alpinejs.dev/) terintegrasi dengan Laravel Blade
*   **Build Tool**: [Vite](https://vitejs.dev/)
*   **Database**: MySQL / SQLite (Kompatibel dengan PostgreSQL)
*   **Ekspor Dokumen**: [DomPDF](https://github.com/barryvdh/laravel-dompdf) (Konversi HTML ke berkas PDF secara server-side)
*   **WhatsApp Engine**: Fonnte API Gateway (Proxy Endpoint)

---

## 🗄️ Struktur Database Utama
Struktur relasi database dirancang efisien dan tersentralisasi sebagai berikut:

*   **`users`**: Menyimpan kredensial autentikasi dasar untuk semua role (admin, responden). Memiliki kolom `role` (`admin`, `responden`), `sub_role` (`student`, `lecturer`, `others`), nomor handphone, link avatar, verifikasi WA, dan log login terakhir.
*   **`biodatas`**: Tabel sentral yang berelasi 1-to-1 dengan tabel `users` untuk menyimpan detail profil fisik/akademik baik untuk Mahasiswa maupun Dosen (jenis kelamin, tanggal lahir/ttl, alamat asal, nama kampus, prodi, status aktif, dan deskripsi pekerjaan).
*   **`questions`**: Bank data kuesioner yang menyimpan teks pertanyaan, tipe (`depression`, `anxiety`, `impact`), subtipe, urutan indeks, dan pilihan skala Likert terformat JSON.
*   **`screening_responses`**: Menyimpan data jawaban kuesioner mahasiswa (skor, kategori interpretasi hasil, rincian jawaban detail bertipe JSON, saran intervensi admin/dosen).
*   **`feedbacks`**: Tabel penyimpanan laporan saran dari sisi user responden.
*   **`otp_requests`** & **`login_attempts`**: Digunakan untuk keperluan verifikasi keamanan OTP WhatsApp.

---

## 🌱 Data Master & Akun Uji Coba (Seeders)
Untuk memudahkan masa pengembangan, jalankan seeder untuk membuat akun login pengujian default berikut:

*   **Admin Panel**
    *   Email: `admin@mindscans.com`
    *   Password: `password`
*   **Dosen (Lecturer) 1**
    *   Email: `slamet@mindscans.com`
    *   Password: `password`
    *   Institusi Kampus: Politeknik Negeri Semarang
*   **Dosen (Lecturer) 2**
    *   Email: `aji@gmail.com`
    *   Password: `password`
    *   Institusi Kampus: Universitas Negeri Semarang
*   **Mahasiswa (Student) 1**
    *   Email: `ahmad@mindscans.com`
    *   Password: `password`
    *   Institusi Kampus: Universitas Negeri Semarang
*   **Mahasiswa (Student) 2**
    *   Email: `raihan@gmail.com`
    *   Password: `password`
    *   Institusi Kampus: Universitas Negeri Semarang
*   **Umum (Others) 1**
    *   Email: `bayu@gmail.com`
    *   Password: `password`
    *   Institusi Kampus: Universitas Negeri Semarang

---

## ⚙️ Cara Setup & Instalasi (Local Development)

Ikuti langkah-langkah di bawah ini untuk menjalankan aplikasi secara lokal:

1.  **Clone Repository**
    ```bash
    git clone https://github.com/novalput/mindscans.git
    cd mindscans
    ```

2.  **Instalasi Dependensi PHP**
    ```bash
    composer install
    ```

3.  **Instalasi Dependensi Node.js**
    ```bash
    npm install
    ```

4.  **Konfigurasi Environment**
    Salin file `.env.example` menjadi `.env`:
    ```bash
    cp .env.example .env
    ```
    Buka file `.env` tersebut dan atur konfigurasi database Anda (contohnya MySQL):
    ```env
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=lovecaring
    DB_USERNAME=root
    DB_PASSWORD=
    ```

5.  **Generate Application Key**
    ```bash
    php artisan key:generate
    ```

6.  **Migrasi Database & Seeding**
    Jalankan perintah berikut untuk membuat struktur tabel dan mengisi data master awal:
    ```bash
    php artisan migrate:fresh --seed
    ```

7.  **Jalankan Build Assets & Web Server**
    Jalankan compiler Vite di terminal pertama:
    ```bash
    npm run dev
    ```
    Jalankan server lokal Laravel di terminal kedua:
    ```bash
    php artisan serve
    ```

Aplikasi dapat langsung diakses melalui peramban web pada tautan: `http://localhost:8000`.