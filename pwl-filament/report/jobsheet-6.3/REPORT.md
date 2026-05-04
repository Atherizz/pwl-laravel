# Laporan Tugas Jobsheet 6.3 - PWL 2025/2026

## Langkah-Langkah Praktikum

**1. Implementasi Validasi Dasar**
Validasi dasar telah diterapkan pada field-field utama dalam form Post. Menggunakan method `required()`, kita memastikan bahwa Title, Slug, Category, dan Image tidak boleh kosong. Selain itu, batasan panjang karakter juga diterapkan pada Title (min: 5, max: 100) dan Slug (min: 3).

**2. Validasi Unik pada Slug**
Field Slug dikonfigurasi agar nilainya unik di database menggunakan `unique(ignoreRecord: true)`. Parameter `ignoreRecord: true` memastikan bahwa saat melakukan update data, validasi unik tidak akan memicu error jika admin tidak mengubah nilai slug dari record yang bersangkutan.
```php
\Filament\Forms\Components\TextInput::make('slug')
    ->required()
    ->minLength(3)
    ->unique(ignoreRecord: true)
```

**3. Kustomisasi Pesan Error (Custom Messages)**
Untuk meningkatkan aspek user experience, pesan error default dari Laravel/Filament diganti dengan bahasa yang lebih spesifik menggunakan method `validationMessages()`. Contohnya pada field Slug dan Image:
```php
->validationMessages([
    'unique' => 'Slug harus unik dan tidak boleh sama.',
    'required' => 'Gambar utama wajib diupload.',
])
```

**4. Pengujian Validasi**
Dilakukan pengujian dengan berbagai skenario:
- Mengosongkan field wajib untuk memicu error `required`.
- Mengisi judul kurang dari 5 karakter untuk memicu error `min length`.
- Mengisi slug yang sudah terdaftar untuk memicu error `unique` kustom.

## Analisis & Diskusi

1. **Mengapa validasi penting pada admin panel?**
   Validasi sangat krusial untuk menjaga integritas dan kualitas data. Admin panel seringkali menjadi pintu utama masuknya data ke sistem; validasi mencegah masuknya data sampah, format yang tidak kompatibel, atau duplikasi data yang dapat merusak logika aplikasi di sisi front-end.

2. **Apa perbedaan validasi client-side dan server-side?**
   Validasi *client-side* memberikan respon cepat tanpa reload halaman namun mudah dimanipulasi oleh pengguna ahli. Validasi *server-side* (yang diimplementasikan di Filament/Laravel) adalah pertahanan terakhir yang mutlak; ia menjamin keamanan data karena divalidasi langsung oleh logika server sebelum masuk ke database.

3. **Mengapa unique otomatis bekerja saat edit data?**
   Berkat integrasi Filament dengan Eloquent, penggunaan `ignoreRecord: true` memerintahkan Laravel untuk mengecualikan ID dari record yang sedang diedit dalam pencarian duplikasi di database. Hal ini memungkinkan proses "Save" berjalan lancar selama slug tersebut tidak digunakan oleh record lain.

4. **Kapan kita perlu menggunakan rules array dibanding string?**
   Format array (`['required', 'min:3']`) lebih disarankan saat aturan validasi menjadi sangat panjang atau ketika kita perlu menggunakan objek class (seperti `Rule::exists()`). Penggunaan array menghindari kesalahan penulisan yang sering terjadi pada format string dengan pemisah pipe (`|`).

## Kesimpulan
Melalui Jobsheet 6.3 ini, sistem validasi telah berhasil diintegrasikan ke dalam form Resource Post. Penggunaan kombinasi method bawaan Filament dan aturan validasi Laravel memberikan keamanan data yang kuat, sementara fitur kustomisasi pesan error membantu admin memahami kesalahan input dengan lebih baik.
