## Deskripsi Project
Aplikasi ini merupakan Customer Relationship Management (CRM) berbasis web yang dibuat untuk membantu PT. Smart, perusahaan Internet Service Provider (ISP), khususnya divisi sales dalam mengelola data calon customer, layanan internet, dan proses penjualan secara terstruktur.

Aplikasi ini berfokus pada proses pengelolaan lead hingga menjadi customer aktif melalui mekanisme approval oleh manager, sebagai upaya mendukung digitalisasi proses kerja (paperless).

---

## Tujuan Pembuatan Aplikasi
Tujuan dari pembuatan aplikasi ini adalah:
1. Membantu sales dalam mencatat dan mengelola data calon customer (lead)
2. Menyediakan master data layanan internet yang ditawarkan perusahaan
3. Memfasilitasi proses konversi lead menjadi customer melalui fitur project
4. Menyediakan mekanisme approval oleh manager
5. Menyimpan data customer yang sudah berlangganan beserta layanan yang digunakan

---

## Ruang Lingkup Aplikasi
Aplikasi ini digunakan secara internal dan hanya mencakup:
-pengelolaan data
-alur kerja sales
-approval manager

---

## Pengguna Sistem (User)
Dalam aplikasi ini terdapat dua jenis pengguna:
1. Sales
Mengelola data lead dan membuat project untuk memproses calon customer.
2. Manager
Melakukan approval atau penolakan terhadap project yang diajukan sales.

Catatan:
Customer tidak memiliki akun atau akses ke sistem. Aplikasi ini digunakan secara internal oleh perusahaan.

---

## Asumsi Sistem
-Aplikasi bersifat internal dan memerlukan login
-Lead diinput oleh sales berdasarkan komunikasi dengan calon customer
-Project merupakan proses pengajuan lead menjadi customer
-Setiap project harus melalui approval manager
-Customer adalah lead yang telah disetujui dan dapat memiliki satu atau lebih layanan

---

## Gambaran Alur Aplikasi (Ringkas)
1. Sales login ke system
2. Sales menginput data calon customer (lead)
3. Sales membuat project dari lead dan memilih layanan
4. Manager melakukan approval project
5. Jika disetujui, lead berubah menjadi customer aktif

---

### Flow Aplikasi CRM PT.Smart
Start
↓
Login
↓
Dashboard
↓
Kelola Lead
(Kelola data calon customer)
↓
Buat Project
(Proses pengajuan lead menjadi customer)
↓
Approve Project?
↙                    ↘
Reject               Approve
↓                    ↓
Project Rejected   Customer Aktif
↓                    ↓
End		    End

---

## Teknologi yang Digunakan

- **Framework** : Laravel 11.x  
- **PHP** : 8.2.x  
- **Database** : PostgreSQL 14  
- **Authentication** : Session-based (Laravel Web Guard)  
- **Frontend (planned)** : Blade + Bootstrap  
- **Deployment Target** : Production-ready (internal application)

---

## Authentication & Role Authorization

Aplikasi CRM PT Smart menggunakan session-based authentication
dengan role-based authorization (Sales & Manager).

### Role Middleware
- Middleware: `role`
- Registered in: `bootstrap/app.php`
- Implementation: `App\Http\Middleware\RoleMiddleware`

### Akun Awal (Default User)
1. Manager:
email: manager@ptsmart.test
password: password123

2. Sales:
email: sales@ptsmart.test
password: password123

---

## Role & Hak Akses

### Sales
- Login ke sistem
- CRUD Lead (hanya lead milik sendiri)
- Mengajukan Project dari Lead
- Tidak dapat approve / reject project
- Tidak dapat membuat user

### Manager
- Login ke sistem
- Melihat daftar project berstatus `pending`
- Approve / Reject project
- Membuat akun user (sales / manager)
- Tidak memiliki akses ke lead

---

## Cara Menjalankan Project (Local / Server Baru)

Panduan ini digunakan untuk menjalankan project di **device atau server baru**.

### Clone Repository
git clone https://github.com/Firza155/Firza_crm-pt-smart.git 
cd crm-pt-smart

### Install Dependency
composer install

### Konfigurasi Environment
Salin file .env.example menjadi .env:

cp .env.example .env

### Konfigurasi Database (PostgreSQL)
1. Buat database baru:
CREATE DATABASE crm_pt_smart;

2. Sesuaikan konfigurasi database di .env:
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=crm_pt_smart
DB_USERNAME=postgres
DB_PASSWORD=your_password

### Generate Application Key
php artisan key:generate

### Jalankan Migration & Seeder
php artisan migrate --seed
- Seeder ini akan membuat akun default (lihat bagian Akun Awal).

### Jalankan Server
php artisan serve

---

## Authentication Notes
- Menggunakan session-based authentication
- CSRF aktif
- Login dilakukan melalui browser
- Endpoint backend diuji menggunakan session cookie aktif

---

## Log Pengerjaan

### Hari 1 (20 januari 2026)
- 16.00 – 22.00: memahami alur tugas
- istirahat sholat magrib dan isya 

### Hari 2 (21 januari 2026)
- 09.00 – 12.00: membuat flowchart dan erd
- 12.30 - 15.00: istirahat
- 15.00 - 17.30: setup project
- 17.30 - 19.30: istirahat
- 20.00 - 00.00: lanjut mengerjakan

### Hari 3 (22 januari 2026)
- 08.00 - 12.30: mengerjakan backend 
- 12.30 - 13.00: sholat 
- 13.30 - 16.00: lanjut mengerjakan
- 16.00 - 19.30: istirahat
- 19.30 - 00.00: lanjut backend dan frontend

### Hari 4 (23 januari 2026)
- 08.00 - 11.00: mengerjakan frontend
- 11.00 - 13.00: sholat dan istirahat
- 13.00 - 15.00: lanjut mengerjakan

---