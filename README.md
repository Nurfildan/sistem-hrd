# 📌 Sistem HRD – Laravel Project

Sistem HRD ini adalah aplikasi berbasis **Laravel** yang digunakan untuk mengelola data karyawan, divisi, jabatan, shift, absensi, dan kebutuhan administrasi lainnya.  
Proyek ini dibuat untuk keperluan PKL/Portfolio dan dapat dijalankan di lingkungan lokal dengan mudah.

---

## 🚀 Fitur Utama
- Manajemen Data Karyawan  
- Manajemen Jabatan & Divisi  
- Pengaturan Shift  
- Sistem Absensi  
- Dashboard Ringkasan  
- Otentikasi User (Admin, HRD, Karyawan)  
- CRUD Berbagai Data  
- Sistem berbasis Laravel + Blade  

---

## 📂 Struktur Proyek
```
sistem-hrd/
│── app/
│── bootstrap/
│── config/
│── database/
│── file-sql/            ← berisi file SQL
│── public/
│── resources/
│── routes/
│── storage/
│── tests/
│── vendor/ (ignored)
│── .env (ignored)
│── composer.json
│── package.json
│── README.md
```

---

## ⚙️ Spesifikasi Minimum
- PHP 8+
- Composer terbaru
- MySQL / MariaDB
- Node.js (opsional untuk build asset)
- XAMPP / Laragon / Dev server lainnya

---

## 🧰 Cara Install & Menjalankan Proyek

### 1️⃣ Clone Repository
```
git clone https://github.com/Nurfildan/sistem-hrd.git
cd sistem-hrd
```

### 2️⃣ Install Dependencies
**Composer:**
```
composer install
```

**NPM (opsional):**
```
npm install
npm run build
```

---

## 🔧 3️⃣ Konfigurasi File .env
Buat file `.env` berdasarkan `.env.example`:

```
cp .env.example .env
```

Lalu sesuaikan konfigurasi database:

```
DB_DATABASE=sistem_hrd
DB_USERNAME=root
DB_PASSWORD=
```

Generate key Laravel:

```
php artisan key:generate
```

---

## 🛢️ 4️⃣ Import Database SQL

File SQL tersedia pada folder:

```
file-sql/sistem_hrd.sql
```

### Cara Import:
1. Buka **phpMyAdmin**
2. Buat database baru: `sistem_hrd`
3. Masuk ke tab **Import**
4. Pilih file `sistem_hrd.sql` dari folder `file-sql`
5. Klik **Go**

Database akan terisi tabel lengkap beserta data user, jabatan, dan divisi.

---

## 🔑 Login Default

Gunakan akun berikut untuk mencoba aplikasi:

### 👑 Admin
- **Email:** admin@gmail.com  
- **Password:** admin123

### 🧑‍💼 HRD
- **Email:** HRD@gmail.com  
- **Password:** HRD12345

### 👤 Karyawan
- **Email:** karyawan@gmail.com  
- **Password:** karyawan

---

## ▶️ 5️⃣ Jalankan Server Laravel
```
php artisan serve
```

Aplikasi dapat diakses pada:

```
http://localhost:8000
```

---

## 👥 Kolaborasi (untuk HRD/Teman kerja)
Gunakan langkah berikut untuk membuat branch baru:

```
git pull
git checkout -b fitur-baru
git add .
git commit -m "Tambah fitur baru"
git push origin fitur-baru
```

---

## 🛑 Gitignore (Ringkas)
Proyek ini sudah mengabaikan file sensitif dan file besar:

- `.env`
- `/vendor`
- `/node_modules`
- `/public/build`
- `/public/hot`
- `/public/storage`
- `/storage/logs`
- `/storage/framework/*`
- `/bootstrap/cache`
- File editor: `.vscode`, `.idea`
- File sistem: `.DS_Store`, `Thumbs.db`

---

## 👨‍💻 Developer
**Adly Febryan**  
**Muhammad Billal Nurfildan**  

