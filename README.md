# Kuesioner Kesehatan Mental

Aplikasi skrining mandiri kesehatan mental untuk mahasiswa dan sivitas akademika.  
Dibangun menggunakan Laravel + Vite + Tailwind CSS.

---

## 📌 Persyaratan Sistem

Pastikan sudah menginstall:

- PHP >= 8.1
- Composer
- Node.js & NPM
- MySQL / MariaDB
- Git

Cek versi:
```bash
php -v
composer -v
node -v
npm -v
git --version
```

---

## 🚀 Cara Install & Menjalankan Project

### 1️⃣ Clone Repository

```bash
git clone https://github.com/username/nama-repository.git
```

Masuk ke folder project:

```bash
cd nama-repository
```

---

### 2️⃣ Install Dependency PHP

```bash
composer install
```

---

### 3️⃣ Copy File Environment

```bash
cp .env.example .env
```

Jika di Windows:

```bash
copy .env.example .env
```

---

### 4️⃣ Generate App Key

```bash
php artisan key:generate
```

---

### 5️⃣ Atur Konfigurasi Database

Buka file `.env`, lalu sesuaikan:

```env
DB_CONNECTION=mysql
DB_DATABASE=nama_database
DB_USERNAME=root
DB_PASSWORD=
```

Buat database baru di phpMyAdmin / MySQL sesuai nama di atas.

---

### 6️⃣ Jalankan Migrasi Database

```bash
php artisan migrate
```

Jika ada seeder:

```bash
php artisan db:seed
```

Atau:

```bash
php artisan migrate --seed
```

---

### 7️⃣ Install Dependency Frontend

```bash
npm install
```

---

### 8️⃣ Jalankan Vite (Frontend)

```bash
npm run dev
```

---

### 9️⃣ Jalankan Server Laravel

Buka terminal baru, lalu jalankan:

```bash
php artisan serve
```

Akses di browser:

```
http://127.0.0.1:8000
```

---

## 🛠️ Perintah Penting

Clear cache jika ada error:

```bash
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
```

---

## 📦 Build untuk Production

```bash
npm run build
```

---

## 👨‍💻 Kontributor

- Nama Kamu

---

## 📄 Lisensi

Project ini dibuat untuk kebutuhan akademik.