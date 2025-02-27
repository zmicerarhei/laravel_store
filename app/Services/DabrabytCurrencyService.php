<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\CurrencyServiceInterface;
use App\Contracts\CurrencyRepositoryInterface;
use App\Contracts\ExchangeRatesServiceInterface;
use Illuminate\Contracts\Cache\Repository as CacheInterface;
use Illuminate\Database\Eloquent\Collection;

class DabrabytCurrencyService implements CurrencyServiceInterface
{
    /**
     * @param array<int, array{iso: string, sale: string}> $fallbackRates
     * @param array<string> $currencyTypes
     */
    public function __construct(
        private ExchangeRatesServiceInterface $exchangeRatesService,
        private CurrencyRepositoryInterface $currencyRepository,
        private CacheInterface $cache,
        private array $currencyTypes,
        private array $fallbackRates,
    ) {
    }

    public function updateExchangeRates(): void
    {
        try {
            $data = $this->exchangeRatesService->fetchExchangeRates();
        } catch (\Exception $e) {
            $data = $this->getDefaultRates();
        }

        foreach ($data['rates'] as $rate) {
            $iso = (string)$rate['iso'];

            if (in_array($iso, $this->currencyTypes, true)) {
                $this->currencyRepository->updateByIso($rate, $iso);
            }
        }
    }

    public function getCurrencies(): Collection
    {
        return $this->cache->remember('currencies', 600, function () {
            $this->updateExchangeRates();
            return $this->currencyRepository->all();
        });
    }

    /**
     *  Get default exchange rates
     *
     * @return array{
     *     rates: array<int, array{iso: string, sale: string}>,
     * }
     */
    private function getDefaultRates(): array
    {
        return [
            'rates' => $this->fallbackRates,
        ];
    }
}
