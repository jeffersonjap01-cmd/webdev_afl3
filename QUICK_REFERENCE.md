# ⚡ Quick Reference Guide

## 🎯 Aplikasi: Alvca Matcha E-Commerce

Website toko matcha dengan fitur:
- ✅ User bisa lihat produk
- ✅ User bisa beli (keranjang)
- ✅ Admin bisa kelola produk

---

## 📍 URL Penting

| URL | Deskripsi | Perlu Login? | Role |
|-----|-----------|--------------|------|
| `/` | Home page | ❌ | - |
| `/products` | Daftar produk | ❌ | - |
| `/about` | Tentang kami | ❌ | - |
| `/contact` | Kontak | ❌ | - |
| `/login` | Login | ❌ | - |
| `/register` | Daftar akun | ❌ | - |
| `/keranjang` | Keranjang belanja | ✅ | user |
| `/my-profile` | Profil user | ✅ | user |
| `/admin/products` | Kelola produk | ✅ | admin |

---

## 🔑 Login Admin

```
Email: admin@alvcamatcha.com
Password: admin123
```

---

## 📂 File-File Penting

### Routes
- `routes/web.php` → Semua URL aplikasi

### Controllers
- `app/Http/Controllers/ProductController.php` → Halaman produk
- `app/Http/Controllers/KeranjangController.php` → Keranjang
- `app/Http/Controllers/UserController.php` → Profil user
- `app/Http/Controllers/Admin/ProductController.php` → Admin CRUD

### Models
- `app/Models/User.php` → Tabel users
- `app/Models/Menu.php` → Tabel menus (produk)
- `app/Models/Keranjang.php` → Tabel keranjangs

### Views
- `resources/views/home.blade.php` → Home
- `resources/views/products.blade.php` → Daftar produk
- `resources/views/keranjang/keranjang.blade.php` → Keranjang
- `resources/views/admin/products/index.blade.php` → Admin: daftar produk

---

## 🗄️ Database Tables

### users
- id, name, email, password, role, timestamps

### menus
- id, nama, deskripsi, harga, gambar, timestamps

### keranjangs
- id, user_id, menu_id, qty, total_harga, timestamps

---

## 🔄 Alur Request Sederhana

```
URL → Route → Controller → Model → Database
                              ↓
                          View ← Controller
                              ↓
                          Browser
```

---

## 🛡️ Middleware

| Middleware | Fungsi |
|-----------|--------|
| `auth` | Cek apakah user sudah login |
| `admin` | Cek apakah user adalah admin |

---

## 📝 Command Penting

```bash
# Install dependencies
composer install
npm install

# Setup database
php artisan migrate
php artisan db:seed

# Buat admin user
php artisan db:seed --class=AdminUserSeeder

# Jalankan server
php artisan serve
```

---

## 🎨 Teknologi

- **Backend:** Laravel 12 (PHP)
- **Frontend:** Blade + Tailwind CSS
- **Database:** SQLite
- **Auth:** Laravel Breeze

---

## 🔍 Cara Trace Code

**Contoh: User akses `/products`**

1. Cari di `routes/web.php`:
   ```php
   Route::get('/products', [ProductController::class, 'products']);
   ```

2. Buka `ProductController.php`, cari method `products()`:
   ```php
   public function products() {
       $menus = Menu::all();
       return view('products', compact('menus'));
   }
   ```

3. Buka `Menu.php` (Model) untuk lihat struktur data

4. Buka `resources/views/products.blade.php` untuk lihat tampilan

**Selesai!** Sekarang tahu alurnya.

---

## 💡 Tips

1. **Mulai dari routes** → lihat URL apa yang ada
2. **Cari controller** → lihat logikanya
3. **Cari model** → lihat datanya
4. **Cari view** → lihat tampilannya

---

## 📚 Dokumentasi Lengkap

- `STRUKTUR_DAN_CARA_KERJA.md` → Penjelasan detail
- `DIAGRAM_ALUR.md` → Diagram visual

---

**Happy Coding! 🚀**

