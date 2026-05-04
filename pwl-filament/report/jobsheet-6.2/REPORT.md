# Laporan Tugas Jobsheet 6.2 - PWL 2025/2026

## Langkah-Langkah Praktikum

**1. Mengatur Layout Dasar dengan Columns**
Untuk mengatur tata letak form agar lebih terstruktur, kita menggunakan method `columns()` pada schema utama. Dalam tugas ini, kita menggunakan `->columns(3)` untuk membagi layout halaman menjadi 3 kolom grid utama.

**2. Menggunakan Section untuk Pengelompokan**
`Section` digunakan untuk membungkus beberapa field dalam satu kotak (card) yang memiliki judul, deskripsi, dan icon. Ini membantu pengguna memahami konteks dari field yang diisi secara visual.
```php
\Filament\Forms\Components\Section::make('Post Details')
    ->description('Write the title, slug, and content of your post.')
    ->icon('heroicon-o-document-text')
    ->schema([ ... ])
```

**3. Menggunakan Group untuk Layout Kompleks**
`Group` memungkinkan pengelompokan komponen tanpa tampilan visual tambahan, sangat berguna untuk mengatur proporsi lebar menggunakan `columnSpan`. Form Post dibagi menjadi:
- **Group Kiri (columnSpan 2):** Berisi Section 'Post Details'.
- **Group Kanan (columnSpan 1):** Berisi Section 'Image Upload' dan 'Meta'.

**4. Mengatur Lebar Field Individual**
Di dalam Section 'Post Details', digunakan Group tambahan dengan `columns(2)` untuk menata field Title, Slug, Category, dan Color secara berdampingan. Sedangkan untuk `MarkdownEditor` (body), digunakan `columnSpanFull()` agar memakan seluruh lebar baris dalam section tersebut.

## Analisis & Diskusi

1. **Mengapa layout form penting dalam aplikasi admin?**
   Layout yang terstruktur sangat penting untuk meningkatkan efisiensi admin dalam mengelola konten. Dengan pengelompokan yang logis, admin dapat dengan mudah menemukan field yang relevan, mengurangi kelelahan visual akibat list field yang terlalu panjang, dan menciptakan alur kerja yang lebih profesional.

2. **Apa perbedaan Section dan Group?**
   `Section` adalah komponen layout yang memiliki tampilan visual (border, background card, judul, deskripsi, dan icon). Sementara `Group` adalah komponen layout "invisible" yang digunakan murni untuk keperluan struktur grid, seperti mengelompokkan beberapa komponen agar bisa diatur lebarnya secara bersamaan menggunakan `columnSpan`.

3. **Kapan kita menggunakan columnSpanFull()?**
   `columnSpanFull()` digunakan saat sebuah field (seperti konten body/editor) membutuhkan ruang yang luas agar nyaman digunakan, sehingga field tersebut akan mengambil seluruh lebar kolom yang tersedia pada parent container-nya tanpa terpengaruh pembagian kolom grid di baris tersebut.

4. **Apa keuntungan sistem grid 12 kolom?**
   Keuntungan utamanya adalah fleksibilitas. Angka 12 memiliki banyak pembagi (2, 3, 4, 6), sehingga developer bisa dengan mudah membuat perbandingan layout yang bervariasi (misal 50-50, 33-66, atau 25-75) dengan konsistensi yang terjaga, serupa dengan sistem grid pada Tailwind CSS.

## Kesimpulan
Melalui praktikum Jobsheet 6.2 ini, mahasiswa telah mampu mengubah tampilan form yang semula sederhana menjadi lebih terorganisir dan profesional. Penggunaan `Section` memberikan identitas pada tiap kelompok data, sedangkan `Group` dan `columns()` memberikan kendali penuh terhadap proporsi dan tata letak komponen form di Filament.
