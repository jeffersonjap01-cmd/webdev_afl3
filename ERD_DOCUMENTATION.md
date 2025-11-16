# Entity Relationship Diagram (ERD) Documentation
## Alvca Matcha E-Commerce & Restaurant Management System

---

## Database Overview

The system uses **12 main entities** with relationships defined through foreign keys. This document describes each entity, its attributes, and relationships.

---

## Entity Descriptions

### 1. users
**Description**: Stores user account information for both customers and administrators.

**Attributes**:
- `id` (PK, BIGINT, AUTO_INCREMENT) - Primary key
- `name` (VARCHAR) - User's full name
- `email` (VARCHAR, UNIQUE) - User's email address
- `email_verified_at` (TIMESTAMP, NULLABLE) - Email verification timestamp
- `password` (VARCHAR) - Encrypted password
- `role` (ENUM: 'user', 'admin') - User role, default 'user'
- `remember_token` (VARCHAR, NULLABLE) - Remember me token
- `created_at` (TIMESTAMP) - Record creation timestamp
- `updated_at` (TIMESTAMP) - Record update timestamp

**Relationships**:
- One-to-Many with `keranjangs` (user_id)
- One-to-Many with `orders` (user_id)
- One-to-Many with `alamats` (user_id)
- One-to-Many with `reviews` (user_id)

---

### 2. menus
**Description**: Product catalog containing all matcha products available for sale.

**Attributes**:
- `id` (PK, BIGINT, AUTO_INCREMENT) - Primary key
- `gambar` (VARCHAR) - Product image filename/path
- `nama` (VARCHAR) - Product name
- `deskripsi` (TEXT) - Product description
- `harga` (DECIMAL(10,2)) - Product price, default 0
- `kategori_id` (FK, BIGINT, NULLABLE) - Reference to kategoris
- `stok` (INTEGER) - Product stock quantity, default 0
- `lokasi_toko_id` (FK, BIGINT) - Reference to lokasi_tokos
- `created_at` (TIMESTAMP) - Record creation timestamp
- `updated_at` (TIMESTAMP) - Record update timestamp

**Relationships**:
- Many-to-One with `kategoris` (kategori_id)
- Many-to-One with `lokasi_tokos` (lokasi_toko_id)
- One-to-Many with `keranjangs` (menu_id)
- One-to-Many with `order_items` (menu_id)
- One-to-Many with `reviews` (menu_id)

---

### 3. kategoris
**Description**: Product categories for organizing products.

**Attributes**:
- `id` (PK, BIGINT, AUTO_INCREMENT) - Primary key
- `nama` (VARCHAR) - Category name
- `deskripsi` (TEXT, NULLABLE) - Category description
- `icon` (VARCHAR, NULLABLE) - Icon class or image path
- `created_at` (TIMESTAMP) - Record creation timestamp
- `updated_at` (TIMESTAMP) - Record update timestamp

**Relationships**:
- One-to-Many with `menus` (kategori_id)

---

### 4. lokasi_tokos
**Description**: Restaurant branch locations where products are available.

**Attributes**:
- `id` (PK, BIGINT, AUTO_INCREMENT) - Primary key
- `nama_lokasi` (VARCHAR) - Location name
- `alamat` (VARCHAR, NULLABLE) - Location address
- `no_telepon` (VARCHAR, NULLABLE) - Location phone number
- `created_at` (TIMESTAMP) - Record creation timestamp
- `updated_at` (TIMESTAMP) - Record update timestamp

**Relationships**:
- One-to-Many with `menus` (lokasi_toko_id)
- One-to-Many with `mejas` (lokasi_toko_id)
- One-to-Many with `keranjangs` (lokasi_toko_id)

---

### 5. mejas
**Description**: Tables available for dine-in orders at each location.

