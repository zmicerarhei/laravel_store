<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\BankApiClientInterface;
use App\Contracts\CurrencyServiceInterface;
use App\Contracts\CurrencyRepositoryInterface;
use App\Contracts\ExchangeRatesServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class DabrabytCurrencyService implements CurrencyServiceInterface
{

    public function __construct(
        private BankApiClientInterface $bankApiClient,
        private ExchangeRatesServiceInterface $exchangeRatesService,
        private CurrencyRepositoryInterface $currencyRepository,
        private array $currency_types,
        private array $fallbackRates,
    ) {}

    public function updateExchangeRates(): void
    {
        try {
            $data = $this->exchangeRatesService->fetchExchangeRates();
        } catch (\Exception $e) {
            $data = $this->getDefaultRates();
        }

        foreach ($data['rates'] as $rate) {
            $iso = (string)$rate['iso'];

            if (in_array($iso, $this->currency_types, true)) {
                $this->currencyRepository->updateByIso($rate, $iso);
            }
        }
    }

    public function getCurrencies(): Collection
    {
        return Cache::remember('currencies', 600, function () {
            $this->updateExchangeRates();
            return $this->currencyRepository->all();
        });
    }

    public function convert(float $price): float
    {
        $currency_rate = session('sale_rate', 1);

        return round($price / $currency_rate, 2);
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
