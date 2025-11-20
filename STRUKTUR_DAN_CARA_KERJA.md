# 📚 Penjelasan Struktur Code dan Cara Kerja Aplikasi

## 🎯 Apa Aplikasi Ini?

Aplikasi ini adalah **website e-commerce untuk toko matcha** bernama "Alvca Matcha". Aplikasi ini dibuat menggunakan framework **Laravel** (PHP) dan memungkinkan:
- Pengunjung melihat produk matcha
- User terdaftar membeli produk (menambahkan ke keranjang)
- Admin mengelola produk (tambah, edit, hapus)

---

## 🏗️ Arsitektur Aplikasi (MVC Pattern)

Aplikasi ini menggunakan pola **MVC (Model-View-Controller)**:

```
User Request → Route → Controller → Model (Database) → View → Response
```

**Penjelasan singkat:**
- **Model**: Representasi data dari database (User, Menu, Keranjang)
- **View**: Tampilan yang dilihat user (file `.blade.php`)
- **Controller**: Logika bisnis yang menghubungkan Model dan View

---

## 📁 Struktur Folder Utama

### 1. **`app/`** - Inti Aplikasi
```
app/
├── Http/
│   ├── Controllers/          # Semua controller ada di sini
│   │   ├── ProductController.php      # Menampilkan produk untuk user
│   │   ├── KeranjangController.php    # Mengelola keranjang belanja
│   │   ├── UserController.php         # Mengelola profil user
│   │   └── Admin/
│   │       └── ProductController.php  # Admin CRUD produk
│   └── Middleware/
│       └── EnsureUserIsAdmin.php     # Cek apakah user adalah admin
│
└── Models/                    # Model database
    ├── User.php              # Model untuk tabel users
    ├── Menu.php              # Model untuk tabel menus (produk)
    └── Keranjang.php         # Model untuk tabel keranjangs (cart)
```

**Penjelasan:**
- **Controllers**: Menangani request dari user, mengambil data dari Model, lalu mengirim ke View
- **Models**: Menghubungkan dengan database, satu model = satu tabel
- **Middleware**: Filter yang berjalan sebelum request sampai ke controller (contoh: cek login, cek admin)

### 2. **`routes/`** - Rute Aplikasi
```
routes/
└── web.php    # Semua URL yang bisa diakses user
```

**Contoh di `web.php`:**
```php
Route::get('/products', [ProductController::class, 'products']);
// Artinya: ketika user akses /products, 
//          jalankan method 'products' di ProductController
```

### 3. **`resources/views/`** - Tampilan (HTML)
```
resources/views/
├── layouts/
│   └── mainlayout.blade.php    # Template dasar semua halaman
├── includes/
│   ├── navigation.blade.php     # Menu navigasi
│   └── footer.blade.php         # Footer
├── home.blade.php               # Halaman beranda
├── products.blade.php           # Halaman daftar produk
├── keranjang/
│   └── keranjang.blade.php      # Halaman keranjang
├── about.blade.php              # Halaman tentang kami
├── contact.blade.php            # Halaman kontak
└── admin/
    └── products/
        ├── index.blade.php      # Admin: daftar produk
        ├── create.blade.php     # Admin: form tambah produk
        └── edit.blade.php       # Admin: form edit produk
```

**Penjelasan:**
- File `.blade.php` adalah template Laravel yang bisa menampilkan data dari controller
- `@extends('layouts.mainlayout')` = menggunakan template dasar
- `@section('content')` = bagian konten yang akan diisi

### 4. **`database/`** - Database
```
database/
├── migrations/              # Struktur tabel database
│   ├── create_users_table.php      # Tabel users
│   ├── create_menus_table.php     # Tabel menus (produk)
│   └── create_keranjangs_table.php # Tabel keranjangs
└── seeders/                # Data awal
    ├── MenuSeeder.php       # Data produk awal
    └── AdminUserSeeder.php  # Data admin awal
```

---

## 🔄 Alur Kerja Aplikasi (Flow)

### Contoh 1: User Mengakses Halaman Produk

