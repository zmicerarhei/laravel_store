<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Brand
 *
 * @property int $id
 * @property string $name
 */
class Brand extends Model
{
    protected $fillable = ['name'];

    /**
     *
     * @return HasMany<Product, Brand>
     */
    public function products(): HasMany
    {
        /** @var HasMany<Product, Brand> */
        return $this->hasMany(Product::class);
    }
}