**Attributes**:
- `id` (PK, BIGINT, AUTO_INCREMENT) - Primary key
- `nomor_meja` (VARCHAR) - Table number/identifier
- `status` (ENUM: 'kosong', 'digunakan', 'reservasi') - Table status, default 'kosong'
- `lokasi_toko_id` (FK, BIGINT) - Reference to lokasi_tokos
- `created_at` (TIMESTAMP) - Record creation timestamp
- `updated_at` (TIMESTAMP) - Record update timestamp

**Relationships**:
- Many-to-One with `lokasi_tokos` (lokasi_toko_id)
- One-to-Many with `orders` (meja_id)

---

### 6. keranjangs
**Description**: Shopping cart items for delivery orders.

**Attributes**:
- `id` (PK, BIGINT, AUTO_INCREMENT) - Primary key
- `user_id` (FK, BIGINT) - Reference to users
- `menu_id` (FK, BIGINT) - Reference to menus
- `lokasi_toko_id` (FK, BIGINT, NULLABLE) - Reference to lokasi_tokos
- `alamat_id` (FK, BIGINT, NULLABLE) - Reference to alamats
- `qty` (INTEGER) - Quantity, default 1
- `total_harga` (INTEGER) - Total price for this item
- `status_pembayaran` (ENUM: 'Belum Bayar', 'Dibayar') - Payment status, default 'Belum Bayar'
- `created_at` (TIMESTAMP) - Record creation timestamp
- `updated_at` (TIMESTAMP) - Record update timestamp

**Relationships**:
- Many-to-One with `users` (user_id)
- Many-to-One with `menus` (menu_id)
- Many-to-One with `lokasi_tokos` (lokasi_toko_id)
- Many-to-One with `alamats` (alamat_id)

---

### 7. alamats
**Description**: Customer delivery addresses for delivery orders.

**Attributes**:
- `id` (PK, BIGINT, AUTO_INCREMENT) - Primary key
- `user_id` (FK, BIGINT) - Reference to users
- `alamat_lengkap` (VARCHAR) - Complete street address
- `kota` (VARCHAR) - City
- `provinsi` (VARCHAR) - Province/State
- `kode_pos` (VARCHAR(10), NULLABLE) - Postal code
- `no_telepon` (VARCHAR(20), NULLABLE) - Phone number
- `is_default` (BOOLEAN) - Default address flag, default false
- `created_at` (TIMESTAMP) - Record creation timestamp
- `updated_at` (TIMESTAMP) - Record update timestamp

**Relationships**:
- Many-to-One with `users` (user_id)
- One-to-Many with `keranjangs` (alamat_id)

---

### 8. orders
**Description**: Dine-in orders placed by customers.

**Attributes**:
- `id` (PK, BIGINT, AUTO_INCREMENT) - Primary key
- `user_id` (FK, BIGINT) - Reference to users
- `meja_id` (FK, BIGINT) - Reference to mejas
- `status` (ENUM: 'pending', 'proses', 'paid', 'done') - Order status, default 'pending'
- `status_pembayaran` (ENUM: 'Belum Bayar', 'Dibayar') - Payment status, default 'Belum Bayar'
- `last_activity_at` (TIMESTAMP, NULLABLE) - Last activity timestamp for auto-release
- `created_at` (TIMESTAMP) - Record creation timestamp
- `updated_at` (TIMESTAMP) - Record update timestamp

**Relationships**:
- Many-to-One with `users` (user_id)
- Many-to-One with `mejas` (meja_id)
- One-to-Many with `order_items` (order_id)
- One-to-One with `payments` (order_id)

---

### 9. order_items
**Description**: Individual items within each dine-in order.

**Attributes**:
- `id` (PK, BIGINT, AUTO_INCREMENT) - Primary key
- `order_id` (FK, BIGINT) - Reference to orders
- `menu_id` (FK, BIGINT) - Reference to menus
- `qty` (INTEGER) - Quantity, default 1
- `harga_satuan` (DECIMAL(10,2)) - Unit price, default 0
- `subtotal` (DECIMAL(10,2)) - Subtotal (qty × harga_satuan), default 0
- `created_at` (TIMESTAMP) - Record creation timestamp
- `updated_at` (TIMESTAMP) - Record update timestamp

