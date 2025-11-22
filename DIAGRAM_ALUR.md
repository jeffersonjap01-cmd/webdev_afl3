# 📊 Diagram Alur Aplikasi

## 1. Alur Request Umum (MVC Pattern)

```
┌─────────────┐
│   Browser   │
│   (User)    │
└──────┬──────┘
       │ 1. Request URL
       │    (contoh: /products)
       ↓
┌─────────────────┐
│   routes/web.php│  ← 2. Route menentukan controller
└────────┬────────┘
         │
         ↓
┌──────────────────────┐
│   Controller         │  ← 3. Controller ambil data
│   (ProductController)│
└────────┬─────────────┘
         │
         ↓
┌──────────────────────┐
│   Model              │  ← 4. Model query database
│   (Menu)             │
└────────┬─────────────┘
         │
         ↓
┌──────────────────────┐
│   Database           │  ← 5. Database return data
│   (SQLite)           │
└────────┬─────────────┘
         │
         ↓
┌──────────────────────┐
│   Controller         │  ← 6. Controller kirim ke view
│   return view(...)   │
└────────┬─────────────┘
         │
         ↓
┌──────────────────────┐
│   View               │  ← 7. View render HTML
│   (products.blade)   │
└────────┬─────────────┘
         │
         ↓
┌─────────────┐
│   Browser   │  ← 8. User lihat halaman
│   (User)    │
└─────────────┘
```

---

## 2. Alur User Menambahkan Produk ke Keranjang

```
User di halaman Products
         │
         │ Klik "Tambah ke Keranjang"
         │ (Form submit dengan menu_id & qty)
         ↓
┌────────────────────┐
│  POST /keranjang   │
└─────────┬──────────┘
          │
          ↓
┌─────────────────────┐
│  Middleware: auth   │  ← Cek apakah user sudah login?
└─────────┬───────────┘
          │
     ┌────┴────┐
     │         │
  Belum      Sudah
  Login      Login
     │         │
     ↓         ↓
  Redirect  Lanjut ke
  ke Login   Controller
     │         │
     │         ↓
     │  ┌──────────────────────┐
     │  │ KeranjangController  │
     │  │ ::store()            │
     │  └──────────┬───────────┘
     │             │
     │             ↓
     │  ┌──────────────────────┐
     │  │ Validasi Data        │
     │  │ - menu_id required   │
     │  │ - qty required      │
     │  └──────────┬───────────┘
     │             │
     │             ↓
     │  ┌──────────────────────┐
     │  │ Cek apakah produk     │
     │  │ sudah ada di cart?   │
     │  └──────────┬───────────┘
     │             │
     │      ┌──────┴──────┐
     │      │             │
     │    Ya (ada)      Tidak (baru)
     │      │             │
     │      ↓             ↓
     │  Update qty    Create record
     │  + total_harga  baru
     │      │             │
     │      └──────┬───────┘
     │             │
     │             ↓
     │  ┌──────────────────────┐
     │  │ Simpan ke Database   │
     │  │ (tabel keranjangs)   │
     │  └──────────┬───────────┘
     │             │
     │             ↓
     │  ┌──────────────────────┐
     │  │ Redirect kembali     │
     │  │ dengan pesan sukses  │
     │  └──────────────────────┘
     │
     └──────────────────────────┘
```

---

## 3. Alur Admin Mengelola Produk

```
Admin Login
    │
    │ Klik "Admin" di menu
    ↓
┌─────────────────────┐
│ GET /admin/products │
└──────────┬──────────┘
           │
           ↓
┌─────────────────────┐
│ Middleware: auth    │  ← Cek login
└──────────┬──────────┘
           │
           ↓
┌─────────────────────┐
│ Middleware: admin   │  ← Cek role = 'admin'
└──────────┬──────────┘
           │
      ┌────┴────┐
      │         │
   Bukan      Admin
   Admin      ✓
      │         │
      ↓         ↓
   Error    Lanjut ke
   403      Controller
      │         │
      │         ↓
      │  ┌──────────────────────┐
      │  │ AdminProductController│
      │  │ ::index()            │
      │  └──────────┬───────────┘
      │             │
      │             ↓
      │  ┌──────────────────────┐
      │  │ Menu::all()          │
      │  │ (ambil semua produk) │
      │  └──────────┬───────────┘
      │             │
      │             ↓
      │  ┌──────────────────────┐
      │  │ return view(          │
      │  │   'admin.products.   │
      │  │    index',           │
      │  │   compact('menus')   │
      │  │ )                     │
      │  └──────────┬───────────┘
      │             │
      │             ↓
      │  ┌──────────────────────┐
      │  │ View: admin/products/ │
      │  │ index.blade.php      │
      │  │ (tampilkan tabel)    │
      │  └──────────────────────┘
      │
      └──────────────────────────┘
```

