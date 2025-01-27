<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Contracts\CurrencyServiceInterface;
use Illuminate\Console\Command;

class FetchExchangeRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-exchange-rates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch and store exchange rates from XML source';

    /**
     * Execute the console command.
     */
    public function handle(CurrencyServiceInterface $currencyService): void
    {
        $currencyService->fetchExchangeRates();
        $this->info('Exchange rates updated successfully!');
    }
}
