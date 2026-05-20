# Laporan Tugas Jobsheet 11 - PWL 2025/2026

## Langkah-Langkah Praktikum

**1. Menambahkan Fitur Search (Pencarian)**
Fitur pencarian diintegrasikan pada tabel Post dengan menambahkan method `->searchable()` pada kolom-kolom teks utama:
- **Title**
- **Slug**
- **Category Name** (Relasi)

Filament secara otomatis memunculkan *Search bar* global di atas tabel. Pencarian bersifat *real-time* dan memfilter row yang cocok dari ketiga kolom tersebut secara simultan.

```php
// app/Filament/Resources/Posts/Tables/PostsTable.php

TextColumn::make('title')
    ->sortable()
    ->searchable(),
TextColumn::make('slug')
    ->sortable()
    ->searchable(),
TextColumn::make('category.name')
    ->sortable()
    ->searchable(),
```

**2. Membuat Filter Berdasarkan Tanggal (Date Filter)**
Pencarian tanggal diimplementasikan menggunakan arsitektur **Filter** karena `searchable()` berbasis wildcard string tidak cocok untuk data bertipe timestamp. Komponen `DatePicker` disematkan ke dalam form filter `created_at`, dilengkapi custom query menggunakan method `when()`.

```php
// app/Filament/Resources/Posts/Tables/PostsTable.php

use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\DatePicker;

Filter::make('created_at')
    ->label('Creation Date')
    ->form([
        DatePicker::make('created_at')
            ->label('Select Date'),
    ])
    ->query(function ($query, $data) {
        return $query->when(
            $data['created_at'],
            fn ($query, $date) => $query->whereDate('created_at', $date)
        );
    }),
```

`whereDate()` memastikan filter hanya mengevaluasi segmen tanggal, mengabaikan atribut waktu (jam/menit/detik) pada kolom `timestamp`.

**3. Membuat Filter Berdasarkan Relasi (Select Filter)**
Untuk menyaring postingan berdasarkan Kategori, digunakan `SelectFilter` dengan method `->relationship('category', 'name')`. Filament secara otomatis merender list nama kategori ke dropdown filter dan menyaring hasil tabel menggunakan ID kategori saat opsi dipilih.

```php
// app/Filament/Resources/Posts/Tables/PostsTable.php

use Filament\Tables\Filters\SelectFilter;

SelectFilter::make('category_id')
    ->label('Select Category')
    ->relationship('category', 'name')
    ->preload(),
```

**4. Uji Kombinasi Search dan Filter**
Pengujian gabungan dilakukan dengan memadukan kriteria *Search bar* (misal kata "Tutorial") dengan kriteria *Filter* (misal kategori "Teknologi"). Filament menggabungkan kedua kondisi dengan logika `AND`, menghasilkan pencarian yang presisi.

### Hasil Akhir `PostsTable.php`

```php
<?php

namespace App\Filament\Resources\Posts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Table;

class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('title')
                    ->sortable()
                    ->searchable(),
                \Filament\Tables\Columns\TextColumn::make('slug')
                    ->sortable()
                    ->searchable(),
                \Filament\Tables\Columns\TextColumn::make('category.name')
                    ->sortable()
                    ->searchable(),
                \Filament\Tables\Columns\ColorColumn::make('color'),
                \Filament\Tables\Columns\ImageColumn::make('image')->disk('public'),
                \Filament\Tables\Columns\IconColumn::make('published')->boolean(),
                \Filament\Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                \Filament\Tables\Filters\Filter::make('created_at')
                    ->label('Creation Date')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('created_at')
                            ->label('Select Date'),
                    ])
                    ->query(function ($query, $data) {
                        return $query->when(
                            $data['created_at'],
                            fn ($query, $date) => $query->whereDate('created_at', $date)
                        );
                    }),
                \Filament\Tables\Filters\SelectFilter::make('category_id')
                    ->label('Select Category')
                    ->relationship('category', 'name')
                    ->preload(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
```

## Analisis & Diskusi

1. **Mengapa search tidak cocok untuk filter tanggal?**
   Pencarian teks (`searchable`) menggunakan *wildcard string matching* (`LIKE %...%`). Hal ini rentan terhadap kesalahan ketik, format tidak konsisten (misal user mengetik "Mei" padahal database menyimpan "05"), dan tidak memiliki fungsionalitas rentang (between/before/after). UI DatePicker pada Filter menawarkan kepastian sintaks dan kenyamanan interaksi.

2. **Apa fungsi `relationship()` pada `SelectFilter`?**
   Fungsi ini merupakan abstraction layer yang mengotomatisasi pengisian *options* dropdown berdasarkan data di tabel relasi, sekaligus merangkai query `whereHas` atau `where` untuk memfilter data pada tabel utama sesuai opsi yang dipilih.

3. **Mengapa kita perlu `whereDate()` pada query filter?**
   Kolom `created_at` bertipe `timestamp` (`YYYY-MM-DD HH:MM:SS`). Jika difilter menggunakan `where` biasa dengan input `YYYY-MM-DD`, query akan gagal karena mencari kecocokan presisi yang bernilai `YYYY-MM-DD 00:00:00`. Fungsi `whereDate()` memerintahkan SQL untuk hanya mengevaluasi segmen tanggalnya saja.

4. **Apa perbedaan `searchable()` dan `filters()`?**
   - **`searchable()`**: Pencarian berbasis frasa tak tentu secara melebar (*broad text search*) — satu kata kunci dicari di banyak kolom sekaligus.
   - **`filters()`**: Penyaringan terstruktur berbasis aturan pasti (exact match, date match, boolean state) dengan UI spesifik (dropdown, checkbox, calendar).

## Kesimpulan
Melalui Jobsheet 11, kemampuan navigasi data admin telah ditingkatkan secara signifikan. Penggabungan fitur pencarian universal (`searchable`) dan sistem penyaringan spesifik (`Filter` dengan DatePicker dan `SelectFilter` dengan relationship) memungkinkan tabel Filament menangani dataset besar tanpa mengorbankan kecepatan akses. Kedua mekanisme ini saling melengkapi: `searchable` untuk pencarian bebas teks, `filters` untuk penyaringan terstruktur dan presisi.
