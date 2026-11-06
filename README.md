# 📚 Vocab API - RESTful API for English Vocabulary

Sebuah RESTful API yang dibangun menggunakan **Laravel 11** untuk mengelola kosakata Bahasa Inggris. Project ini dikembangkan sebagai wujud implementasi standar industri *Backend Development*, mencakup Autentikasi, Otorisasi, CRUD, *Exception Handling*, dan *Automated Testing*.

---

## Fitur Utama

* **Autentikasi Aman:** Sistem Register, Login, dan Logout menggunakan **Laravel Sanctum** (Bearer Token).
* **Manajemen Profil:** Fitur untuk melihat dan mengedit profil user dengan pengamanan *hashing* password otomatis.
* **CRUD Vocabulary:** Pengelolaan data kosakata (tambah, lihat, edit, hapus) yang terikat pada masing-masing user.
* **Otorisasi Data (RBAC):** Proteksi data super ketat yang memastikan user tidak dapat mengintip atau mengubah data milik user lain (dilengkapi dengan *custom exception* 403 Forbidden).
* **Validasi Ketat:** Memanfaatkan Laravel *Form Requests* untuk memastikan integritas dan validitas data sebelum masuk ke database.
* **Standar API Global:** Konfigurasi khusus pada `bootstrap/app.php` untuk menjamin semua respon *error* (401, 403, 404, 500) dikembalikan dalam format **JSON**, bukan halaman HTML.
* **100% Test Coverage:** Dilengkapi dengan *Feature Tests* komprehensif menggunakan PHPUnit untuk menguji fungsionalitas dan celah keamanan.

---

## Teknologi & Tools (Tech Stack)

* **Framework:** Laravel 11
* **Language:** PHP 8.2
* **Database:** MySQL
* **Authentication:** Laravel Sanctum
* **Testing Framework:** PHPUnit
* **API Documentation:** OpenAPI 3.0.3 (Swagger)

---

## Cara Menjalankan Project Secara Lokal

Ikuti langkah-langkah berikut untuk memasang project ini di komputer lokal Anda:

### 1. Clone Repository
```bash
git clone https://github.com/HanifRoi/vocab-api.git
cd vocab-api
```

### 2. Install Dependensi PHP
```bash
composer install
```

### 3. Setup Environment File
Salin file `.env.example` menjadi `.env`:
```bash
cp .env.example .env
```
Buka file `.env` yang baru dibuat, lalu sesuaikan konfigurasi database Anda:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nama_database_kamu
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Jalankan Database Migration
```bash
php artisan migrate
```

### 6. Jalankan Local Server
```bash
php artisan serve
```
Aplikasi sekarang dapat diakses melalui URL: `http://127.0.0.1:8000`

---

## Menjalankan Automated Testing

Untuk membuktikan bahwa seluruh fitur, validasi, dan lapisan keamanan berjalan dengan baik tanpa *bug*, jalankan perintah:

```bash
php artisan test
```

---

## Dokumentasi API

Seluruh kontrak API (endpoint, request body, query parameters, dan skema response) terdokumentasi dengan rapi menggunakan standar **OpenAPI 3.0.3**. 

Anda dapat melihat spesifikasi lengkapnya pada file:
`docs/user-api.yaml`
`docs/vocab-api.yaml`

Dikembangkan Oleh
**Hanif Roihan** 