---

## 4. Struktur Database & Relasi

```
┌──────────────┐
│    users     │
├──────────────┤
│ id (PK)      │
│ name         │
│ email        │
│ password     │
│ role         │──┐
└──────────────┘  │
                  │ 1:N (satu user punya banyak keranjang)
                  │
                  ↓
┌──────────────────────┐
│    keranjangs        │
├──────────────────────┤
│ id (PK)              │
│ user_id (FK) ────────┘
│ menu_id (FK) ────────┐
│ qty                  │
│ total_harga          │
└──────────────────────┘
                  │
                  │ N:1 (banyak keranjang punya satu menu)
                  │
                  ↓
┌──────────────┐
│    menus     │
├──────────────┤
│ id (PK)      │
│ nama         │
│ deskripsi    │
│ harga        │
│ gambar       │
└──────────────┘

Keterangan:
- PK = Primary Key (unik, auto increment)
- FK = Foreign Key (referensi ke tabel lain)
- 1:N = One to Many (satu ke banyak)
- N:1 = Many to One (banyak ke satu)
```

---

## 5. Struktur Folder & File Penting

```
webdev_afl3-1/
│
├── app/                          # Inti aplikasi
│   ├── Http/
│   │   ├── Controllers/         # Semua controller
│   │   │   ├── ProductController.php
│   │   │   ├── KeranjangController.php
│   │   │   ├── UserController.php
│   │   │   └── Admin/
│   │   │       └── ProductController.php
│   │   └── Middleware/
│   │       └── EnsureUserIsAdmin.php
│   └── Models/                   # Model database
│       ├── User.php
│       ├── Menu.php
│       └── Keranjang.php
│
├── routes/
│   └── web.php                   # Semua URL/rute
│
├── resources/
│   └── views/                    # Tampilan HTML
│       ├── layouts/
│       │   └── mainlayout.blade.php
│       ├── includes/
│       │   ├── navigation.blade.php
│       │   └── footer.blade.php
│       ├── home.blade.php
│       ├── products.blade.php
│       ├── keranjang/
│       │   └── keranjang.blade.php
│       └── admin/
│           └── products/
│               ├── index.blade.php
│               ├── create.blade.php
│               └── edit.blade.php
│
├── database/
│   ├── migrations/               # Struktur tabel
│   │   ├── create_users_table.php
│   │   ├── create_menus_table.php
│   │   └── create_keranjangs_table.php
│   └── seeders/                  # Data awal
│       ├── MenuSeeder.php
│       └── AdminUserSeeder.php
│
└── public/                        # File yang bisa diakses langsung
    └── images/                    # Gambar produk
```

---

## 6. Flow Authentication (Login)

```
User Input Email & Password
         │
         ↓
┌─────────────────────┐
│ Login Form Submit   │
│ POST /login         │
└──────────┬──────────┘
           │
           ↓
┌─────────────────────┐
│ AuthenticatedSession│
│ Controller          │
└──────────┬──────────┘
           │
           ↓
┌─────────────────────┐
│ Validasi Input      │
│ - Email format      │
│ - Password required │
└──────────┬──────────┘
           │
           ↓
┌─────────────────────┐
│ Cek di Database     │
│ User::where('email') │
└──────────┬───────────┘
           │
      ┌────┴────┐
      │         │
   Tidak      Ada
   Ditemukan  User
      │         │
      ↓         ↓
  Error     Cek Password
  "Invalid  (Hash::check)
  credentials" │
      │         │
      │    ┌────┴────┐
      │    │         │
      │  Salah    Benar
      │    │         │
      │    ↓         ↓
      │  Error    Auth::login()
      │  "Invalid  (buat session)
      │  password" │
      │    │         │
      │    │         ↓
      │    │  ┌─────────────────┐
      │    │  │ Redirect ke      │
      │    │  │ halaman awal     │
      │    │  │ (user logged in) │
      │    │  └─────────────────┘
      │    │
      └────┴──────────────────────┘
```

---

## 7. Role-Based Access Control

