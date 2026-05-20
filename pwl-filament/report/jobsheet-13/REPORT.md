# Laporan Tugas Jobsheet 13 - PWL 2025/2026

## Langkah-Langkah Praktikum

**1. Menambahkan Delete Action**

`DeleteAction` ditambahkan langsung ke `recordActions()` agar tombol Delete tersedia di setiap baris tabel, tanpa harus masuk ke halaman edit. Filament secara otomatis menampilkan confirmation dialog sebelum data dihapus.

```php
// app/Filament/Resources/Posts/Tables/PostsTable.php

use Filament\Actions\DeleteAction;

->recordActions([
    EditAction::make(),
    DeleteAction::make(),
])
```

**2. Menambahkan Replicate Action**

`ReplicateAction` adalah predefined action bawaan Filament untuk menduplikasi record. Saat diklik, Filament membuat salinan record tersebut beserta seluruh atributnya secara otomatis.

```php
use Filament\Actions\ReplicateAction;

->recordActions([
    EditAction::make(),
    DeleteAction::make(),
    ReplicateAction::make(),
])
```

**3. Membuat Custom Action — Status Change**

Custom action dibuat menggunakan `Action::make()` untuk mengubah status `published` langsung dari tabel tanpa membuka halaman edit. Implementasi dibagi menjadi 4 sub-langkah:

**3a. Definisi Action dengan Label dan Icon**
```php
use Filament\Actions\Action;

Action::make('status')
    ->label('Status Change')
    ->icon('heroicon-o-check-circle')
```

**3b. Menambahkan Form Input (Checkbox)**

`schema()` digunakan untuk menyematkan komponen form ke dalam modal action. Checkbox `published` dikonfigurasi dengan nilai default yang diambil dari data record saat ini menggunakan closure.

```php
use Filament\Forms\Components\Checkbox;

->schema([
    Checkbox::make('published')
        ->default(fn ($record): bool => $record->published),
])
```

**3c. Menambahkan Logic Update Data**

Method `->action()` menerima closure dengan parameter `$record` (model Eloquent) dan `$data` (input form). Di sini dilakukan update ke database menggunakan Eloquent `update()`.

```php
->action(function ($record, $data) {
    $record->update(['published' => $data['published']]);
})
```

**3d. Fitur Tambahan**

```php
->requiresConfirmation(false)  // tidak perlu konfirmasi tambahan karena sudah ada modal form
```

### Hasil Akhir `PostsTable.php`

```php
<?php

namespace App\Filament\Resources\Posts\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ReplicateAction;
use Filament\Forms\Components\Checkbox;
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
                DeleteAction::make(),
                ReplicateAction::make(),
                Action::make('status')
                    ->label('Status Change')
                    ->icon('heroicon-o-check-circle')
                    ->schema([
                        Checkbox::make('published')
                            ->default(fn ($record): bool => $record->published),
                    ])
                    ->action(function ($record, $data) {
                        $record->update(['published' => $data['published']]);
                    })
                    ->requiresConfirmation(false),
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

1. **Mengapa action di tabel lebih efisien dibanding halaman edit?**
   Action di tabel mengeliminasi navigasi halaman yang tidak perlu. Operasi sederhana seperti delete, duplicate, atau toggle status yang biasanya membutuhkan 3–4 klik (klik edit → masuk halaman → ubah → simpan) dapat diselesaikan dalam 1–2 klik langsung dari baris tabel. Ini mempercepat produktivitas admin secara signifikan, terutama saat memproses banyak record sekaligus.

2. **Apa perbedaan predefined action dan custom action?**
   - **Predefined action** (`EditAction`, `DeleteAction`, `ReplicateAction`): Sudah memiliki logika, UI, konfirmasi, dan notifikasi bawaan yang siap pakai. Cukup dipanggil dengan `::make()`.
   - **Custom action** (`Action::make()`): Dibangun dari nol menggunakan API Filament. Developer mendefinisikan sendiri label, icon, form schema, dan logika callback `->action()`. Cocok untuk operasi bisnis spesifik yang tidak tersedia sebagai predefined action.

3. **Bagaimana cara menambahkan validasi dalam custom action?**
   Validasi ditambahkan langsung pada komponen form di dalam `->schema()` menggunakan method Filament Form seperti `->required()`, `->rules([...])`, atau `->minLength()`. Filament akan memvalidasi input sebelum callback `->action()` dieksekusi.
   ```php
   ->schema([
       Checkbox::make('published')->required(),
       TextInput::make('reason')->required()->minLength(10),
   ])
   ```

4. **Kapan kita menggunakan `ReplicateAction`?**
   `ReplicateAction` paling tepat digunakan ketika: (1) membuat konten serupa dengan template yang sudah ada, misal postingan periodik dengan format yang sama; (2) pengujian (testing) data tanpa merusak record asli; (3) membuat variasi dari record yang sudah ada. Namun perlu diperhatikan bahwa relasi many-to-many tidak otomatis ter-replicate kecuali dikonfigurasi secara eksplisit.

## Kesimpulan
Jobsheet 13 berhasil mengimplementasikan sistem **Table Actions** yang komprehensif pada tabel Post. Dengan menambahkan `DeleteAction` dan `ReplicateAction` sebagai predefined actions, admin dapat menghapus dan menduplikasi data langsung dari tabel. Puncaknya adalah implementasi **Custom Action** `Status Change` yang membuktikan fleksibilitas API Filament — menggunakan `Action::make()` dengan `->schema()`, `->action()`, dan `->icon()` untuk membangun interaksi form modal yang sepenuhnya dikustomisasi. Penggabungan action ini menghasilkan admin panel yang tidak hanya informatif namun juga sangat operasional dan efisien.
