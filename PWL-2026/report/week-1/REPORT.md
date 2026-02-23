## Praktikum 1 - Inisialisasi Project Laravel

### 1. Membuat Project Laravel Baru

Project Laravel dibuat menggunakan Composer dengan perintah:
```bash
composer create-project laravel/laravel pwl-laravel
```

**Penjelasan:**
- Composer akan mendownload Laravel versi terbaru beserta semua dependensinya
- Nama project: `pwl-laravel`
- Struktur folder Laravel otomatis ter-generate dengan lengkap

### 2. Menjalankan Development Server

Laravel dapat dijalankan menggunakan built-in server:
```bash
cd pwl-laravel
php artisan serve
```

Server akan berjalan di `http://localhost:8000`

**Struktur Project Laravel:**
- `app/` - Berisi logika aplikasi (Models, Controllers)
- `routes/` - Berisi definisi routing
- `resources/views/` - Berisi file Blade template
- `public/` - Directory public untuk assets
- `config/` - File konfigurasi aplikasi
- `database/` - Migrations, seeders, dan factories

### 3. Modifikasi Welcome Page

File `resources/views/welcome.blade.php` adalah halaman default Laravel. File ini dapat dimodifikasi sesuai kebutuhan untuk menampilkan konten custom.
