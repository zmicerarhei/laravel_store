<?php

declare(strict_types=1);

namespace App\Models;

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
    protected $fillable = [
        'name',
        'description',
        'duration',
        'price',
    ];

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'products_services')->withTimestamps();
    }
}
