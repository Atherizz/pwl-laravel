# Laporan Tugas Jobsheet 10 - PWL 2025/2026

## Langkah-Langkah Praktikum

**1. Menambahkan Fitur Sorting Dasar**
Fitur sorting (pengurutan) telah diaktifkan pada berbagai kolom tabel Post untuk meningkatkan efisiensi manajemen data. Dengan menambahkan method `->sortable()`, Filament akan secara otomatis mengubah header tabel menjadi elemen interaktif yang dapat diklik untuk mengubah arah urutan data.

**2. Sorting pada Kolom Teks dan Relasi**
Kolom **Title**, **Slug**, dan **Category Name** kini telah mendukung fitur sorting. Khusus untuk Category Name, Filament menangani pengurutan berdasarkan nama kategori dari tabel relasi secara otomatis.
```php
TextColumn::make('title')->sortable(),
TextColumn::make('category.name')->sortable()
```

**3. Sorting pada Kolom Tanggal**
Menambahkan kolom `created_at` yang dilengkapi dengan method `dateTime()` untuk format waktu yang rapi serta `sortable()` agar admin dapat mengurutkan postingan berdasarkan waktu pembuatannya.

**4. Mengatur Default Sorting**
Sesuai dengan instruksi latihan praktikum, tabel dikonfigurasi agar secara default menampilkan data terbaru di posisi paling atas (Descending berdasarkan tanggal pembuatan).
```php
return $table
    ->defaultSort('created_at', 'desc')
    ->columns([ ... ])
```

## Analisis & Diskusi

1. **Mengapa sorting penting pada admin panel?**
   Sorting sangat penting untuk memudahkan admin dalam melakukan audit dan pencarian data secara cepat. Tanpa fitur pengurutan, manajemen ribuan record akan menjadi sangat sulit karena admin tidak bisa mengelompokkan data berdasarkan abjad, kategori, atau urutan kronologis waktu.

2. **Apa perbedaan sortable biasa dengan defaultSort()?**
   `sortable()` memberikan opsi kepada pengguna (admin) untuk melakukan pengurutan secara dinamis melalui antarmuka tabel. Sementara `defaultSort()` menentukan kondisi urutan data awal (initial state) saat tabel pertama kali dimuat oleh browser.

3. **Mengapa relasi tetap bisa di-sort?**
   Karena Filament terintegrasi erat dengan Laravel Eloquent. Saat kita menggunakan dot notation seperti `category.name`, Filament akan secara otomatis melakukan JOIN ke tabel kategori dan menerapkan urutan `ORDER BY` pada kolom nama tersebut di tingkat query database.

4. **Kapan kita menggunakan desc sebagai default?**
   Urutan Descending (`desc`) paling sering digunakan untuk kolom timestamp (seperti `created_at`) atau ID utama. Hal ini dilakukan agar data yang paling baru dimasukkan atau aktivitas terkini selalu muncul di halaman pertama dan posisi teratas, memudahkan admin untuk memantau perkembangan data terbaru.

## Kesimpulan
Melalui Jobsheet 10 ini, tabel Resource Post telah ditingkatkan fungsionalitasnya dengan fitur sorting yang komprehensif. Implementasi `sortable()` pada kolom teks, relasi, dan tanggal, dikombinasikan dengan pengaturan `defaultSort()`, menjadikan dashboard admin lebih responsif terhadap kebutuhan pengolahan data yang dinamis.
