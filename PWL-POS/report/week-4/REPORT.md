# Laporan Tugas Jobsheet 04 - PWL 2025/2026

## A. Properti $fillable dan $guarded

### Praktikum 1 - $fillable

**1. UserModel.php**
```php
protected $fillable = ['level_id', 'username', 'nama', 'password'];
```

**2. UserController.php - Method index()**
```php
public function index()
{
    $data = [
        'level_id' => 2,
        'username' => 'manager_tiga',
        'nama' => 'Manager 3',
        'password' => Hash::make('12345')
    ];
    UserModel::create($data);
    
    $user = UserModel::all();
    return view('user', ['data' => $user]);
}
```

**Hasil:** Data berhasil ditambahkan dengan mass assignment

---

## B. Retrieving Single Models

### Praktikum 2.1 - Retrieving Single Models

**Metode-Metode:**

```php
// 1. find() - by primary key
$user = UserModel::find(1);

// 2. first() - dengan where
$user = UserModel::where('level_id', 1)->first();

// 3. firstWhere() - shortcut
$user = UserModel::firstWhere('level_id', 1);

// 4. findOr() - dengan callback
$user = UserModel::findOr(1, ['username', 'nama'], function() {
    abort(404);
});

// 5. firstOr()
$user = UserModel::firstOr(['nama', 'username'], function() {
    abort(404);
});
```

**View untuk single record:**
```html
<td>{{ $data->user_id }}</td>
<td>{{ $data->username }}</td>
<td>{{ $data->nama }}</td>
<td>{{ $data->level_id }}</td>
```

---

### Praktikum 2.2 - Not Found Exceptions

**Tujuan:** Memahami cara menangani kondisi ketika data tidak ditemukan dengan exception.

#### Langkah-Langkah

**1. Method findOrFail()**

Mengambil data atau throw exception:

```php
$user = UserModel::findOrFail(1);
```

**Penjelasan:** Method `findOrFail()` mencari data berdasarkan primary key. Jika data ditemukan, akan mengembalikan model instance. Jika tidak ditemukan, akan throw `ModelNotFoundException` yang secara otomatis akan menampilkan halaman 404.

**2. Method firstOrFail()**

Mengambil data pertama atau throw exception:

```php
$user = UserModel::where('level_id', 1)->firstOrFail();
```

**Penjelasan:** Method `firstOrFail()` mengambil record pertama yang cocok dengan query. Jika tidak ada data yang cocok, akan throw `ModelNotFoundException` dan menampilkan halaman 404.

**Hasil:**
✅ Memahami penggunaan `findOrFail()` dan `firstOrFail()`
✅ Aplikasi secara otomatis menampilkan halaman 404 ketika data tidak ditemukan
✅ Exception handling lebih baik untuk kondisi data tidak ditemukan

---

### Praktikum 2.3 - Retrieving Aggregates

**Controller:**
```php
$user = UserModel::where('level_id', 2)->count();
```

**View:**
```html
<p>Jumlah data user dengan level_id = 2: {{ $data }}</p>
```

**Fungsi lain:** `sum()`, `max()`, `min()`, `avg()`

**Penjelasan:** 
- Parameter pertama: atribut yang digunakan untuk mencari record
- Parameter kedua: atribut tambahan jika perlu membuat record baru
- Jika data ditemukan, akan mengembalikan data tersebut
- Jika tidak ditemukan, akan membuat record baru dan menyimpannya ke database
- Return value: model instance

**2. Method firstOrNew()**

Mengambil atau menyiapkan model baru tanpa menyimpan:

```php
$user = UserModel::firstOrNew(
    ['username' => 'manager55'],
    ['nama' => 'Manager Lima Puluh Lima', 'password' => Hash::make('12345'), 'level_id' => 2]
);
$user->save();
```

**Penjelasan:**
- Parameter sama seperti `firstOrCreate()`
- Perbedaan: jika data tidak ditemukan, model baru hanya disiapkan (instantiated) tapi **belum disimpan** ke database
- Perlu memanggil method `save()` secara manual untuk menyimpan ke database
- Berguna ketika kita ingin memodifikasi data sebelum menyimpan

**3. Perbedaan firstOrCreate dan firstOrNew**

