# Laporan Tugas Jobsheet 14 - PWL 2025/2026

## Langkah-Langkah Praktikum

**1. Membuat Relasi Category dan Post**
Menambahkan relasi `hasMany` pada model `Category` dan memastikan model `Post` memiliki relasi `belongsTo` ke `Category`.

```php
// app/Models/Category.php
public function posts()
{
    return $this->hasMany(Post::class);
}

// app/Models/Post.php
public function category()
{
    return $this->belongsTo(Category::class);
}
```

**2. Mengimplementasikan Relationship Dropdown pada Post Form**
Mengubah komponen `Select` untuk `category_id` agar menggunakan `relationship()` alih-alih `options()`, lalu mengaktifkan `searchable()` untuk menangani data yang besar.

```php
// app/Filament/Resources/Posts/Schemas/PostForm.php
use Filament\Forms\Components\Select;

Select::make('category_id')
    ->label('Category')
    // ->preload()
    ->relationship('category', 'name')
    ->searchable()
    ->required(),
```

**3. Menampilkan Kategori pada Post Table**
Kolom `category.name` digunakan untuk menampilkan nama relasi di tabel Post.

```php
// app/Filament/Resources/Posts/Tables/PostsTable.php
use Filament\Tables\Columns\TextColumn;

TextColumn::make('category.name')
    ->label('Category')
    ->sortable()
    ->searchable()
    ->toggleable(),
```

**4. Membuat Relationship Manager pada Category**
Menjalankan command artisan untuk generate relation manager:
`php artisan make:filament-relation-manager CategoryResource posts title`

Kemudian mendaftarkannya pada `CategoryResource`:

```php
// app/Filament/Resources/Categories/CategoryResource.php
use App\Filament\Resources\Categories\RelationManagers\PostsRelationManager;

public static function getRelations(): array
{
    return [
        RelationManagers\PostsRelationManager::class,
    ];
}
```

**5. Mengustomisasi Kolom dan Form pada Relationship Manager**
Menambahkan input untuk `slug` pada form modal pembuatan relasi dan kolom `slug` serta `created_at` pada tabel relation manager.

```php
// app/Filament/Resources/Categories/RelationManagers/PostsRelationManager.php
public function form(Schema $schema): Schema
{
    return $schema
        ->components([
            TextInput::make('title')->required()->maxLength(255),
            TextInput::make('slug')->required()->maxLength(255),
        ]);
}

public function table(Table $table): Table
{
    return $table
        ->recordTitleAttribute('title')
        ->columns([
            TextColumn::make('title')->searchable(),
            TextColumn::make('slug'),
            TextColumn::make('created_at'),
        ])
        // ...
}
```

## Analisis & Diskusi

1. **Apa perbedaan `relationship()` dengan `options()`?**
   - `options()`: Mengambil dan memuat array data secara manual dari database (misalnya menggunakan `Category::all()->pluck(...)`). Kurang efisien jika jumlah baris sangat besar karena semua data diload sekaligus ke memori dan dikirim ke frontend.
   - `relationship()`: Menggunakan fitur relasi model Eloquent Filament yang dimuat secara native. Lebih efisien, bisa digabungkan dengan `searchable()` atau `preload()` untuk mengatur bagaimana dan kapan data di-load.

2. **Mengapa `searchable()` penting untuk dataset besar?**
   Dengan `searchable()`, opsi di dalam dropdown tidak diload seluruhnya saat halaman pertama dibuka (kecuali pakai preload). Input dropdown melakukan AJAX request secara asynchronous ke database untuk mencari record berdasarkan keyword yang diketik. Ini sangat mengurangi waktu load (loading time) dan memori, mencegah tab browser menjadi *freeze* atau lambat.

3. **Apa fungsi Relationship Manager pada Filament?**
   Relationship Manager merupakan fitur antarmuka yang memungkinkan pengelolaan (CRUD) data relasi (seperti HasMany atau BelongsToMany) langsung dari halaman "Edit" atau "View" milik resource induknya. Dengan fitur ini, kita tidak perlu berpindah-pindah antar halaman resource untuk membuat atau mengedit data anak (child data).

4. **Kapan menggunakan HasMany dan BelongsTo?**
   - **HasMany**: Diletakkan pada model "Parent" (Induk) yang menyimpan/memiliki banyak data anak. (Contoh: `Category` has many `Posts`).
   - **BelongsTo**: Diletakkan pada model "Child" (Anak) yang memiliki field *foreign key* yang merujuk ke tabel Parent. (Contoh: `Post` belongs to `Category` melalui `category_id`).

## Kesimpulan
Pada praktikum ini, implementasi relasi HasMany antara Category dan Post di Laravel berhasil dihubungkan dengan fitur Filament secara menyeluruh. Kita telah mengganti pemanggilan manual `options()` menjadi fungsi `relationship()` yang lebih dinamis dan menambahkan fitur `searchable()` untuk performa UI pada dataset besar. Selain itu, **Relationship Manager** telah dibangkitkan untuk merapikan alur kerja admin, memampukan manajemen data Post secara inheren di dalam resource Category dengan pre-filling foreign key otomatis.
