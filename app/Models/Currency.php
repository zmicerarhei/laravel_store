<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Currency
 *
 * @property string $iso
 * @property float $sale_rate
 * @property string $retrieved_at
 */
class Currency extends Model
{
    protected $fillable = [
        'iso',
        'sale_rate',
        'retrieved_at',
    ];
}