**Relationships**:
- Many-to-One with `orders` (order_id)
- Many-to-One with `menus` (menu_id)

---

### 10. payments
**Description**: Payment records for orders.

**Attributes**:
- `id` (PK, BIGINT, AUTO_INCREMENT) - Primary key
- `order_id` (FK, BIGINT) - Reference to orders
- `metode_pembayaran` (ENUM: 'tunai', 'debit', 'kredit', 'e_wallet', 'qris') - Payment method, default 'tunai'
- `jumlah` (DECIMAL(10,2)) - Payment amount
- `status` (ENUM: 'pending', 'berhasil', 'gagal', 'dibatalkan') - Payment status, default 'pending'
- `tanggal_bayar` (TIMESTAMP, NULLABLE) - Payment date and time
- `bukti_pembayaran` (VARCHAR, NULLABLE) - Payment proof file path
- `catatan` (TEXT, NULLABLE) - Payment notes
- `created_at` (TIMESTAMP) - Record creation timestamp
- `updated_at` (TIMESTAMP) - Record update timestamp

**Relationships**:
- Many-to-One with `orders` (order_id)

---

### 11. promos
**Description**: Promotional codes for discounts.

**Attributes**:
- `id` (PK, BIGINT, AUTO_INCREMENT) - Primary key
- `nama_promo` (VARCHAR) - Promotion name
- `deskripsi` (TEXT, NULLABLE) - Promotion description
- `kode_promo` (VARCHAR, UNIQUE) - Unique promo code
- `diskon_persen` (DECIMAL(5,2)) - Discount percentage, default 0
- `diskon_nominal` (DECIMAL(10,2), NULLABLE) - Fixed discount amount
- `tanggal_mulai` (DATE) - Start date
- `tanggal_berakhir` (DATE) - End date
- `status` (ENUM: 'aktif', 'tidak_aktif') - Promotion status, default 'aktif'
- `min_pembelian` (INTEGER, NULLABLE) - Minimum purchase requirement
- `max_diskon` (INTEGER, NULLABLE) - Maximum discount amount
- `created_at` (TIMESTAMP) - Record creation timestamp
- `updated_at` (TIMESTAMP) - Record update timestamp

**Relationships**:
- None (standalone entity, referenced in application logic)

---

### 12. reviews
**Description**: Customer reviews and ratings for products.

**Attributes**:
- `id` (PK, BIGINT, AUTO_INCREMENT) - Primary key
- `user_id` (FK, BIGINT) - Reference to users
- `menu_id` (FK, BIGINT) - Reference to menus
- `rating` (INTEGER) - Rating (1-5 stars), default 5
- `komentar` (TEXT, NULLABLE) - Review comment
- `created_at` (TIMESTAMP) - Record creation timestamp
- `updated_at` (TIMESTAMP) - Record update timestamp

**Relationships**:
- Many-to-One with `users` (user_id)
- Many-to-One with `menus` (menu_id)

---

## Relationship Summary

### One-to-Many Relationships:
1. **users** → **keranjangs** (1 user has many cart items)
2. **users** → **orders** (1 user has many orders)
3. **users** → **alamats** (1 user has many addresses)
4. **users** → **reviews** (1 user has many reviews)
5. **kategoris** → **menus** (1 category has many products)
6. **lokasi_tokos** → **menus** (1 location has many products)
7. **lokasi_tokos** → **mejas** (1 location has many tables)
8. **lokasi_tokos** → **keranjangs** (1 location has many cart items)
9. **menus** → **keranjangs** (1 product in many carts)
10. **menus** → **order_items** (1 product in many order items)
11. **menus** → **reviews** (1 product has many reviews)
12. **mejas** → **orders** (1 table has many orders)
13. **alamats** → **keranjangs** (1 address used in many cart items)
14. **orders** → **order_items** (1 order has many items)