| Aspek | firstOrCreate | firstOrNew |
|-------|---------------|------------|
| Mencari data | Ya | Ya |
| firstOrCreate()** - Auto save:
```php
$user = UserModel::firstOrCreate(
    ['username' => 'manager33'],
    ['nama' => 'Manager Tiga Tiga', 'password' => Hash::make('12345'), 'level_id' => 2]
);
```

**firstOrNew()** - Perlu save manual:
```php
$user = UserModel::firstOrNew(
    ['username' => 'manager55'],
    ['nama' => 'Manager Lima Puluh Lima', 'password' => Hash::make('12345'), 'level_id' => 2]
);
$user->save();
```

| Method | Auto Save | Butuh save() |
|--------|-----------|--------------|
| firstOrCreate | Ya | Tidak |
| firstOrNew | Tidak | Ya |
// Setelah mengubah atribut
$user->nama = 'Admin Baru';

if ($user->isClean()) {
    echo "Model bersih"; // Tidak akan dieksekusi
} else {
    echo "Ada perubahan"; // Akan dieksekusi
}
```

**Penjelasan:**
- `isClean()` mengembalikan `true` jika tidak ada perubahan
- Kebalikan dari `isDirty()`
- Berguna untuk validasi sebelum save

**3. Method wasChanged()**

Method `wasChanged()` menentukan apakah ada atribut yang diubah saat model terakhir disimpan dalam siklus permintaan saat ini:

```php
$user = UserModel::find(1);
$user->username = 'newadmin';
$user->save();

// Cek setelah save
if ($user->wasChanged()) {
    echo "Data telah berubah dan disimpan";
}

// Cek kolom tertentu
if ($user->wasChanged('username')) {
    echo "Username telah diubah dan disimpan";
}
```

**Penjelasan:**
- `wasChanged()` mengecek perubahan **setelah** `save()` dipanggil
- Berguna untuk logging atau trigger event setelah perubahan disimpan
- Return `true` jika ada perubahan yang telah disimpan

**4. Perbedaan isDirty, isClean, dan wasChanged**
```php
$user = UserModel::find(1);
$user->username = 'admin123';

// isDirty() - cek perubahan sebelum save
if ($user->isDirty()) { }
if ($user->isDirty('username')) { }

// isClean() - kebalikan isDirty
if ($user->isClean()) { }

// wasChanged() - cek perubahan setelah save
$user->save();
if ($user->wasChanged()) { }
if ($user->wasChanged('username')) { }
```

| Method | Waktu | Fungsi |
|--------|-------|--------|
| isDirty() | Sebelum save | Cek ada perubahan |
| isClean() | Sebelum save | Cek tidak ada perubahan |
| wasChanged() | Setelah save | Cek perubahan tersimpan |
Membuat view `user_tambah.blade.php`:

```html
<h1>Tambah Data User</h1>
<form action="{{ url('/user/tambah_simpan') }}" method="post">
    @csrf
    <div class="form-group">
        <label>Username:</label>
        <input type="text" name="username" required>
    </div>
    <div class="form-group">
        <label>Nama:</label>
        <input type="text" name="nama" required>
    </div>
    <div class="form-group">
        <label>Password:</label>
        <input type="password" name="password" required>
    </div>
    <div class="form-group">
        <label>Level ID:</label>
        <input type="number" name="level_id" required>
    </div>
    <button type="submit">Simpan</button>
    <a href="{{ url('/user') }}">Kembali</a>
</form>
```

Menambahkan routes di `web.php`:

```php
Route::get('/user/tambah', [UserController::class, 'tambah']);
Route::post('/user/tambah_simpan', [UserController::class, 'tambah_simpan']);
```

**Penjelasan:**
- Form tambah data dengan CSRF protection
- Password di-hash menggunakan `Hash::make()`
- Setelah simpan, redirect kembali ke halaman list user

**3. UPDATE - Ubah Data User**

Menambahkan method `ubah()` dan `ubah_simpan()` di `UserController.php`:

```php
public function ubah($id)
{
    $user = UserModel::find($id);
    return view('user_ubah', ['data' => $user]);
}

