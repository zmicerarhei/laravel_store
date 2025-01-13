<?php

declare(strict_types=1);

namespace App\Models;

use Filterable\Interfaces\Filterable as FilterableInterface;
use Filterable\Traits\Filterable as TraitsFilterable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model implements FilterableInterface
{
    use TraitsFilterable;

    protected $fillable = [
        'name',
        'description',
        'manufacturer',
        'release_date',
        'price',
        'link'
    ];

    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'product_services');
    }

    public function category(): belongsTo
    {
        return $this->belongsTo(Category::class);
    }
}
