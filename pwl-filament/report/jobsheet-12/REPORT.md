# Laporan Tugas Jobsheet 12 - PWL 2025/2026

## Langkah-Langkah Praktikum

**1. Menambahkan Kolom Baru**

Sebelum mengaktifkan toggle, tiga kolom baru ditambahkan ke tabel Post:

- **Kolom ID** — menampilkan primary key setiap record
- **Kolom Tags** — menampilkan data tags postingan
- **Kolom Published** (sudah ada) — menggunakan `IconColumn` dengan `->boolean()` untuk menampilkan ikon centang/silang

```php
// app/Filament/Resources/Posts/Tables/PostsTable.php

\Filament\Tables\Columns\TextColumn::make('id')
    ->label('ID'),

\Filament\Tables\Columns\TextColumn::make('tags')
    ->label('Tags'),

\Filament\Tables\Columns\IconColumn::make('published')
    ->boolean()
    ->label('Published'),
```

**2. Mengaktifkan Toggle Column**

Method `->toggleable()` ditambahkan pada setiap kolom. Ini memunculkan ikon pengaturan kolom (⚙) di pojok kanan atas tabel, memungkinkan admin memilih kolom mana yang ingin ditampilkan.

```php
\Filament\Tables\Columns\TextColumn::make('title')
    ->sortable()
    ->searchable()
    ->toggleable(),
```

**3. Menyembunyikan Kolom Secara Default**

Dua kolom dikonfigurasi agar tersembunyi saat tabel pertama kali dimuat menggunakan parameter `isToggledHiddenByDefault: true`. Kolom tetap bisa diaktifkan kembali melalui menu toggle.

```php
\Filament\Tables\Columns\TextColumn::make('id')
    ->label('ID')
    ->toggleable(isToggledHiddenByDefault: true),

\Filament\Tables\Columns\TextColumn::make('tags')
    ->label('Tags')
    ->toggleable(isToggledHiddenByDefault: true),
```

**4. Menerapkan Toggle pada Semua Kolom**

Seluruh kolom pada tabel Post dilengkapi dengan `->toggleable()` agar admin memiliki kontrol penuh atas tampilan tabel.

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
                \Filament\Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->toggleable(isToggledHiddenByDefault: true),
                \Filament\Tables\Columns\TextColumn::make('title')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                \Filament\Tables\Columns\TextColumn::make('slug')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                \Filament\Tables\Columns\TextColumn::make('category.name')
                    ->label('Category')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),
                \Filament\Tables\Columns\TextColumn::make('tags')
                    ->label('Tags')
                    ->toggleable(isToggledHiddenByDefault: true),
                \Filament\Tables\Columns\ColorColumn::make('color')
                    ->toggleable(),
                \Filament\Tables\Columns\ImageColumn::make('image')
                    ->disk('public')
                    ->toggleable(),
                \Filament\Tables\Columns\IconColumn::make('published')
                    ->boolean()
                    ->label('Published')
                    ->toggleable(),
                \Filament\Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),
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

1. **Mengapa Toggle Column penting pada admin panel dengan banyak kolom?**
   Tabel dengan banyak kolom akan menjadi sesak (*cluttered*) dan sulit dibaca di layar yang sempit. Toggle Column memungkinkan admin menyesuaikan tampilan tabel sesuai kebutuhan tugas saat itu — misal hanya memunculkan Title dan Status saat melakukan moderasi konten, tanpa terganggu oleh kolom Slug atau Image yang tidak relevan.

2. **Bagaimana Filament menyimpan preferensi toggle kolom?**
   Filament menyimpan konfigurasi kolom yang ditampilkan/disembunyikan dalam **session** browser. Mekanisme ini memastikan preferensi tetap bertahan saat admin berpindah halaman dan kembali ke tabel tersebut, selama session masih aktif. Preferensi akan ter-reset jika session berakhir (logout atau expired).

3. **Apa perbedaan `toggleable()` dan `toggleable(isToggledHiddenByDefault: true)`?**
   - **`toggleable()`**: Kolom tampil secara default, namun admin dapat menyembunyikannya melalui menu toggle.
   - **`toggleable(isToggledHiddenByDefault: true)`**: Kolom tersembunyi saat tabel pertama kali dimuat. Admin harus secara aktif mengaktifkannya melalui menu toggle. Cocok untuk kolom detail atau teknis yang jarang dibutuhkan (misal ID, timestamp teknis, metadata).

4. **Kolom mana yang sebaiknya disembunyikan secara default?**
   Kolom yang sebaiknya disembunyikan secara default adalah kolom dengan nilai teknis atau jarang digunakan dalam operasi sehari-hari, seperti: `id` (primary key), `slug` (URL teknis), `tags`, dan `created_at` (jika tidak diperlukan untuk monitoring). Kolom utama seperti `title`, `category`, dan `published` sebaiknya selalu tampil.

## Kesimpulan
Jobsheet 12 berhasil mengimplementasikan fitur **Toggle Column** pada tabel Post. Dengan menambahkan `->toggleable()` pada setiap kolom dan mengkonfigurasi `isToggledHiddenByDefault: true` untuk kolom `id` dan `tags`, tabel admin menjadi lebih bersih dan adaptif. Fitur ini meningkatkan *user experience* admin secara signifikan karena setiap pengguna dapat menyesuaikan tampilan tabel sesuai preferensi dan kebutuhan kerjanya, dengan preferensi yang tersimpan otomatis dalam session.
