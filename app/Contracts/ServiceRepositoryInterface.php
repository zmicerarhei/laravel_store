<?php

declare(strict_types=1);

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;
use App\Models\Service;

interface ServiceRepositoryInterface
{
    /**
     *
     * @return Collection<int, Service>
     *
     */
    public function getAllServices(): Collection;
}
