# Database Seeders Documentation

Proyek ini menggunakan beberapa seeder untuk mengisi database dengan data awal yang diperlukan. Berikut adalah daftar seeder yang tersedia:

## Seeder Yang Tersedia

### 1. CategorySeeder
**File:** `database/seeders/CategorySeeder.php`

**Fungsi:** Membuat kategori dan subkategori produk dengan struktur hierarkis.

**Data yang dibuat:**
- **Electronics** (Kategori utama)
  - Smartphones (Subkategori)
  - Laptops & Computers (Subkategori)
  - Tablets (Subkategori)
- **Audio & Video** (Kategori utama)
  - Smart TV (Subkategori)
  - Headphones (Subkategori)
- **Gaming** (Kategori utama)

**Total:** 8 kategori (3 kategori utama + 5 subkategori)

### 2. ShelfSeeder
**File:** `database/seeders/ShelfSeeder.php`

**Fungsi:** Membuat rak/shelf untuk mengelompokkan produk dalam tampilan.

**Data yang dibuat:**
- Featured Products (Kapasitas: 10)
- Best Sellers (Kapasitas: 8)
- New Arrivals (Kapasitas: 12)
- On Sale (Kapasitas: 15)
- Premium Collection (Kapasitas: 6)
- Budget Friendly (Kapasitas: 20)
- Limited Edition (Kapasitas: 5)
- Gaming Zone (Kapasitas: 8)
- Productivity Tools (Kapasitas: 10)
- Entertainment Hub (Kapasitas: 12)

**Total:** 10 shelf

### 3. ProductSeeder
**File:** `database/seeders/ProductSeeder.php`

**Fungsi:** Membuat produk-produk sample dengan kategori yang sesuai.

**Data yang dibuat berdasarkan kategori:**

#### Smartphones (4 produk)
- Samsung Galaxy S24 Ultra - Rp 18.999.000
- iPhone 15 Pro Max - Rp 22.999.000
- Google Pixel 8 Pro - Rp 14.999.000
- OnePlus 12 - Rp 11.999.000

#### Laptops & Computers (4 produk)
- MacBook Air M3 - Rp 18.999.000
- Dell XPS 13 Plus - Rp 23.999.000
- ASUS ROG Zephyrus G16 - Rp 35.999.000
- Lenovo ThinkPad X1 Carbon - Rp 28.999.000

#### Audio & Headphones (3 produk)
- Sony WH-1000XM5 - Rp 4.999.000
- Apple AirPods Pro 2 - Rp 3.999.000
- Bose QuietComfort Ultra - Rp 5.499.000

#### Tablets (2 produk)
- iPad Pro 12.9" M2 - Rp 16.999.000
- Samsung Galaxy Tab S9 Ultra - Rp 15.999.000

#### Gaming (3 produk)
- Nintendo Switch OLED - Rp 4.299.000 (Out of Stock)
- PlayStation 5 Slim - Rp 7.999.000
- Xbox Series X - Rp 7.499.000

#### Smart TV (3 produk)
- Samsung 4K Smart TV 55" - Rp 12.999.000
- LG OLED C3 65" - Rp 24.999.000
- Sony Bravia XR A80L 55" - Rp 21.999.000

**Total:** 19 produk

### 4. ProductShelfSeeder
**File:** `database/seeders/ProductShelfSeeder.php`

**Fungsi:** Membuat relasi antara produk dan shelf (many-to-many relationship).

**Relasi yang dibuat:**
- Featured Products: iPhone 15 Pro Max, MacBook Air M3, Samsung Galaxy S24 Ultra, dll.
- Best Sellers: Apple AirPods Pro 2, OnePlus 12, Samsung 4K Smart TV 55", dll.
- Gaming Zone: Nintendo Switch OLED, PlayStation 5 Slim, Xbox Series X, dll.
- Dan lain-lain sesuai tema shelf

**Total:** Sekitar 50+ relasi produk-shelf

### 5. UserRolePermissionSeeder
**File:** `database/seeders/UserRolePermissionSeeder.php`

**Fungsi:** Membuat user, role, dan permission untuk sistem authentication.

## Cara Menjalankan Seeder

### Menjalankan Semua Seeder
```bash
php artisan db:seed
```

### Menjalankan Seeder Tertentu
```bash
php artisan db:seed --class=CategorySeeder
php artisan db:seed --class=ShelfSeeder
php artisan db:seed --class=ProductSeeder
```

