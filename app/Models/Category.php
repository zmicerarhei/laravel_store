<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Product;

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

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
