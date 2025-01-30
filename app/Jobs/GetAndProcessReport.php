<?php

namespace App\Jobs;

use App\Notifications\ReportSavedNotification;
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
    public function __construct(private $reportFile, private $user)
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
            /** @var \App\Models\User $user */
            $userName = $this->user->name;
            $this->user->notify(new ReportSavedNotification($fileName));
            Log::info("Файл $fileName успешно загружен админом $userName");
        } catch (\Exception $e) {
            Log::error("Ошибка при сохранении файла: " . $e->getMessage());
        }
    }
}
