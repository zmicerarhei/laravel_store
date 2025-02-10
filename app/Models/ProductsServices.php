<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class ProductsServices
 *
 * @property int $product_id
 * @property int $service_id
 * @property-read Product $product
 * @property-read Service $service
 */
class ProductsServices extends Model
{
    protected $fillable = [
        'product_id',
        'service_id',
    ];

    /**
     *
     * @return BelongsTo<Product, ProductsServices>
     */
    public function product(): BelongsTo
    {
        /** @var BelongsTo<Product, ProductsServices> */
        return $this->belongsTo(Product::class);
    }

    /**
     *
     * @return BelongsTo<Service, ProductsServices>
     */
    public function service(): BelongsTo
    {
        /** @var BelongsTo<Service, ProductsServices> */
        return $this->belongsTo(Service::class);
    }
}
