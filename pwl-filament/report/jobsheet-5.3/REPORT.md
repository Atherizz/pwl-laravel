# Laporan Tugas Jobsheet 5.3 - PWL 2025/2026

## Langkah-Langkah Praktikum

**1. Membuat Model & Migration Category**
Jalankan perintah berikut:
`ash
php artisan make:model Category -m
`

**2. Mendesain Tabel Categories**
Buka file migration untuk tabel categories dan tambahkan skema kolom:
`php
Schema::create('categories', function (Blueprint ) {
    $table->id();
    $table->string('name');
    $table->string('slug');
    $table->timestamps();
});
`
Lalu jalankan tabel migrasi:
`ash
php artisan migrate
`

**3. Mengatur Model Category**
Buka pp/Models/Category.php dan tambahkan properti fillable agar mendukung mass assignment:
`php
protected $fillable = [
    'name',
    'slug',
];
`

**4. Mempersiapkan Post (Model & Migration)**
Generate model *Post*:
`ash
php artisan make:model Post -m
`

**5. Mendesain Struktur Tabel Posts**
Edit file migration create_posts_table, kemudian jalankan php artisan migrate:
`php
$table->string('title');
$table->string('slug');
$table->integer('category_id');
$table->string('color')->nullable();
$table->string('image')->nullable();
$table->text('body')->nullable();
$table->json('tags')->nullable();
$table->boolean('published')->default(false);
$table->date('published_at')->nullable();
`

**6. Mengatur Model Post**
Buka pp/Models/Post.php dan tambahkan $fillable, casts, beserta fungsi relasinya:
`php
protected $fillable = [
    'title', 'slug', 'category_id', 'color', 'image', 'body', 'tags', 'published', 'published_at',
];

protected function casts(): array 
{
    return [
        'tags' => 'array',
        'published' => 'boolean',
        'published_at' => 'date',
    ];
}

public function category()
{
    return $this->belongsTo(Category::class);
}
`

**7. Membuat Resource Category di Filament**
Karena Category digunakan untuk relasi Post, buat resourcenya terlebih dahulu:
`ash
php artisan make:filament-resource Category
`
*(Atribut utama → name, read-only → No, dari database → No)*

**Edit Form Category**
Pada CategoryForm.php modifikasi form input:
`php
TextInput::make('name')->required(),
TextInput::make('slug')->required(),
`

**Edit Table Category**
Pada CategoriesTable.php pastikan tabel menampikan data:
`php
TextColumn::make('name'),
TextColumn::make('slug'),
`

---
*Catatan: Konfigurasi selesai dan semua resource data untuk Categories sekarang sudah bisa dimanipulasi dari halaman Admin.*
