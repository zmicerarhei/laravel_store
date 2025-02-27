<?php

declare(strict_types=1);

namespace App\Clients;

use App\Contracts\BankApiClientInterface;
use App\Contracts\HttpClientInterface;

class BankApiClient implements BankApiClientInterface
{
    protected string $baseUrl;

    public function __construct(
        private string $url,
        private HttpClientInterface $httpClient
    ) {
    }

    public function fetchExchangeRates(): string
    {
        try {
            $response = $this->httpClient->get($this->url);

            if ($response->failed()) {
                throw new \Exception('Failed to fetch exchange rates');
            }

            return $response->body();
        } catch (\Exception $e) {
            throw new \RuntimeException('Error fetching exchange rates', 0, $e);
        }
    }
}
