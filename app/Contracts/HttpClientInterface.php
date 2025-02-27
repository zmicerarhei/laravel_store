<?php

declare(strict_types=1);

namespace App\Contracts;

interface HttpClientInterface
{
    public function get(string $url): mixed;
}
