# Laporan Tugas Jobsheet 7.2 - PWL 2025/2026

## Langkah-Langkah Praktikum

**1. Memahami Konsep Info List**
Info List di Filament merupakan sistem komponen yang didesain khusus untuk menampilkan detail record dalam bentuk display-only (read-only). Fitur ini sangat krusial untuk membuat halaman "View" yang bersih, profesional, dan informatif tanpa elemen input yang mengganggu.

**2. Implementasi Section Product Info**
Halaman detail produk diawali dengan Section 'Product Info'. Menggunakan `TextEntry`, data ditampilkan dengan formatting khusus:
- **Nama Produk:** Diberi bobot `bold` dan warna `primary`.
- **SKU:** Ditampilkan dalam bentuk **Badge** berwarna hijau (success) sesuai tugas praktikum.
- **Deskripsi:** Mendukung format Markdown untuk pembacaan teks yang lebih kaya.

**3. Implementasi Section Pricing & Stock**
Menampilkan aspek finansial dan inventaris produk:
- **Harga:** Diformat menggunakan `formatStateUsing()` untuk menyisipkan prefix "Rp" dan pemisah ribuan.
- **Stok:** Dilengkapi dengan icon `heroicon-o-circle-stack` sebagai penanda visual inventaris sesuai tugas praktikum.
```php
TextEntry::make('price')
    ->formatStateUsing(fn (int $state): string => 'Rp ' . number_format($state, 0, ',', '.'))
    ->icon('heroicon-o-currency-dollar')
```

**4. Implementasi Section Media & Status**
Bagian terakhir mengelola aspek visual dan status record:
- **ImageEntry:** Menampilkan gambar produk secara proporsional.
- **IconEntry:** Memberikan representasi visual boolean untuk status Active dan Featured (icon centang/silang).
- **Date Formatting:** Mengubah timestamp `created_at` menjadi format yang mudah dibaca (`d M Y`) dengan warna `info`.

## Analisis & Diskusi

1. **Mengapa View Page tidak cocok menggunakan form input?**
   Halaman View ditujukan untuk konsumsi data, bukan manipulasi data. Penggunaan form input (seperti border, placeholder, dan focus state) menciptakan gangguan visual dan memberikan kesan bahwa data tersebut bisa diedit di halaman tersebut, padahal fungsinya hanya untuk melihat detail secara mendalam dan rapi.

2. **Apa perbedaan TextColumn dan TextEntry?**
   `TextColumn` adalah komponen untuk **Table** (halaman list) yang berurusan dengan koleksi data masif. Sementara `TextEntry` adalah komponen untuk **Info List** (halaman detail) yang berfokus pada presentasi detail satu record tertentu dengan ruang tata letak yang lebih luas.

3. **Kapan kita menggunakan badge?**
   Badge digunakan saat kita ingin memberikan penekanan visual pada sebuah data kategorikal atau status yang singkat. Dalam praktikum ini, SKU diberikan badge agar terlihat sebagai identitas unik yang menonjol dibandingkan deskripsi teks biasa.

4. **Apa keuntungan menggunakan IconEntry untuk boolean?**
   `IconEntry` meningkatkan kecepatan kognitif admin dalam memahami status. Secara visual, icon centang hijau jauh lebih cepat dipahami sebagai "Aktif" dibandingkan teks "True" atau angka "1", sehingga admin dapat melakukan scanning data dengan lebih efisien.

## Kesimpulan
Melalui Jobsheet 7.2 ini, fungsionalitas View Page pada Resource Product telah ditingkatkan menggunakan Info List. Dengan memisahkan logika tampilan dari logika input, aplikasi admin kini memiliki halaman detail yang jauh lebih profesional, informatif, dan memiliki estetika visual yang konsisten dengan standar modern aplikasi admin panel.