### One-to-One Relationships:
1. **orders** → **payments** (1 order has 1 payment)

---

## Entity Relationship Diagram (ERD) Visual Representation

The ERD can be visualized in draw.io using the following structure:

```
┌─────────────┐
│   users     │
│─────────────│
│ id (PK)     │
│ name        │
│ email       │
│ password    │
│ role        │
└──────┬──────┘
       │
       ├─────────────────┬──────────────────┬─────────────────┐
       │                 │                  │                 │
       ▼                 ▼                  ▼                 ▼
┌─────────────┐  ┌─────────────┐  ┌─────────────┐  ┌─────────────┐
│ keranjangs  │  │   orders    │  │   alamats   │  │   reviews   │
│─────────────│  │─────────────│  │─────────────│  │─────────────│
│ id (PK)     │  │ id (PK)     │  │ id (PK)     │  │ id (PK)     │
│ user_id (FK)│  │ user_id (FK)│  │ user_id (FK)│  │ user_id (FK)│
│ menu_id (FK)│  │ meja_id (FK)│  │ alamat_... │  │ menu_id (FK)│
│ lokasi_...  │  │ status      │  │ kota        │  │ rating      │
│ alamat_id   │  │ status_...  │  │ provinsi    │  │ komentar    │
│ qty         │  └──────┬──────┘  └──────┬──────┘  └─────────────┘
│ total_harga │         │                │
│ status_...  │         │                │
└──────┬──────┘         │                │
       │                │                │
       │                ▼                │
       │         ┌─────────────┐        │
       │         │order_items   │        │
       │         │─────────────│        │
       │         │ id (PK)      │        │
       │         │ order_id (FK)│        │
       │         │ menu_id (FK) │        │
       │         │ qty          │        │
       │         │ harga_satuan │        │
       │         │ subtotal     │        │
       │         └──────┬───────┘        │
       │                │                │
       │                │                │
       ▼                ▼                │
┌─────────────┐  ┌─────────────┐        │
│   menus     │  │  payments   │        │
│─────────────│  │─────────────│        │
│ id (PK)     │  │ id (PK)     │        │
│ gambar      │  │ order_id(FK)│        │
│ nama        │  │ metode_...  │        │
│ deskripsi   │  │ jumlah      │        │
│ harga       │  │ status      │        │
│ kategori_id │  │ tanggal_... │        │
│ stok        │  └─────────────┘        │
│ lokasi_...  │                         │
└──────┬──────┘                         │
       │                                │
       ├─────────────┬──────────────────┘
       │             │
       ▼             ▼
┌─────────────┐  ┌─────────────┐
│  kategoris  │  │lokasi_tokos │
│─────────────│  │─────────────│
│ id (PK)     │  │ id (PK)     │
│ nama        │  │ nama_lokasi │
│ deskripsi   │  │ alamat      │
│ icon        │  │ no_telepon  │
└─────────────┘  └──────┬──────┘
                        │
                        ▼
                 ┌─────────────┐
                 │    mejas    │
                 │─────────────│
                 │ id (PK)     │
                 │ nomor_meja  │
                 │ status      │
                 │ lokasi_...  │
                 └─────────────┘
```

---

## Notes for Draw.io Import

1. **Entity Boxes**: Each entity should be represented as a rectangle
2. **Attributes**: List all attributes inside each entity box
3. **Primary Keys**: Mark with (PK)
4. **Foreign Keys**: Mark with (FK)
5. **Relationships**: Use lines with crow's foot notation (one-to-many)
6. **Cardinality**: 
   - One-to-Many: Line with single line on one side, crow's foot on many side
   - One-to-One: Line with single line on both sides
7. **Optional Relationships**: Use dashed lines for nullable foreign keys

---

**Document Version**: 1.0  
**Last Updated**: November 2025

