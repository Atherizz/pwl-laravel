# Laporan Tugas Jobsheet 7.3 - PWL 2025/2026

## Langkah-Langkah Praktikum

**1. Mengubah Section Menjadi Tabs**
Untuk meningkatkan efisiensi ruang dan estetika pada halaman detail produk, tata letak yang sebelumnya menggunakan `Section` berderet vertikal kini diubah menjadi komponen `Tabs`. Perubahan ini membagi informasi detail record ke dalam beberapa kategori yang dapat diakses secara interaktif.

**2. Implementasi Tab Product Info**
Tab pertama dikhususkan untuk identitas produk. Menggunakan icon `heroicon-o-information-circle`, tab ini menampilkan Nama Produk, SKU (sebagai badge), dan Deskripsi Produk dengan tata letak yang bersih.

**3. Implementasi Tab Pricing & Stock dengan Badge Dinamis**
Tab kedua mengelola aspek finansial dan stok. Sesuai dengan instruksi latihan praktikum, ditambahkan **Badge Dinamis** yang menampilkan angka stok produk secara *real-time* langsung pada label tab.
```php
\Filament\Infolists\Components\Tabs\Tab::make('Pricing & Stock')
    ->icon('heroicon-o-currency-dollar')
    ->badge(fn ($record): string => (string) $record->stock)
    ->badgeColor('info')
```

**4. Implementasi Tab Media & Status**
Tab ketiga menampung aset visual dan status publikasi. Menggunakan `ImageEntry` untuk gambar dan `IconEntry` untuk status boolean, memberikan representasi data yang intuitif bagi admin.

**5. Mengubah Orientasi Menjadi Vertical**
Untuk memberikan tampilan yang lebih modern dan memanfaatkan lebar layar secara optimal, orientasi tabs diubah menjadi **Vertical** menggunakan method `->vertical()`. Navigasi tab kini berada di sisi kiri, memberikan kesan aplikasi admin yang lebih profesional.

## Analisis & Diskusi

1. **Kapan kita menggunakan Tabs dibanding Section?**
   `Tabs` sebaiknya digunakan saat jumlah informasi yang ditampilkan sangat banyak sehingga menyebabkan halaman menjadi terlalu panjang (long scrolling). `Section` lebih tepat digunakan jika informasi antar bagian bersifat singkat dan perlu dilihat secara bersamaan dalam satu pandangan mata.

2. **Apa kelebihan Tabs untuk data panjang?**
   Tabs secara signifikan mengurangi "kelelahan visual" pengguna dengan menyembunyikan informasi yang tidak diperlukan saat itu. Ini memungkinkan admin untuk melakukan navigasi cepat ke bagian data tertentu tanpa harus mencari-cari posisi scroll.

3. **Apakah Tabs bisa digunakan pada Form juga?**
   Sangat bisa. Filament menyediakan komponen `Tabs` yang hampir identik untuk diimplementasikan pada Schema Form. Fitur ini sering digunakan pada form input produk yang kompleks untuk membagi inputan dasar, SEO, dan inventaris ke dalam tab-tab terpisah.

4. **Bagaimana jika tab terlalu banyak?**
   Jika jumlah tab melebihi kapasitas lebar layar, orientasi `vertical()` adalah solusi terbaik. Namun jika jumlahnya tetap terlalu masif (misal >10 tab), maka perlu dilakukan evaluasi arsitektur data, mungkin dengan memindahkan beberapa bagian ke dalam *Relation Manager*.

## Kesimpulan
Melalui Jobsheet 7.3 ini, halaman detail Produk telah berhasil ditingkatkan menjadi lebih user-friendly menggunakan komponen `Tabs`. Penambahan fitur badge dinamis untuk stok dan orientasi vertikal tidak hanya membuat data lebih mudah dibaca, tetapi juga meningkatkan nilai estetika dan profesionalisme dari dashboard admin Filament.
