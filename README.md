# LoveCaring 🧠

LoveCaring adalah sebuah platform aplikasi web yang dirancang untuk pendataan, manajemen, dan screening kesehatan mental mahasiswa. Aplikasi ini menghubungkan Mahasiswa dengan Dosen atau Tenaga Ahli melalui kuesioner dan materi edukasi.

## 🎯 Kegunaan Web
Aplikasi ini memfasilitasi mahasiswa dalam memantau kondisi kesehatan mental mereka melalui pengisian kuesioner secara berkala. Di sisi lain, aplikasi ini memberikan dashboard khusus bagi Dosen untuk memantau Daftar Mahasiswa, mengevaluasi riwayat *screening* (hasil kuesioner), serta memberikan saran (feedback) medis atau edukatif.

## ✨ Fitur Utama
1. **Multi-Role Authentication**: 
   - **Admin**, **Dosen (Lecturer)**, dan **Mahasiswa (Student)** dengan tampilan antarmuka (dashboard) yang disesuaikan dengan peran masing-masing.
   - Login mendukung verifikasi via WhatsApp/OTP.
2. **Kuesioner / Screening**: Mahasiswa dapat mengisi jawaban kuesioner terkait kondisi psikologis atau kesehatan mereka.
3. **Lecturer Dashboard & Daftar Mahasiswa**: Dosen dapat melihat riwayat pengisian kuesioner dari setiap mahasiswa bimbingannya dan memberikan tanggapan (*Lecturer advice*).
4. **Materi Edukasi**: Mahasiswa memiliki akses membaca berbagai materi dan artikel edukasi (*Educational Materials*).
5. **Autocompletion Form Integrasi API**: Pada saat form registrasi, input Perguruan Tinggi/Kampus sudah terintegrasi dengan API untuk autocompletion (pencarian instansi pendidikan secara otomatis).

## 🛠️ Tech Stack
Proyek ini dibangun menggunakan arsitektur modern berbasis PHP dan Node.JS dengan teknologi berikut:
- **Framework Backend**: [Laravel 12.x](https://laravel.com/) (PHP ^8.2)
- **Frontend / UI**: [Tailwind CSS 3.x](https://tailwindcss.com/), [Alpine.js](https://alpinejs.dev/), dan komponen Laravel Blade
- **Build Tool**: [Vite](https://vitejs.dev/)
- **Database**: SQLite (dapat dikonfigurasi menggunakan MySQL/PostgreSQL)
- **Libraries Tambahan**: Laravel Breeze (Autentikasi), Intervention Image, Axios, dll.

## � Cara Setup & Instalasi (Local Development)

Ikuti langkah-langkah berikut untuk menjalankan aplikasi LoveCaring secara lokal di komputer Anda:

1. **Clone Repository (Jika dari Git)**
   ```bash
   https://github.com/novalput/mindscans.git
   cd mindscans
   ```

2. **Install dependensi PHP via Composer**
   ```bash
   composer install
   ```

3. **Install dependensi Node.js / NPM**
   ```bash
   npm install
   ```

4. **Konfigurasi Environment**
   Salin file konfigurasi `.env`. (Command ini juga dapat berjalan secara otomatis setelah instalasi composer jika proyek baru dibuat dari scratch).
   ```bash
   cp .env.example .env
   ```
   Pastikan Anda mengatur konfigurasi database Anda di dalam file `.env` (misalnya DB_CONNECTION=sqlite untuk kemudahan awal).

5. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

6. **Migrasi Database dan Seeding**
   Jalankan perintah ini untuk melakukan migrasi pembentukan struktur tabel beserta mengisi data testing awal (*dummy data*).
   ```bash
   php artisan migrate:fresh --seed
   ```

7. **Jalankan Aplikasi**
   Untuk dapat membuka aplikasi, Anda perlu menjalankan build *frontend* (CSS & JS) secara simultan dengan local server Laravel.
   
   Buka terminal pertama dan jalankan Vite Server:
   ```bash
   npm run dev
   ```
   
   Buka terminal kedua dan jalankan PHP Server:
   ```bash
   php artisan serve
   ```

Aplikasi sekarang siap digunakan dan dapat diakses secara lokal pada tautan `http://localhost:8000`.

## 🗄️ Struktur Database Utama

Aplikasi LoveCaring menggunakan struktur relasional dengan tabel utama sebagai berikut:
- **`users`**: Tabel sentral autentikasi untuk semua role (admin, lecturer, student).
- **`Lecturer`**: Menyimpan rincian biodata dosen (gender, institusi kampus, program studi, status, dsb). Berelasi dengan tabel `users`.
- **`Student`**: Menyimpan rincian biodata mahasiswa (NIM, institusi kampus, jenjang akademik, prodi, dan status aktif). Berelasi dengan tabel `users`.
- **`questions`**: Bank pertanyaan *pre-test* / kuesioner.
- **`screening_responses`**: Riwayat transaksional jawaban kuesioner dari mahasiswa, tipe deteksi/gejala, lengkap dengan kolom `Lecturer_advice` (saran dosen).
- **`educational_materials`**: Entitas manajemen materi edukasi/artikel (judul, isi, slug).
- **`otp_requests`** & **`login_attempts`**: Tabel manajemen keamanan dan manajemen OTP Login.
- **`feedbacks`**: Tabel penyimpanan laporan saran dari sisi user.

## 🌱 Seeder (Data Master & Testing)
Agar memudahkan selama proses *development*, skrip berikut digunakan untuk menyiapkan sistem dari nol (dipanggil melalui `DatabaseSeeder.php`):
- **`UserSeeder`**: Membuat 3 akun login default.
  - **Dosen (Lecturer)** \
    Email: `slamet@mindscans.com` | Password: `password`
  - **Mahasiswa (Student)** \
    Email: `ahmad@mindscans.com` | Password: `password`
  - **Admin** \
    Email: `admin@mindscans.com` | Password: `password`
- **`QuestionSeeder`**: Manghasilkan serangkaian data bank pertanyaan awal.
- **`EducationalMaterialSeeder`**: Menyiapkan beberapa kerangka dummy konten edukasi.

## � Struktur Direktori Penting

- `app/` : Direktori sentral core logic aplikasi (Controllers, Models, Middleware). Model seperti abstrak `Student`, `Lecturer`, dan `Question` berada di dalam folder `app/Models/`.
- `config/` : Folder konfigurasi global tingkat tinggi layaknya *database engine*, *mail*, tipe session, dsb.
- `database/` :
  - `migrations/` : Kumpulan struktur versi tabel.
  - `seeders/` : Kumpulan kerangka data inisialisasi awal (*dummy data*).
- `public/` : Menampung *resource* yang secara publik diakses langsung tanpa lewat router, meliputi logik index, file unduhan, dan hasil *compiled assets* dari command `npm run build`.
- `resources/` :
  - `views/` : Memiliki susunan file Laravel Blade (`*.blade.php`) untuk antarmuka UI aplikasi layaknya tata letak HTML, dashboard admin dan form registrasi. Menampung komponen di folder `resources/views/components/`.
  - `css/ & js/` : Berkas pengembangan Tailwind dan Alpine.JS yang akan dikonversi (di-compile) oleh Engine Vite.
- `routes/` :
  - `web.php` : Deklarasi akses dan rute tampilan web utama per URL.
  - `api.php` : Jalur permintaan RESTful API eksternal dan lokal (misalnya request autocompletion cari kampus mahasiswa).