# Laporan Tugas Jobsheet 6.1 - PWL 2025/2026

## Langkah-Langkah Praktikum

**1. Membuat Resource Post**
Jalankan perintah berikut untuk membuat resource Post:
```bash
php artisan make:filament-resource Post
```
Isian konfigurasi:
- Model attribute: title
- Generate read-only page: No
- Generate dari database: No

**2. Implementasi Form Elements**
Buka file `PostForm.php` dan modifikasi form input dengan berbagai komponen seperti TextInput, Select, ColorPicker, MarkdownEditor, FileUpload, TagsInput, Checkbox, dan DatePicker. Ditambahkan juga validasi untuk Title minimal 5 karakter dan Slug yang unik.
```php
\Filament\Forms\Components\TextInput::make('title')->required()->minLength(5),
\Filament\Forms\Components\TextInput::make('slug')->required()->unique(ignoreRecord: true),
\Filament\Forms\Components\Select::make('category_id')
    ->label('Category')
    ->options(\App\Models\Category::all()->pluck('name', 'id'))
    ->required(),
\Filament\Forms\Components\ColorPicker::make('color'),
\Filament\Forms\Components\MarkdownEditor::make('body'),
\Filament\Forms\Components\FileUpload::make('image')
    ->disk('public')
    ->directory('post'),
\Filament\Forms\Components\TagsInput::make('tags'),
\Filament\Forms\Components\Checkbox::make('published'),
\Filament\Forms\Components\DatePicker::make('published_at'),
```

**3. Konfigurasi Link Storage**
Agar gambar dari upload dapat diakses, jalankan perintah storage link:
```bash
php artisan storage:link
```

**4. Menampilkan Data di Tabel Post**
Buka file `PostsTable.php` dan modifikasi bagian columns untuk menampilkan data secara detail, termasuk merelasikan dengan nama kategori, gambar, serta status publish.
```php
\Filament\Tables\Columns\TextColumn::make('title'),
\Filament\Tables\Columns\TextColumn::make('slug'),
\Filament\Tables\Columns\TextColumn::make('category.name'),
\Filament\Tables\Columns\ColorColumn::make('color'),
\Filament\Tables\Columns\ImageColumn::make('image')->disk('public'),
\Filament\Tables\Columns\IconColumn::make('published')->boolean(),
```

**5. Konfigurasi Redirect Setelah Simpan Data**
Buka file `CreatePost.php` dan `EditPost.php`, lalu tambahkan method `getRedirectUrl` agar setelah menyimpan data akan kembali ke halaman index:
```php
protected function getRedirectUrl(): string
{
    return $this->getResource()::getUrl('index');
}
```

## Analisis & Diskusi

1. **Mengapa kita perlu storage:link?**
   Secara default file yang diupload disimpan di direktori `storage/app/public` yang tidak dapat diakses langsung oleh browser. Perintah `storage:link` membuat symbolic link ke folder `public/storage` sehingga file tersebut dapat diakses oleh browser secara publik tanpa mengurangi keamanan direktori sistem.

2. **Apa fungsi $casts untuk field JSON?**
   Fungsi `$casts` seperti `['tags' => 'array']` pada model diperlukan untuk memberitahu Laravel agar secara otomatis mengonversi data JSON di database menjadi tipe data Array di PHP saat dipanggil, dan sebaliknya mengubah tipe Array ke JSON saat disimpan ke database.

3. **Mengapa kita menggunakan category.name bukan category_id?**
   Kita menggunakan `category.name` pada tabel untuk menampilkan nama kategori yang dapat dibaca dan dimengerti oleh manusia, karena jika menggunakan `category_id` hanya akan menampilkan angka (ID) yang kurang informatif bagi pengguna.

4. **Apa perbedaan RichEditor dan MarkdownEditor?**
   `RichEditor` adalah editor WYSIWYG (What You See Is What You Get) yang memiliki antarmuka serupa dengan Microsoft Word dan langsung menyimpan data berupa format HTML. Sedangkan `MarkdownEditor` digunakan untuk menginput data menggunakan sintaks Markdown (seperti # untuk heading, ** untuk bold), yang kemudian akan diparse/render menjadi HTML saat ditampilkan.

## Kesimpulan
Pada jobsheet 6.1 ini, kita telah mempelajari cara membuat dan memodifikasi Resource di Filament. Penggunaan beragam Form Elements seperti TextInput, Select untuk relasi, ColorPicker, FileUpload, dan MarkdownEditor diimplementasikan untuk memudahkan proses input data. Selain itu, konfigurasi tabel diatur agar dapat menampilkan data relasi yang lebih bermakna dan memuat visual seperti kolom warna maupun gambar. Proses redirect usai create/edit serta konfigurasi storage link juga dipelajari untuk menjaga alur kerja dan penanganan aset gambar.
