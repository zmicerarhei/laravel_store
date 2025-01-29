<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class GetAndProcessReport implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(protected $reportFile)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $fileName = 'products_report_' . now()->format('Ymd_His') . '.csv';
            Storage::put($fileName, $this->reportFile);
            Log::info("CSV файл $fileName успешно сохранён");
        } catch (\Exception $e) {
            Log::error("Ошибка при сохранении CSV: " . $e->getMessage());
        }
    }
}
