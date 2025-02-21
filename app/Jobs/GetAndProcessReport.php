<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\User;
use App\Notifications\ReportSavedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;

class GetAndProcessReport implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private string $reportFile, private User $user)
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
            $userName = $this->user->name;
            $this->user->notify(new ReportSavedNotification($fileName));
            logger()->info("File $fileName was successfully saved by $userName");
        } catch (\Exception $e) {
            logger()->error("Failed to save file: " . $e->getMessage());
        }
    }
}