public function ubah_simpan($id, Request $request)
{
    $user = UserModel::find($id);
    
    $user->username = $request->username;
    $user->nama = $request->nama;
    $user->password = Hash::make($request->password);
    $user->level_id = $request->level_id;
    
    $user->save();
    
    return redirect('/user');
}
```

Membuat view `user_ubah.blade.php`:

```html
<h1>Ubah Data User</h1>
<form action="{{ url('/user/ubah_simpan/' . $data->user_id) }}" method="post">
    @csrf
    <div class="form-group">
        <label>Username:</label>
        <input type="text" name="username" value="{{ $data->username }}" required>
    </div>
    <div class="form-group">
        <label>Nama:</label>
        <input type="text" name="nama" value="{{ $data->nama }}" required>
    </div>
    <div class="form-group">
        <label>Password:</label>
        <input type="password" name="password" required>
    </div>
    <div class="form-group">
        <label>Level ID:</label>
        <input type="number" name="level_id" value="{{ $data->level_id }}" required>
    </div>
    <button type="submit">Ubah</button>
    <a href="{{ url('/user') }}">Kembali</a>
</form>
```

Menambahkan routes di `web.php`:

```php
Route::get('/user/ubah/{id}', [UserController::class, 'ubah']);
Route::post('/user/ubah_simpan/{id}', [UserController::class, 'ubah_simpan']);
```

**Penjelasan:**RUD Operations

**READ - UserController.php:**
```php
public function index()
{
    $user = UserModel::with('level')->get();
    return view('user', ['data' => $user]);
}
```

**CREATE:**
```php
public function tambah()
{
    return view('user_tambah');
}

public function tambah_simpan(Request $request)
{
    UserModel::create([
        'username' => $request->username,
        'nama' => $request->nama,
        'password' => Hash::make($request->password),
        'level_id' => $request->level_id
    ]);
    return redirect('/user');
}
```

**UPDATE:**
```php
public function ubah($id)
{
    $user = UserModel::find($id);
    return view('user_ubah', ['data' => $user]);
}

public function ubah_simpan($id, Request $request)
{
    $user = UserModel::find($id);
    $user->username = $request->username;
    $user->nama = $request->nama;
    $user->password = Hash::make($request->password);
    $user->level_id = $request->level_id;
    $user->save();
    return redirect('/user');
}
```

**DELETE:**
```php
public function hapus($id)
{
    $user = UserModel::find($id);
    $user->delete();
    return redirect('/user');
}
```

**Routes:**
```php
Route::get('/user', [UserController::class, 'index']);
Route::get('/user/tambah', [UserController::class, 'tambah']);
Route::post('/user/tambah_simpan', [UserController::class, 'tambah_simpan']);
Route::get('/user/ubah/{id}', [UserController::class, 'ubah']);
Route::post('/user/ubah_simpan/{id}', [UserController::class, 'ubah_simpan']);
Route::get('/user/hapus/{id}', [UserController::class, 'hapus']);
```e new model
   - Perbedaan antara keduanya dalam hal save ke database

6. **Attribute Changes Tracking**
   - `isDirty()` - cek perubahan sebelum save
   - `isClean()` - cek model tanpa perubahan
   - `wasChanged()` - cek perubahan setelah save
   - Berguna untuk validasi dan audit trail

7. **CRUD Operations**
   - **Create**: Form input dan save data baru
   - **Read**: Menampilkan list data dengan pagination
   - **Update**: Edit data existing dengan form
   - **Delete**: Hapus data dengan konfirmasi
   - Form dengan CSRF protection dan validasi

8. **Eloquent Relationships**
   - **Belongs To (One to One Inverse)**: User belongs to Level
   - **Has Many (One to Many)**: Level has many Users
   - **Eager Loading**: Optimasi query dengan `with()`
   - **Lazy Loading**: Akses relationship on-demand
   - Menghindari N+1 query problem

**UserModel.php - Belongs To:**
```php
public function level(): BelongsTo
{
    return $this->belongsTo(Level::class, 'level_id', 'level_id');
}
```

**Level.php - Has Many:**
```php
public function users(): HasMany
{
    return $this->hasMany(UserModel::class, 'level_id', 'level_id');
}
```

**Controller - Eager Loading:**
```php
$user = UserModel::with('level')->get();
```

**View:**
```html
<td>{{ $d->level->level_nama }}</td>
```