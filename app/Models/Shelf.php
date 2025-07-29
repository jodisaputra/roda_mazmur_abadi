<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Cviebrock\EloquentSluggable\Sluggable;

class Shelf extends Model
{
    use Sluggable;

    protected $fillable = [
        'name',
        'slug',
        'is_active',
        'capacity',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'capacity' => 'integer',
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
     * Get the products for the shelf.
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_shelf')
                    ->withPivot('sort_order')
                    ->withTimestamps()
                    ->orderBy('product_shelf.sort_order');
    }

    /**
     * Get active products for the shelf.
     */
    public function activeProducts(): BelongsToMany
    {
        return $this->products()
                    ->where('products.status', 'active')
                    ->where('products.in_stock', true);
    }

    /**
     * Scope a query to only include active shelves.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
