# MindScans

**MindScans** adalah platform aplikasi web terintegrasi untuk pendataan, pemantauan (*monitoring*), dan skrining kesehatan mental pasien. Aplikasi ini menghubungkan pasien dengan tenaga kesehatan melalui kuesioner psikologis untuk depresi, kecemasan, dan dampak fungsional.

---

## 🎯 Kegunaan Aplikasi
Aplikasi ini membantu pasien memantau kondisi kesehatan mental melalui pengisian kuesioner secara berkala. Healthcare Professional dapat meninjau riwayat screening pasien dan memberikan saran tindak lanjut, sedangkan Admin mengelola pengguna, bank pertanyaan, dan seluruh riwayat pemeriksaan.

---

## ✨ Fitur Utama & Alur Kerja (Flow)

### 1. 🔑 Sistem Multi-Role & Hak Akses
Aplikasi ini menggunakan autentikasi berbasis peran (*role-based authorization*) untuk 3 jenis pengguna utama:

#### A. Patient (`student`)
*   **Dashboard**: Menampilkan ringkasan informasi dan akses cepat untuk mengisi screening.
*   **Mental Health Screening**: Mengisi kuesioner kesehatan mental secara berkala, maksimal sekali sehari. Kuesioner terdiri dari:
    *   **Kuesioner Depresi (16 pertanyaan)**: Terbagi ke dalam 4 subtipe (Depresi Emosional, Pikiran Negatif, Somatik, Menarik Diri).
    *   **Kuesioner Kecemasan/Ansietas (16 pertanyaan)**: Terbagi ke dalam 4 subtipe (Konflik Id & Ego, Konflik Ego & Superego, Ketakutan Ancaman Nyata, Respon Ego terhadap Kecemasan).
    *   **Dampak Fungsional (1 pertanyaan)**: Mengukur tingkat hambatan aktivitas akibat masalah psikologis.
*   **Riwayat & Grafik**: Melihat hasil screening sebelumnya dan grafik skor secara kronologis.
*   **Ekspor PDF**: Mengunduh riwayat screening mandiri dalam format PDF A4.
*   **Feedback**: Memberikan rating dan masukan atau kritik/saran mengenai sistem.
*   **Pengaturan Profil**: Mengelola biodata profil dan data akun login.

#### B. Healthcare Professional (`lecturer`)
*   **Dashboard**: Menyajikan statistik screening pasien, meliputi:
    *   Total screening yang telah diselesaikan pasien.
    *   Rata-rata skor kesehatan mental pasien.
    *   Jumlah pasien yang membutuhkan perhatian khusus berdasarkan ambang batas skor.
    *   Grafik bulanan total screening dan warning.
    *   Daftar lima pasien terakhir yang melakukan screening.
*   **Patient List**: Menampilkan pasien berdasarkan institusi healthcare professional dan mendukung:
    *   Pencarian nama pasien dan filter program studi.
    *   Ekspor daftar pasien ke format PDF.
    *   Tampilan serta ekspor riwayat screening pasien.
*   **Evaluasi & Intervensi**:
    *   Membandingkan hasil screening Pre-Test dan Post-Test pasien.
    *   **Saran & Tindak Lanjut**: Memberikan rekomendasi berdasarkan hasil screening pasien.
    *   **Cetak Laporan**: Mencetak laporan screening dan rekomendasi tindak lanjut.
*   **Lihat Feedback**: Membaca masukan dan rating dari pasien.
*   **Self-Screening**: Melakukan screening kesehatan mental untuk diri sendiri.

#### C. Admin (Administrator)
*   **Dashboard Admin**: Menampilkan metrik data statistik global aplikasi.
*   **Manage Healthcare Professionals**: Manajemen CRUD akun dan biodata healthcare professional.
*   **Manage Patients**: Manajemen CRUD akun dan biodata pasien.
*   **Riwayat Screening**: Memantau seluruh respons screening, melihat detail jawaban pasien, dan memperbarui catatan intervensi admin (*admin_intervention*).
*   **Kelola Pertanyaan (CMS)**: Manajemen data bank soal kuesioner (CRUD pertanyaan, mengedit teks, mengurutkan nomor soal, memetakan jenis/tipe kategori, dan opsi jawaban skala Likert).
*   **Self-Screening**: Melakukan tes kuesioner secara mandiri.

---

### 2. 🔌 Integrasi API & Keamanan Sistem
*   **PDDikti API Integration**: Form pendaftaran dan pengeditan profil terhubung dengan proxy API PDDikti untuk mencari nama institusi dan program studi secara otomatis.
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

*   **`users`**: Menyimpan kredensial autentikasi untuk semua role. Kolom `role` berisi `admin` atau `responden`, sedangkan `sub_role` berisi `student` atau `lecturer`.
*   **`biodatas`**: Relasi 1-to-1 dengan `users` untuk menyimpan profil pasien dan healthcare professional, termasuk jenis kelamin, tanggal lahir, alamat, institusi, program studi, status, dan pekerjaan.
*   **`questions`**: Bank data kuesioner yang menyimpan teks pertanyaan, tipe (`depression`, `anxiety`, `impact`), subtipe, urutan indeks, dan pilihan skala Likert terformat JSON.
*   **`screening_responses`**: Menyimpan respons screening pasien, skor, kategori interpretasi, detail jawaban JSON, dan saran intervensi.
*   **`feedbacks`**: Menyimpan masukan dan rating dari user responden.
*   **`otp_requests`** & **`login_attempts`**: Digunakan untuk keperluan verifikasi keamanan OTP WhatsApp.

---

## 🌱 Data Master & Akun Uji Coba (Seeders)
Untuk pengembangan lokal, jalankan seeder untuk membuat lima user, empat biodata, dan tiga screening response. Semua akun menggunakan password `password`.

*   **Admin Panel**
    *   Email: `administrator@mindscans.test`
*   **Healthcare Professional 1**
    *   Email: `maya.pratama@mindscans.test`
    *   Institusi: Universitas Kesehatan Nusantara
*   **Healthcare Professional 2**
    *   Email: `dimas.saputra@mindscans.test`
    *   Institusi: Klinik Sehat Bersama
*   **Patient 1**
    *   Email: `raka.wijaya@mindscans.test`
    *   Institusi: Institut Teknologi Cendekia
*   **Patient 2**
    *   Email: `sinta.lestari@mindscans.test`
    *   Institusi: Akademi Kesehatan Mandiri

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
    DB_DATABASE=mindscans
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