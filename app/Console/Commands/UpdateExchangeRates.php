<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Contracts\CurrencyServiceInterface;
use Illuminate\Console\Command;

class UpdateExchangeRates extends Command
{
    public function __construct(public CurrencyServiceInterface $currencyService)
    {
        parent::__construct();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-exchange-rates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch and store exchange rates from XML source';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $this->currencyService->updateExchangeRates();
        $this->info('Exchange rates updated successfully!');
    }
}