```
1. User klik link "Products" di menu
   ↓
2. Browser request: GET /products
   ↓
3. Route (web.php) menerima request
   Route::get('/products', [ProductController::class, 'products']);
   ↓
4. ProductController::products() dipanggil
   - Mengambil semua data Menu dari database
   - Mengirim data ke view 'products'
   ↓
5. View products.blade.php ditampilkan
   - Menampilkan semua produk dengan gambar, nama, harga
   ↓
6. User melihat halaman produk
```

### Contoh 2: User Menambahkan Produk ke Keranjang

```
1. User klik "Tambah ke Keranjang" di halaman produk
   ↓
2. Form submit: POST /keranjang
   Data: menu_id=1, qty=2
   ↓
3. Route menerima request
   Route::post('/keranjang', [KeranjangController::class, 'store']);
   ↓
4. Middleware 'auth' cek: apakah user sudah login?
   - Jika belum → redirect ke login
   - Jika sudah → lanjut
   ↓
5. KeranjangController::store() dipanggil
   - Validasi data (menu_id dan qty harus ada)
   - Cek apakah produk sudah ada di keranjang user
   - Jika sudah ada: tambah qty
   - Jika belum: buat record baru
   - Hitung total_harga = qty × harga_produk
   - Simpan ke database
   ↓
6. Redirect kembali ke halaman produk dengan pesan sukses
```

### Contoh 3: Admin Mengelola Produk

```
1. Admin login dengan email: admin@alvcamatcha.com
   ↓
2. Admin klik "Admin" di menu
   ↓
3. Request: GET /admin/products
   ↓
4. Middleware 'auth' cek: user sudah login? ✓
   ↓
5. Middleware 'admin' cek: role user = 'admin'?
   - Jika bukan admin → error 403 (Forbidden)
   - Jika admin → lanjut
   ↓
6. AdminProductController::index() dipanggil
   - Ambil semua produk dari database
   - Kirim ke view admin/products/index
   ↓
7. Admin melihat daftar produk dengan tombol Edit/Hapus
```

---

## 🗄️ Struktur Database

### Tabel 1: `users`
| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | integer | Primary key |
| name | string | Nama user |
| email | string | Email (unique) |
| password | string | Password (terenkripsi) |
| role | enum | 'user' atau 'admin' |
| created_at | timestamp | Waktu dibuat |

### Tabel 2: `menus` (Produk)
| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | integer | Primary key |
| nama | string | Nama produk |
| deskripsi | text | Deskripsi produk |
| harga | decimal | Harga produk |
| gambar | string | Nama file gambar |
| created_at | timestamp | Waktu dibuat |

### Tabel 3: `keranjangs` (Cart)
| Kolom | Tipe | Keterangan |
|-------|------|------------|
| id | integer | Primary key |
| user_id | integer | Foreign key ke users |
| menu_id | integer | Foreign key ke menus |
| qty | integer | Jumlah produk |
| total_harga | integer | qty × harga produk |
| created_at | timestamp | Waktu dibuat |

**Relasi:**
- Satu User bisa punya banyak Keranjang
- Satu Menu bisa ada di banyak Keranjang
- Satu Keranjang punya satu User dan satu Menu

---

## 🔐 Sistem Autentikasi & Authorization

### Autentikasi (Login)
- User harus login untuk:
  - Menambahkan produk ke keranjang
  - Melihat keranjang
  - Mengakses profil

**Cara kerja:**
1. User input email & password di form login
2. Laravel Breeze mengecek di database
3. Jika benar → buat session, user "logged in"
4. Session disimpan, user bisa akses halaman terproteksi

### Authorization (Role)
- Ada 2 role: `user` dan `admin`
- **User biasa** bisa:
  - Lihat produk
  - Tambah ke keranjang
  - Edit profil sendiri
  
- **Admin** bisa:
  - Semua yang user biasa bisa
  - **PLUS**: CRUD produk (Create, Read, Update, Delete)

**Cara kerja:**
```php
// Di middleware EnsureUserIsAdmin.php
if (Auth::user()->role !== 'admin') {
    abort(403); // Error: tidak punya akses
}
```

---

## 🎨 Frontend (Tampilan)

