# Laporan Tugas Jobsheet 7.1 - PWL 2025/2026

## Langkah-Langkah Praktikum

**1. Persiapan Database (Migration & Model)**
Telah dibuat migrasi untuk tabel `products` dengan field lengkap meliputi: `name`, `sku`, `description`, `price`, `stock`, `image`, `is_active`, dan `is_featured`. Model `Product` dikonfigurasi menggunakan attribute PHP 8.4 `#[Fillable]` dan method `casts()` untuk menjamin integritas tipe data boolean, integer, dan array.

**2. Pembuatan Resource Product**
Resource Product di-generate dengan fitur View Page diaktifkan agar admin dapat melihat detail produk tanpa harus masuk ke mode edit:
```bash
php artisan make:filament-resource Product --record-title-attribute=name --view --no-interaction
```

**3. Implementasi Wizard Form (Multi-Step Form)**
Form input produk diimplementasikan menggunakan komponen `Wizard` yang terbagi menjadi 3 langkah strategis:
- **Product Info:** Berisi informasi dasar seperti Nama, SKU, dan Deskripsi produk.
- **Pricing & Stock:** Fokus pada pengaturan finansial dan inventaris produk dengan validasi tambahan harga minimal 1.
- **Media & Status:** Untuk upload aset visual dan pengaturan status publikasi produk.
Masing-masing langkah dilengkapi dengan icon yang relevan (`heroicon-o-information-circle`, `heroicon-o-currency-dollar`, dan `heroicon-o-photo`) sesuai tugas praktikum.

**4. Kustomisasi Alur Simpan**
Untuk mengintegrasikan tombol simpan ke dalam alur Wizard, tombol default pada `CreateProduct.php` disembunyikan, dan `submitAction()` ditambahkan pada langkah terakhir Wizard di `ProductForm.php`.

**5. Konfigurasi Tabel Product**
Tabel produk diatur untuk menampilkan ringkasan data yang informatif, termasuk implementasi **Badge Status** untuk kolom `is_active` (Hijau untuk Active, Merah untuk Inactive) agar memudahkan pemantauan status produk secara cepat.

## Analisis & Diskusi

1. **Mengapa Wizard Form lebih baik untuk form panjang?**
   Wizard Form memecah kompleksitas dengan membagi form menjadi bagian-bagian kecil. Hal ini mengurangi beban kognitif pengguna, memberikan panduan alur pengisian yang jelas, dan membuat proses yang membosankan menjadi terasa lebih interaktif dan terukur progresnya.

2. **Kapan kita menggunakan skippable()?**
   `skippable()` digunakan pada form wizard di mana setiap langkah bersifat opsional atau tidak memiliki ketergantungan sekuensial yang ketat, sehingga pengguna diperbolehkan untuk melompat antar langkah tanpa harus menyelesaikan validasi di langkah sebelumnya.

3. **Apa kelebihan multi step dibanding single form panjang?**
   Multi-step form memiliki tingkat konversi yang lebih tinggi karena tidak mengintimidasi pengguna dengan puluhan field sekaligus. Selain itu, pengelompokan field yang logis memudahkan proses audit data sebelum proses submit akhir dilakukan.

4. **Apakah wizard cocok untuk semua jenis form?**
   Tidak. Wizard kurang efisien untuk form pendek atau form yang membutuhkan perbandingan data antar field yang berada di langkah yang berbeda. Wizard paling tepat digunakan untuk proses pendaftaran panjang, checkout e-commerce, atau input data master yang detail.

## Kesimpulan
Praktikum Jobsheet 7.1 ini berhasil mendemonstrasikan kekuatan Filament dalam menangani form kompleks melalui fitur Wizard. Dengan membagi inputan produk menjadi beberapa tahap yang logis, aplikasi admin tidak hanya menjadi lebih fungsional namun juga memberikan pengalaman pengguna yang jauh lebih baik dan profesional.
