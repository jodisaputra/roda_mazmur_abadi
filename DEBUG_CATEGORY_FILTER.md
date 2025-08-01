# Debug Category Filter Issue

## Masalah yang Dilaporkan
- Ketika memilih kategori, URL tidak berubah
- Produk yang dicari tidak ter-refresh sesuai kategori yang dipilih

## Analisis Kode Saat Ini

### 1. Form Category Filter (✅ Sudah Benar)
```blade
<form action="{{ route('search') }}" method="GET">
    <input type="hidden" name="q" value="{{ $query }}">
    <input type="hidden" name="sort" value="{{ $sort }}">
    
    <!-- Radio buttons untuk kategori -->
    <input class="form-check-input" type="radio" name="category" value="" id="all-categories">
    <input class="form-check-input" type="radio" name="category" value="{{ $category->slug }}" id="cat-{{ $category->slug }}">
</form>
```

### 2. JavaScript Auto-Submit (✅ Diperbaiki)
```javascript
const categoryRadios = document.querySelectorAll('input[name="category"]');

categoryRadios.forEach(radio => {
    radio.addEventListener('change', function() {
        if (this.checked) {
            const categoryForm = this.closest('form');
            setTimeout(() => {
                categoryForm.submit();
            }, 100);
        }
    });
});
```

### 3. SearchController (✅ Sudah Benar)
```php
public function search(SearchRequest $request)
{
    $validated = $request->validated();
    $query = $validated['q'] ?? '';
    $categorySlug = $validated['category'] ?? null;
    $sort = $validated['sort'] ?? 'relevance';
    // ... logic pencarian
}
```

### 4. SearchService (✅ Sudah Benar)
```php
public function searchProducts(string $query = null, string $categorySlug = null, string $sort = 'relevance', int $perPage = 12)
{
    // ... query building
    if ($categorySlug) {
        $category = Category::where('slug', $categorySlug)->first();
        if ($category) {
            $productsQuery->where('category_id', $category->id);
        }
    }
    // ...
}
```

## Kemungkinan Penyebab Masalah

### 1. JavaScript tidak terload
- Pastikan tidak ada error di console browser
- Cek apakah event listener terpasang dengan benar

### 2. Form tidak ter-submit
- Cek apakah form action URL benar
- Pastikan method GET berfungsi

### 3. Cache atau Session Issue
- Clear browser cache
- Clear Laravel cache

## Debugging Steps

### 1. Buka Browser Console
```
F12 -> Console tab
```

### 2. Test Manual Form Submit
- Pilih kategori -> klik Apply Filter button
- Lihat apakah URL berubah

### 3. Cek Console Logs
```javascript
// Logs sudah ditambahkan untuk debugging:
console.log('Category radio changed:', this.value, 'checked:', this.checked);
console.log('Form found:', categoryForm);
console.log('Form action:', categoryForm.action);
console.log('Form data before submit:');
```

### 4. Test URL Manual
- Akses: http://localhost:8000/search?q=test&category=slug-kategori
- Lihat apakah filtering berfungsi

## Solusi yang Sudah Diterapkan

1. ✅ Perbaikan JavaScript auto-submit
2. ✅ Penambahan debugging logs
3. ✅ Memastikan form structure benar
4. ✅ Clear cache Laravel

## Next Steps

1. Buka halaman search di browser
2. Buka Developer Tools (F12)
3. Pilih kategori dan lihat console logs
4. Jika masih ada masalah, check network tab untuk melihat request yang dikirim
5. Pastikan tidak ada JavaScript errors

## Test URLs

- All categories: http://localhost:8000/search?q=test&category=
- Specific category: http://localhost:8000/search?q=test&category=SLUG_KATEGORI

## Expected Behavior

1. Klik radio button kategori
2. Form auto-submit dalam 100ms
3. URL berubah sesuai kategori
4. Halaman reload dengan hasil filter
5. Produk yang tampil sesuai kategori yang dipilih
