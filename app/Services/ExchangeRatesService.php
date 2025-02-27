<?php

declare(strict_types=1);

namespace App\Services;

use App\Contracts\BankApiClientInterface;
use App\Contracts\ExchangeRatesServiceInterface;
use Psr\Log\LoggerInterface;

class ExchangeRatesService implements ExchangeRatesServiceInterface
{
    public function __construct(
        private BankApiClientInterface $bankApiClient,
        private LoggerInterface $logger
    ) {}

    /**
     * Get exchange rates from API.
     *
     * @return array{rates: array<int, array{iso: string, sale: string}>}
     */
    public function fetchExchangeRates(): array
    {
        try {
            $xml = $this->bankApiClient->fetchExchangeRates();
            $xmlObj = simplexml_load_string($xml);

            if (!$xmlObj || !isset($xmlObj->time)) {
                throw new \RuntimeException('Failed to load or parse XML from the bank API.');
            }

            $ratesArr = $this->parseRatesFromXMLtoArr($xmlObj);

            return [
                'rates' => $ratesArr,
            ];
        } catch (\Exception $e) {
            $this->logger->error('API request failed: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Parse XML rates to an array.
     *
     * @param \SimpleXMLElement $xmlObj
     * @return array<int, array{iso: string, sale: string}>
     */
    private function parseRatesFromXMLtoArr(\SimpleXMLElement $xmlObj): array
    {
        $json = json_encode($xmlObj->filials->filial[0]->rates)
            ?: throw new \RuntimeException('Failed to encode XML to JSON.');

        $rawRates = json_decode($json, true);
        if (!is_array($rawRates)) {
            throw new \RuntimeException('Failed to decode JSON to array.');
        }

        $cleanRates = [];
        foreach ($rawRates['value'] as $rate) {
            if (isset($rate['@attributes'])) {
                $cleanRates[] = [
                    'iso' => $rate['@attributes']['iso'],
                    'sale' => $rate['@attributes']['sale'],
                ];
            }
        }

        return $cleanRates;
    }
}
