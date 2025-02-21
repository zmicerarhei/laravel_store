<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\Service;
use Illuminate\Database\Eloquent\Collection;
use App\Contracts\ServiceRepositoryInterface;

class ServiceRepository implements ServiceRepositoryInterface
{
    /**
     * @return Collection<int, Service>
     */
    public function getAllServices(): Collection
    {
        return Service::all();
    }
}
