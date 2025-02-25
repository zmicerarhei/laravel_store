<?php

declare(strict_types=1);

namespace App\Utils;

use Psr\Clock\ClockInterface;
use Carbon\CarbonImmutable;
use DateTimeImmutable;

class CarbonClock implements ClockInterface
{
    public function now(): DateTimeImmutable
    {
        return CarbonImmutable::now();
    }
}