### Reset Database dan Jalankan Seeder
```bash
php artisan migrate:fresh --seed
```

## Urutan Eksekusi

Seeder dijalankan dalam urutan yang tepat melalui `DatabaseSeeder.php`:

1. **UserRolePermissionSeeder** - Membuat user dan permission
2. **CategorySeeder** - Membuat kategori (diperlukan untuk produk)
3. **ShelfSeeder** - Membuat shelf
4. **ProductSeeder** - Membuat produk (memerlukan kategori)

## Fitur Khusus

### CategorySeeder
- Menggunakan `updateOrCreate()` untuk mencegah duplikasi
- Mendukung struktur hierarkis parent-child
- Otomatis generate slug dari nama kategori

### ShelfSeeder
- Menggunakan `updateOrCreate()` dengan slug sebagai unique key
- Semua shelf dibuat dalam status aktif
- Kapasitas dapat dikustomisasi

### ProductSeeder
- Otomatis assign kategori yang sesuai berdasarkan tipe produk
- Menggunakan `updateOrCreate()` dengan SKU sebagai unique key
- Fallback ke kategori random jika kategori spesifik tidak ditemukan
- Otomatis generate slug dari nama produk
- Includes variasi status (active/draft) dan stock (in_stock/out_of_stock)

## Customization

Untuk menambah atau mengubah data seeder:

1. **Kategori:** Edit array `$categories` di `CategorySeeder.php`
2. **Shelf:** Edit array `$shelves` di `ShelfSeeder.php`
3. **Produk:** Edit array `$products` di `ProductSeeder.php`

Setelah perubahan, jalankan:
```bash
php artisan db:seed --class=NamaSeederClass
```

## Dependencies

Seeder ini bergantung pada:
- Model: Category, Shelf, Product
- Package: cviebrock/eloquent-sluggable (untuk auto-slug generation)
- Laravel Spatie Permission (untuk UserRolePermissionSeeder)

## Empty State Feature

Proyek ini juga dilengkapi dengan fitur empty state yang menarik ketika tidak ada produk yang ditampilkan:

### Komponen Empty State

1. **Empty Products Partial (Detailed)**
   - File: `resources/views/partials/empty-products.blade.php`
   - Tampilan lengkap dengan ilustrasi SVG, info cards, dan newsletter subscription
   - Menggunakan custom SVG illustration dan gradient background
   - Ideal untuk halaman utama yang memerlukan tampilan menarik

2. **Empty Products Simple (High Contrast)**
   - File: `resources/views/partials/empty-products-simple.blade.php`
   - Tampilan sederhana dengan kontras tinggi untuk visibility yang lebih baik
   - Menggunakan Bootstrap icons dan background putih
   - Ideal untuk memastikan text terlihat jelas di semua kondisi

3. **Simple Empty State**
   - File: `resources/views/partials/empty-state-simple.blade.php`
   - Tampilan minimal untuk kebutuhan umum di halaman lain

4. **Custom SVG Illustration**
   - File: `public/assets/images/svg-graphics/empty-products.svg`
   - Ilustrasi custom yang dibuat khusus untuk empty state

5. **CSS Styling**
   - File: `public/assets/css/empty-state.css`
   - Animasi dan styling untuk empty state components

### Penggunaan Empty State

```blade
{{-- Versi dengan kontras tinggi (direkomendasikan) --}}
@forelse($shelves as $shelf)
    {{-- Tampilkan produk --}}
@empty
    @include('partials.empty-products-simple', [
        'title' => 'Produk Belum Tersedia',
        'description' => 'Pesan kustom...',
        'contactUrl' => route('contact'),
        'subscribeUrl' => route('newsletter.subscribe')
    ])
@endforelse

{{-- Versi detailed dengan ilustrasi SVG --}}
@include('partials.empty-products', [
    'title' => 'Custom Title',
    'description' => 'Custom description...',
    'contactUrl' => route('contact'),
    'hideInfoCards' => true // Untuk menyembunyikan info cards
])

{{-- Versi minimal untuk halaman lain --}}
@include('partials.empty-state-simple', [
    'title' => 'Tidak Ada Data',
    'actionUrl' => route('create'),
    'actionText' => 'Tambah Data'
])
```

### Testing Empty State

Untuk testing empty state, hapus relasi produk-shelf:
```bash
php artisan tinker --execute="DB::table('product_shelf')->delete();"
```

Untuk mengembalikan:
```bash
php artisan db:seed --class=ProductShelfSeeder
```
