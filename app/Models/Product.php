<?php

declare(strict_types=1);

namespace App\Models;

use Filterable\Interfaces\Filterable as FilterableInterface;
use Filterable\Traits\Filterable as TraitsFilterable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
 * @property string|null $link
 * @property int $category_id
 * @property int $brand_id
 *
 * @property Brand $brand
 * @property Category $category
 * @property \Illuminate\Database\Eloquent\Collection<int, Service> $services
 */
class Product extends Model implements FilterableInterface
{
    use TraitsFilterable;

    /**
     * @use HasFactory<\Database\Factories\ProductFactory>
     */
    use HasFactory;

    public const ITEMS_PER_PAGE = 8;
    public const DEFAULT_RELATIONS = ['brand', 'category'];

    protected $fillable = [
        'name',
        'description',
        'release_date',
        'price',
        'link',
        'category_id',
        'brand_id',
    ];

    protected $attributes = [
        'link' => null,
    ];

    /**
     *
     * @return BelongsToMany<Product, Service>
     */
    public function services(): BelongsToMany
    {
        /** @var BelongsToMany<Product, Service> */
        return $this->belongsToMany(Service::class, 'products_services')->withTimestamps();
    }

    /**
     *
     * @return BelongsTo<Brand, Product>
     */
    public function brand(): BelongsTo
    {
        /** @var BelongsTo<Brand, Product> */
        return $this->belongsTo(Brand::class);
    }

    /**
     *
     * @return BelongsTo<Category, Product>
     */
    public function category(): BelongsTo
    {
        /** @var BelongsTo<Category, Product> */
        return $this->belongsTo(Category::class);
    }
}