### Teknologi yang digunakan:
- **Tailwind CSS**: Framework CSS untuk styling
- **Blade Template**: Template engine Laravel

### Layout System:
```
mainlayout.blade.php (template dasar)
├── Navigation (menu atas)
├── @yield('content') ← konten halaman diisi di sini
└── Footer
```

**Contoh di products.blade.php:**
```php
@extends('layouts.mainlayout')  // Pakai template dasar
@section('content')            // Isi bagian content
    // HTML untuk halaman produk
@endsection
```

---

## 📝 Fitur-Fitur Utama

### 1. **Halaman Publik** (Tanpa Login)
- `/` - Home: Menampilkan hero dan produk
- `/products` - Daftar semua produk
- `/about` - Tentang kami
- `/contact` - Kontak

### 2. **Fitur User** (Perlu Login)
- `/keranjang` - Lihat keranjang belanja
  - Tambah produk (dari halaman products)
  - Update jumlah (+ / -)
  - Hapus produk dari keranjang
- `/my-profile` - Kelola profil
  - Edit nama
  - Ganti password
  - Hapus akun

### 3. **Fitur Admin** (Perlu Login + Role Admin)
- `/admin/products` - Kelola produk
  - Lihat semua produk
  - Tambah produk baru (dengan upload gambar)
  - Edit produk
  - Hapus produk

---

## 🔧 File-File Penting yang Perlu Dipahami

### 1. `routes/web.php`
**Fungsi:** Mendefinisikan semua URL yang bisa diakses
```php
Route::get('/products', [ProductController::class, 'products']);
// URL: /products → ProductController@products
```

### 2. `app/Http/Controllers/ProductController.php`
**Fungsi:** Menangani logika untuk halaman produk
```php
public function products() {
    $menus = Menu::all();  // Ambil semua produk
    return view('products', compact('menus'));  // Kirim ke view
}
```

### 3. `app/Models/Menu.php`
**Fungsi:** Representasi tabel `menus` di database
```php
class Menu extends Model {
    protected $fillable = ['nama', 'deskripsi', 'harga', 'gambar'];
    // Kolom yang bisa diisi langsung
}
```

### 4. `resources/views/products.blade.php`
**Fungsi:** Tampilan halaman produk
```php
@foreach($menus as $menu)
    <h2>{{ $menu->nama }}</h2>
    <p>Rp {{ number_format($menu->harga) }}</p>
@endforeach
```

---

## 🚀 Cara Menjalankan Aplikasi

1. **Install dependencies:**
   ```bash
   composer install
   npm install
   ```

2. **Setup database:**
   ```bash
   php artisan migrate        # Buat tabel
   php artisan db:seed        # Isi data awal
   ```

3. **Jalankan server:**
   ```bash
   php artisan serve
   ```

4. **Akses di browser:**
   - `http://localhost:8000`

---

## 📌 Kesimpulan

**Struktur sederhana:**
1. **User request** → URL tertentu
2. **Route** → menentukan controller mana yang dipanggil
3. **Controller** → ambil data dari Model (database)
4. **View** → tampilkan data dalam bentuk HTML
5. **Response** → kirim HTML ke browser

**Pola yang sama digunakan di semua fitur:**
- User melihat produk → ProductController → Menu Model → products.blade.php
- User tambah ke keranjang → KeranjangController → Keranjang Model → redirect
- Admin kelola produk → AdminProductController → Menu Model → admin/products/index.blade.php

**Keamanan:**
- Middleware `auth` → cek login
- Middleware `admin` → cek role admin
- Password di-hash (tidak bisa dibaca langsung)

---

## 💡 Tips untuk Memahami Code

1. **Mulai dari `routes/web.php`** - lihat URL apa saja yang ada
2. **Cari Controller yang dipanggil** - lihat logika bisnisnya
3. **Cari Model yang digunakan** - lihat struktur datanya
4. **Cari View yang ditampilkan** - lihat tampilannya

**Contoh tracing:**
- URL: `/products` 
- → Route: `ProductController@products`
- → Controller: ambil `Menu::all()`
- → View: `products.blade.php` menampilkan data

---

**Selamat belajar! 🎉**








