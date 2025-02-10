<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Category
 *
 * @property int $id
 * @property string $title
 * @property string $desc
 * @property string $img
 * @property string $slug
 */
class Category extends Model
{
    protected $fillable = [
        'title',
        'desc',
        'img',
        'slug'
    ];

    /**
     *
     * @return HasMany<Product, Category>
     */
    public function products(): HasMany
    {
        /** @var HasMany<Product, Category> */
        return $this->hasMany(Product::class);
    }
}
