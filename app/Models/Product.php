<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Cviebrock\EloquentSluggable\Sluggable;

class Product extends Model
{
    use Sluggable;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'category_id',
        'sku',
        'product_code',
        'price',
        'stock_quantity',
        'in_stock',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'in_stock' => 'boolean',
    ];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'id';
    }

    /**
     * Get the category that owns the product.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the images for the product.
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    /**
     * Get the shelves for the product.
     */
    public function shelves(): BelongsToMany
    {
        return $this->belongsToMany(Shelf::class, 'product_shelf')
                    ->withPivot('sort_order')
                    ->withTimestamps()
                    ->orderBy('product_shelf.sort_order');
    }

    /**
     * Get the primary image for the product.
     */
    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    /**
     * Get formatted price in Rupiah
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Scope to get active products
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope to get products in stock
     */
    public function scopeInStock($query)
    {
        return $query->where('in_stock', true);
    }

    /**
     * Get the primary image URL or default
     */
    public function getPrimaryImageUrlAttribute(): string
    {
        $primaryImage = $this->primaryImage;
        if ($primaryImage && $primaryImage->image) {
            return asset('storage/' . $primaryImage->image);
        }

        // Return default product image if no primary image
        return asset('template/assets/images/default-product.svg');
    }

    /**
     * Get discount percentage (placeholder for future implementation)
     */
    public function getDiscountPercentageAttribute(): int
    {
        // For now, return 0 as discount feature is not implemented yet
        return 0;
    }

    /**
     * Get formatted original price (for when discount is implemented)
     */
    public function getFormattedOriginalPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    /**
     * Get stock status based on stock quantity
     */
    public function getStockStatusAttribute(): string
    {
        if (!$this->in_stock || $this->stock_quantity <= 0) {
            return 'out_of_stock';
        }

        if ($this->stock_quantity <= 10) {
            return 'low_stock';
        }

        return 'in_stock';
    }
}
