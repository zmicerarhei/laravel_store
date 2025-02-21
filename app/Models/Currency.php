<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Currency
 *
 * @property string $iso
 * @property float $sale_rate
 */
class Currency extends Model
{
    protected $fillable = [
        'iso',
        'sale_rate',
    ];
}
