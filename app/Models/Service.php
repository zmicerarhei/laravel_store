<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HasConvertedPrice;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * Class Service
 *
 * @property string $name
 * @property string $description
 * @property int $duration
 * @property float $price
 */

class Service extends Model
{
    use HasConvertedPrice;

    protected $fillable = [
        'name',
        'description',
        'duration',
        'price',
    ];

    /**
     *
     * @return BelongsToMany<Service, Product>
     */
    public function products(): BelongsToMany
    {
        /** @var BelongsToMany<Service, Product> */
        return $this->belongsToMany(Product::class, 'products_services')->withTimestamps();
    }
}
