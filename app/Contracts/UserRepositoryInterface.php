<?php

declare(strict_types=1);

namespace App\Contracts;

use App\Models\User;

interface UserRepositoryInterface
{
    /**
     *
     * @param array<string, mixed> $data
     * @return User
     */
    public function create(array $data): User;
}
