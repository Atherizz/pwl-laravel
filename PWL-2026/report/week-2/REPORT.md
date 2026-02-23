## Praktikum 1

### Route user
![Screenshot](/PWL-2026/report/week-2/img/user.png)

### Route posts/{id}/comment
  ![Screenshot](/PWL-2026/report/week-2/img/praktikum-1.png)

###  Membuat route /articles/{id} yang akan menampilkan output “Halaman Artikel  dengan ID {id}”

 ![Screenshot](/PWL-2026/report/week-2/img/artikel.png)

 ### Optional Parameter

Tanpa Parameter
![Screenshot](/PWL-2026/report/week-2/img/without-param.png)

Dengan Parameter
![Screenshot](/PWL-2026/report/week-2/img/user.png)

## Praktikum 2

### 1. PageController - Modifikasi Route dengan Controller

Membuat PageController dengan methods:
- `index()` untuk route `/` - menampilkan "Selamat Datang"
- `about()` untuk route `/about` - menampilkan NIM dan Nama
- `articles($id)` untuk route `/articles/{id}` - menampilkan halaman artikel dengan ID


### 2. Single Action Controllers

Modifikasi implementasi menggunakan Single Action Controller:
- **HomeController** - menangani route `/`
- **AboutController** - menangani route `/about`
- **ArticleController** - menangani route `/articles/{id}`

Setiap controller menggunakan method `__invoke()` sebagai single action.


### 3. Resource Controller - PhotoController

Membuat PhotoController dengan perintah:
```bash
php artisan make:controller PhotoController --resource
```

Controller ini otomatis memiliki methods untuk CRUD:
- `index()` - menampilkan daftar photos
- `create()` - menampilkan form create
- `store()` - menyimpan data baru
- `show($id)` - menampilkan detail photo
- `edit($id)` - menampilkan form edit
- `update($id)` - update data
- `destroy($id)` - hapus data

Route resource ditambahkan di `web.php`:
```php
Route::resource('photos', PhotoController::class);
```

#### Route List untuk 

**Pengamatan:**
Resource route secara otomatis membuat 7 routes untuk operasi CRUD lengkap. Jika tidak semua route dibutuhkan, dapat menggunakan method `only()` atau `except()` untuk membatasi routes yang di-generate.

#### Route Resource dengan Only
```php
Route::resource('photos', PhotoController::class)->only(['index', 'show']);
```

#### Route Resource dengan Except
```php
Route::resource('photos', PhotoController::class)->except(['create', 'store', 'update', 'destroy']);
```

## Praktikum 3

### 1. Membuat View hello.blade.php

Membuat file `resources/views/blog/hello.blade.php`:
```html
<html>
<body>
    <h1>Hello, {{ $name }}</h1>
    <h1>You are {{ $occupation }}</h1>
</body>
</html>
```

### 2. Menampilkan View melalui Route

Route `/greeting` ditambahkan untuk menampilkan view dengan data:
```php
Route::get('/greeting', function () {
    return view('hello', ['name' => 'Andi']);
});
```

#### Output Route /greeting
![Screenshot](/PWL-2026/report/week-2/img/greeting-route.png)

**Pengamatan:**
View dapat dipanggil melalui helper function `view()` dengan parameter pertama adalah nama file (tanpa `.blade.php`) dan parameter kedua adalah array data yang akan dikirim ke view. Data dapat diakses di view menggunakan sintaks Blade `{{ $variable }}`.

### 3. View dalam Direktori

File `hello.blade.php` dipindahkan ke direktori `resources/views/blog/`.

Route diubah menggunakan dot notation untuk mereferensikan direktori:
```php
Route::get('/greeting', function () {
    return view('blog.hello', ['name' => 'Andi']);
});
```

**Pengamatan:**
Dot notation (`.`) digunakan untuk mereferensikan file view yang berada dalam subdirectory. `blog.hello` berarti Laravel akan mencari file di `resources/views/blog/hello.blade.php`.

### 4. Menampilkan View dari Controller

Menambahkan method `greeting()` di WelcomeController:
```php
public function greeting() {
    return view('blog.hello', ['name' => 'Andi']);
}
```

Route diubah untuk memanggil controller:
```php
Route::get('/greeting', [WelcomeController::class, 'greeting']);
```


**Pengamatan:**
Memisahkan logika view ke controller membuat kode lebih terorganisir dan mudah di-maintain. Controller bertindak sebagai penghubung antara route dan view.

### 5. Meneruskan Data ke View dengan Method with()

Method `greeting()` diubah menggunakan method chaining dengan `with()`:
```php
public function greeting() {
    return view('blog.hello')
        ->with('name', 'Andi')
        ->with('occupation', 'Astronaut');
}
```

View `hello.blade.php` diupdate untuk menampilkan 2 parameter:
```html
<html>
<body>
    <h1>Hello, {{ $name }}</h1>
    <h1>You are {{ $occupation }}</h1>
</body>
</html>
```

**Pengamatan:**
Method `with()` memberikan alternatif untuk passing data ke view dengan cara yang lebih readable, terutama ketika data yang dikirim banyak. Method ini dapat di-chain berkali-kali untuk mengirim multiple data. Di view, semua variable yang dikirim dapat diakses langsung menggunakan sintaks Blade `{{ $variable }}`.




