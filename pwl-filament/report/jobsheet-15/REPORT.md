# Laporan Tugas Jobsheet 15 - PWL 2025/2026

## Langkah-Langkah Praktikum

**1. Membuat Tabel Tags dan Pivot Table**
File migrasi `create_posts_table.php` telah dimodifikasi (atau rollback dan direvisi) untuk menghapus kolom JSON `tags` pada tabel `posts` dan menambahkan pembuatan tabel `tags` serta pivot table `post_tag` untuk menampung relasi Many-to-Many.
```php
Schema::create('tags', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->timestamps();
});

Schema::create('post_tag', function (Blueprint $table) {
    $table->foreignId('post_id')->constrained()->cascadeOnDelete();
    $table->foreignId('tag_id')->constrained()->cascadeOnDelete();
    $table->primary(['post_id','tag_id']);
});
```

**2. Membuat Model Tag dan Resource Tag**
Membuat model `Tag` serta mendefinisikan fillable. Selain itu, resource `TagResource` dibuat di dalam Filament untuk menyediakan antarmuka CRUD untuk `Tag`. Setelah membuat, metode `getRedirectUrl()` pada `CreateTag` dan `EditTag` dikonfigurasi agar mengarahkan kembali ke halaman index.
```php
// app/Models/Tag.php
protected $fillable = ['name'];

public function posts() {
    return $this->belongsToMany(Post::class, 'post_tag');
}
```

**3. Mengatur Relationship pada Post**
Kolom `tags` dihapus dari atribut `fillable` pada model `Post`. Sebagai gantinya, relasi `belongsToMany` ditambahkan.
```php
// app/Models/Post.php
public function tags() {
    return $this->belongsToMany(Tag::class, 'post_tag');
}
```

**4. Mengubah Select Input Menjadi Multiple Relationship di PostForm**
Di dalam form schema `PostResource`, input JSON `TagsInput` diganti menjadi komponen `Select` berelasi Many-to-Many, di mana `multiple()` memungkinkan pengguna memilih beberapa tags sekaligus.
```php
\Filament\Forms\Components\Select::make('tags')
    ->relationship('tags', 'name')
    ->multiple(),
```

**5. Implementasi Tags Relationship Manager**
`TagsRelationManager` dibuat melalui command artisan `make:filament-relation-manager PostResource tags name`. Relationship manager ini didaftarkan dalam `PostResource::getRelations()`. Melalui fitur ini, kita dapat melakukan fungsi "Attach" (mengaitkan post ke tag baru atau yang sudah ada) maupun "Detach" (melepaskan relasi dari tag) langsung pada halaman edit Post.

## Analisis & Diskusi

1. **Apa perbedaan HasMany dan Many-to-Many?**
   - **HasMany**: Relasi one-to-many. Satu data parent bisa memiliki banyak data child, tetapi data child tersebut hanya bisa dimiliki oleh satu parent spesifik (diwujudkan dengan satu *foreign key* di tabel child).
   - **Many-to-Many**: Relasi antar dua tabel di mana satu data di Tabel A bisa berelasi dengan banyak data di Tabel B, begitu pula sebaliknya. Membutuhkan tabel penghubung perantara (pivot table).

2. **Mengapa pivot table diperlukan?**
   Di dalam RDBMS (Relational Database Management System), dua tabel tidak dapat memiliki koneksi fisik *many-to-many* secara langsung karena akan menimbulkan ambiguitas dan redundansi data. Oleh karena itu, *pivot table* berfungsi sebagai jembatan yang menghubungkan kedua *primary key* masing-masing tabel tersebut sebagai sepasang *foreign key*.

3. **Apa fungsi attach dan detach pada Filament?**
   - **Attach**: Operasi untuk menautkan (menyisipkan) record baru pada pivot table yang menghubungkan entitas parent dengan entitas relasinya.
   - **Detach**: Operasi untuk menghapus baris relasi yang ada di dalam pivot table, melepaskan ikatan kedua data tanpa harus menghapus data aslinya di tabel utama.

4. **Mengapa JSON column kurang baik untuk relasi?**
   - **Tidak Terstruktur**: Database tidak bisa menegakkan validasi referensi silang (*foreign key constraint*) ke entitas tags secara riil.
   - **Kinerja dan Query**: Pencarian tag spesifik di dalam tipe data JSON membutuhkan operasi full-table scan atau indexing khusus, yang kinerjanya sangat lambat untuk dataset yang membesar.
   - **Duplikasi Data**: Apabila nama suatu tag diubah, maka tag di seluruh JSON posts yang menyimpannya secara hardcode (text string) juga harus di-*update* manual. Dengan Many-to-Many, perubahan nama hanya perlu dilakukan sekali di tabel `tags`.

## Kesimpulan
Praktikum Jobsheet 15 telah mendemonstrasikan implementasi optimal untuk Many-to-Many Relationship. Dengan menghapus penyimpanan JSON tag yang redundan dan memindahkannya ke tabel referensi (`tags`) yang dihubungkan melalui pivot table (`post_tag`), struktur database kini telah dinormalisasi dengan baik. Dalam Filament, implementasinya terbukti sangat efisien dengan penggunaan modifier form `multiple()` pada Select berelasi dan kemampuan untuk menggunakan fitur native seperti Relationship Manager, Attach, dan Detach.
