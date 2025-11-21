# Sistem HRD (Laravel)

Proyek ini adalah aplikasi **Sistem HRD** berbasis Laravel yang digunakan untuk mengelola data karyawan, absensi, shift, dan fitur-fitur lain terkait HR.

---

## 🚀 Fitur Utama
- **Manajemen Karyawan**
- **Manajemen Jabatan & Departemen**
- **Manajemen Shift**
- **Absensi Karyawan** (Check-in / Check-out)
- **Manajemen Cuti**
- **Penggajian dan Potongan**
- **User Role (Admin / HRD / Karyawan)**

---

## 📦 Teknologi yang Digunakan
- **Laravel 12 (12.37.0)**
- **MySQL**
- **Blade Template / SB Admin 2**
- **Bootstrap / Tailwind**
- **Vite**

---

## 🛠️ Cara Install Proyek
Ikuti langkah berikut untuk menjalankan aplikasi ini secara lokal.

### 1. Clone Repository
```
git clone https://github.com/Nurfildan/sistem-hrd.git
cd sistem-hrd
```

### 2. Install Dependencies
```
composer install
npm install
```

### 3. Buat File .env
```
cp .env.example .env
```

### 4. Generate Key
```
php artisan key:generate
```

### 5. Konfigurasi Database
Edit file `.env` sesuai dengan database lokal kamu:
```
DB_DATABASE=sistem_hrd
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Migrasi dan Seeder (opsional)
```
php artisan migrate --seed
```

### 7. Jalankan Server
```
php artisan serve
```
Aplikasi berjalan di:
```
http://127.0.0.1:8000
```

### 8. Jalankan Frontend (jika pakai Vite)
```
npm run dev
```

---

## 🔐 Akun Login Default (Jika ada seeder)
Jika kamu menggunakan seeder, isi bagian ini (opsional):
```
Akun Admin
Email: admin@gmail.com
Password: admin123

Akun HRD
Email: HRD@gmail.com
Password: HRD12345

Akun Karyawan
Email: karyawan@gmail.com
Password: karyawan
```

---

## 📁 Struktur Folder Penting
```
app/            -> Controller, Model, Middleware
resources/views -> Blade Templates
routes/web.php  -> Routing utama
public/         -> Asset publik
```

---

## 📄 Lisensi
Proyek ini bebas digunakan untuk keperluan pembelajaran dan pengembangan.

---

## 👤 Developer
**Muhammad Billal Nurfildan**

Jika ada pertanyaan terkait proyek ini, silakan hubungi atau buat issue di repository.
