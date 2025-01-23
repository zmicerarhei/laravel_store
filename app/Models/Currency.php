<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable = [
        'iso',
        'sale_rate',
        'retrieved_at',
    ];
}
