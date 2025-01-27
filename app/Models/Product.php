<?php

declare(strict_types=1);

namespace App\Models;

use Filterable\Interfaces\Filterable as FilterableInterface;
use Filterable\Traits\Filterable as TraitsFilterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Product
 *
 * @property string $name
 * @property string $description
 * @property string $release_date
 * @property float $price
 * @property string $link
 * @property int $category_id
 * @property int $brand_id
 */

class Product extends Model implements FilterableInterface
{
    use TraitsFilterable;

    protected $fillable = [
        'name',
        'description',
        'release_date',
        'price',
        'link',
        'category_id',
        'brand_id'
    ];

    // This is a temporary solution to prevent the category not being present error when creating a product. In the future,
    // logic will be added to indicate which category a product belongs to when creating it.
    protected $attributes = [
        'category_id' => 1
    ];

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'product_services');
    }

    /**
     * Get the brand that owns the product.
     *
     * @return BelongsTo<Brand>
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function category(): belongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
