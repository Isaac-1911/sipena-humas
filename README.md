# SIPENA HUMAS

**Sistem Pencatatan dan Arsip HUMAS POLRES Jember**

---

## Overview

SIPENA HUMAS adalah aplikasi berbasis web yang dirancang untuk mendukung pengelolaan informasi dan dokumentasi kegiatan HUMAS POLRES Jember. Sistem ini memungkinkan publik untuk mengakses informasi secara terbuka, serta menyediakan panel admin bagi internal HUMAS untuk mengelola konten secara terstruktur.

Aplikasi ini mengadopsi pendekatan sederhana namun scalable, dengan pemisahan yang jelas antara akses publik (read-only) dan akses admin (CRUD).

---

## Key Features

### Public Access (Tanpa Login)

* Menampilkan profil HUMAS
* Menampilkan daftar dan detail berita kegiatan
* Menampilkan arsip dokumentasi (foto, video, dokumen)
* Menyediakan informasi layanan publik
* Menampilkan informasi kontak
* Form pengiriman pesan dari masyarakat

### Admin Panel (Login Required)

* Manajemen berita (CRUD)
* Manajemen arsip dokumentasi (CRUD)
* Manajemen layanan publik (CRUD)
* Manajemen profil HUMAS
* Manajemen informasi kontak
* Melihat dan mengelola pesan masuk

---

## System Architecture

Sistem terdiri dari dua bagian utama:

* **Public Interface**

  * Akses tanpa autentikasi
  * Fokus pada penyajian informasi

* **Admin Interface**

  * Akses terbatas (login)
  * Digunakan untuk pengelolaan konten

---

## Technology Stack

* **Backend**: Laravel
* **Database**: MariaDB
* **Web Server**: Apache
* **Frontend**: Blade (Laravel Templating Engine)

---

## Database Overview

Struktur database dirancang sederhana dan modular, dengan entitas utama:

* `users` → Admin HUMAS
* `profiles` → Profil HUMAS (singleton)
* `news` → Berita kegiatan
* `archives` → Dokumentasi
* `services` → Layanan publik
* `contacts` → Informasi kontak
* `messages` → Pesan dari masyarakat

Relasi utama:

* `users` → `news` (one-to-many)

---

## Installation

### 1. Clone Repository

```bash
git clone https://github.com/your-username/sipena-humas.git
cd sipena-humas
```

### 2. Install Dependencies

```bash
composer install
```

### 3. Setup Environment

```bash
cp .env.example .env
php artisan key:generate
```

### 4. Configure Database

Edit file `.env`:

```env
DB_DATABASE=sipena_humas
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Run Migration

```bash
php artisan migrate
```

### 6. Storage Link

```bash
php artisan storage:link
```

### 7. Run Application

```bash
php artisan serve
```

---

## Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   └── Public/
│   └── Requests/
resources/
├── views/
│   ├── admin/
│   └── public/
routes/
├── web.php
database/
├── migrations/
```

---

## Security Considerations

* CSRF protection enabled by default
* Input validation using Laravel Form Request
* File upload restrictions (type & size)
* Separation of public and admin routes
* Authentication required for all admin features

---

## Development Notes

* Gunakan pendekatan modular untuk setiap fitur
* Hindari mencampur logic public dan admin
* Gunakan slug untuk URL berita
* Pastikan semua input tervalidasi dengan baik
* Gunakan storage Laravel untuk file handling

---

## Future Improvements

* Kategori berita dan arsip
* Fitur pencarian dan filter
* Dashboard statistik admin
* Sistem notifikasi pesan masuk
* Optimasi SEO dan performa

---

## License

This project is developed for internal use within HUMAS POLRES Jember.

---

## Author

Developed by Muhammad Anwar Thoriq