```
User Request ke /admin/products
         │
         ↓
┌─────────────────────┐
│ Middleware: auth     │
│ (cek login)         │
└──────────┬───────────┘
           │
      ┌────┴────┐
      │         │
   Tidak      Sudah
   Login      Login
      │         │
      ↓         ↓
  Redirect   Lanjut
  ke Login   │
             ↓
┌─────────────────────┐
│ Middleware: admin    │
│ (cek role)          │
└──────────┬───────────┘
           │
      ┌────┴────┐
      │         │
   role =     role =
   'user'     'admin'
      │         │
      ↓         ↓
  Error 403  Lanjut ke
  (Forbidden) Controller
      │         │
      │         ↓
      │  ┌──────────────────────┐
      │  │ AdminProductController│
      │  │ (akses diberikan)    │
      │  └──────────────────────┘
      │
      └──────────────────────────┘
```

---

## 8. CRUD Operations (Admin)

```
┌─────────────────────────────────────────┐
│         ADMIN PRODUCT MANAGEMENT         │
└─────────────────────────────────────────┘

CREATE (Tambah Produk)
──────────────────────
1. GET /admin/products/create
   → AdminProductController::create()
   → View: create.blade.php (form kosong)

2. User isi form (nama, deskripsi, harga, gambar)
   → Submit: POST /admin/products

3. AdminProductController::store()
   → Validasi input
   → Upload gambar ke public/images/
   → Menu::create() → Simpan ke database
   → Redirect ke index dengan pesan sukses

READ (Lihat Produk)
───────────────────
1. GET /admin/products
   → AdminProductController::index()
   → Menu::all() → Ambil semua produk
   → View: index.blade.php (tabel produk)

UPDATE (Edit Produk)
────────────────────
1. GET /admin/products/{id}/edit
   → AdminProductController::edit($id)
   → Menu::findOrFail($id)
   → View: edit.blade.php (form terisi data)

2. User edit form
   → Submit: PUT /admin/products/{id}

3. AdminProductController::update($id)
   → Validasi input
   → Jika ada gambar baru: hapus gambar lama, upload baru
   → Menu::update() → Update database
   → Redirect ke index dengan pesan sukses

DELETE (Hapus Produk)
──────────────────────
1. User klik tombol "Hapus"
   → Submit: DELETE /admin/products/{id}

2. AdminProductController::destroy($id)
   → Menu::findOrFail($id)
   → Hapus gambar dari public/images/
   → Menu::delete() → Hapus dari database
   → Redirect ke index dengan pesan sukses
```

---

## 9. File Dependencies (Ketergantungan)

```
web.php (routes)
    │
    ├──→ ProductController
    │       │
    │       ├──→ Menu Model
    │       │       └──→ Database (menus table)
    │       │
    │       └──→ View: products.blade.php
    │               └──→ Layout: mainlayout.blade.php
    │                       └──→ includes/navigation.blade.php
    │
    ├──→ KeranjangController
    │       │
    │       ├──→ Keranjang Model
    │       │       ├──→ Database (keranjangs table)
    │       │       └──→ Menu Model (relasi)
    │       │
    │       └──→ View: keranjang/keranjang.blade.php
    │
    ├──→ UserController
    │       │
    │       ├──→ User Model
    │       │       └──→ Database (users table)
    │       │
    │       └──→ View: profile.blade.php
    │
    └──→ AdminProductController
            │
            ├──→ Middleware: admin
            │       └──→ User Model (cek role)
            │
            ├──→ Menu Model
            │       └──→ Database (menus table)
            │
            └──→ Views: admin/products/*
```

---

## 10. Teknologi Stack

```
┌─────────────────────────────────────┐
│         TECHNOLOGY STACK            │
├─────────────────────────────────────┤
│                                     │
│  Backend:                           │
│  ├── PHP 8.2+                       │
│  ├── Laravel 12                     │
│  └── SQLite Database                │
│                                     │
│  Frontend:                          │
│  ├── Blade Template Engine          │
│  ├── Tailwind CSS                   │
│  └── JavaScript (minimal)           │
│                                     │
│  Authentication:                    │
│  └── Laravel Breeze                 │
│                                     │
│  File Storage:                      │
│  └── Local (public/images/)         │
│                                     │
└─────────────────────────────────────┘
```

---

**Tips Membaca Diagram:**
- Panah (→) menunjukkan alur data/request
- Kotak menunjukkan komponen/fungsi
- Garis putus-putus menunjukkan relasi/ketergantungan
- Decision (┌─┴─┐) menunjukkan kondisi/percabangan












