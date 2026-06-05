# Laporan Praktikum Jobsheet 16 - RESTful API & Autentikasi

## Praktikum 1: Membuat Autentikasi Token pada RESTful API

Pada praktikum pertama, diimplementasikan sistem autentikasi berbasis token menggunakan Laravel Sanctum untuk RESTful API.

**1. Instalasi dan Setup Sanctum**
Package `laravel/sanctum` diinstal, kemudian konfigurasinya di-publish. Setelah konfigurasi database dan environment diatur, command `php artisan migrate` dijalankan. Model `User` di-update untuk menggunakan trait `HasApiTokens` yang memungkinkan pembuatan serta pencabutan token.

```php
// app/Models/User.php
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;
    // ...
}
```

**2. Pembuatan Custom Request dan Trait ApiResponse**
Untuk menangani format response standar API agar seragam, dibuat trait `ApiResponse` yang memiliki method `apiSuccess` dan `apiError`. Custom request dasar berupa abstract class `ApiRequest` juga dibuat agar semua form request yang mewarisinya otomatis me-return JSON dengan error 422 jika validasi gagal, tanpa meredirect ulang layaknya web route biasa. Class `RegisterRequest` dan `LoginRequest` kemudian diturunkan dari class ini.

```php
// app/Http/Requests/ApiRequest.php
abstract class ApiRequest extends FormRequest
{
    use ApiResponse;
    
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException($this->apiError(
            $validator->errors(), 
            'Validation errors', 
            422
        ));
    }
}
```

**3. Pembuatan AuthController**
Controller `Api\AuthController` menangani logika fungsional untuk fitur registrasi, login, dan logout. Token autentikasi dibuat melalui fungsi bawaan Sanctum yaitu `$user->createToken('auth_token')->plainTextToken;`. Pada endpoint logout, token akan di-revoke menggunakan `$request->user()->currentAccessToken()->delete();`.

**4. Konfigurasi Routes API**
Endpoint `/register` dan `/login` bersifat publik, sedangkan `/logout` diproteksi middleware `auth:sanctum` sehingga hanya dapat diakses dengan menyisipkan token di header `Authorization: Bearer <token>`.

```php
// routes/api.php
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});
```

---

## Praktikum 2: CRUD dalam RESTful API

Pada praktikum kedua, kami membuat sistem API Resource untuk mengelola `Todo` yang terhubung dengan akun user yang sedang login.

**1. Migration dan Model Todo**
Tabel `todos` didefinisikan dengan kolom `title`, `description`, boolean `done`, dan relasi foreign key `user_id` yang merujuk pada tabel `users`. Pada model `Todo`, atribut `fillable` dilengkapi, dan atribut `user_id` dimasukkan ke dalam properti `$hidden` agar id tidak bocor di JSON response.

**2. Validasi Autorisasi dengan TodoRequest**
Request `TodoRequest` dirancang untuk memvalidasi input sekaligus melakukan autentikasi kepemilikan data. Request akan membolehkan request `POST` yang membuat data baru, namun untuk aksi `PUT` atau `DELETE`, request ini akan memverifikasi apakah `$this->user()->id` cocok dengan `$todo->user_id`.

```php
// app/Http/Requests/TodoRequest.php
public function authorize(): bool
{
    if ($this->method() == 'POST') {
        return true;
    }

    $todo = $this->route('todo');
    return $todo && $this->user()->id == $todo->user_id;
}
```

**3. Implementasi TodoController**
Melalui resource controller `TodoController`, logika fungsional CRUD telah dibuat untuk method `index` (hanya menampilkan todo milik user terkait dengan pemanggilan `$request->user()->todos`), `store`, `show`, `update`, dan `destroy`. Proteksi tambahan juga diterapkan di level controller untuk memastikan `todo->user_id` sama dengan id user yang melakukan request.

**4. Penanganan Exception API (Laravel 11)**
Untuk memastikan request error dari API (seperti data yang tidak ditemukan) mengembalikan nilai berupa objek JSON dan bukan laman HTML, modifikasi Exception Handling dilakukan. Pada Laravel 11, file `bootstrap/app.php` dimodifikasi:

```php
// bootstrap/app.php
$exceptions->render(function (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e, Request $request) {
    if ($request->is('api/*')) {
        return response()->json([
            'success' => false,
            'message' => 'Resource not found',
            'errors' => null,
        ], 404);
    }
});
```

## Analisis & Diskusi

1. **Bagaimana Laravel Sanctum mengamankan RESTful API?**
   Sanctum mengelola Personal Access Tokens. Saat user login, Sanctum membuatkan string unik (token) yang disimpan dan dicocokkan kembali oleh middleware `auth:sanctum`. Tanpa token di header `Authorization`, request ke endpoint terproteksi akan tertolak dengan status 401 Unauthorized. Mekanisme ini ringan (berbasis token di database, bukan JWT statis) dan cocok bagi front-end mobile dan SPAs.

2. **Apa peranan abstract `ApiRequest` dibandingkan `FormRequest` standar?**
   Form Request Laravel standar dibangun untuk aplikasi web monolitik, di mana ia akan melakukan HTTP Redirect (302) kembali ke halaman form beserta message errors di dalam session jika validasi gagal. Dengan memodifikasi method `failedValidation()` di dalam `ApiRequest`, kita dapat memaksa respon berformat JSON yang spesifik untuk keperluan API.

3. **Mengapa implementasi authorize di custom request `TodoRequest` sangat penting?**
   Tanpa pengecekan otorisasi, sembarang pengguna yang sudah login (dan memiliki valid bearer token) akan dapat merubah atau menghapus Todo milik pengguna lain dengan cara menebak ID todo mereka (IDOR vulnerability). Kode `$this->user()->id == $todo->user_id` menjadi lapisan keamanan krusial untuk melindungi data personal pengguna.

## Kesimpulan

Praktikum Jobsheet 16 berjalan lancar dengan penyelesaian dua fitur esensial dari sebuah REST API, yaitu autentikasi Bearer Token menggunakan Laravel Sanctum (Praktikum 1) dan implementasi operasi CRUD yang terproteksi dan bersifat relasional dengan pengguna (Praktikum 2). API kini dapat digunakan dan diintegrasikan oleh client-side application (mobile/frontend) secara aman dan responsif melalui format kembalian JSON yang selalu seragam.
