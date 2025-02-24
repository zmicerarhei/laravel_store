<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\User;
use App\Notifications\ReportSavedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Filesystem\Filesystem;
use Psr\Clock\ClockInterface;
use Psr\Log\LoggerInterface;

class GetAndProcessReport implements ShouldQueue
{
    use Queueable;

    private const FILE_EXTANTION = 'csv';
    private const BASE_FILE_NAME = 'products_report_';

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
    public function handle(
        ClockInterface $clock,
        Filesystem $filesystem,
        LoggerInterface $logger
    ): void {
        try {
            $fileName = self::BASE_FILE_NAME . $clock->now() . self::FILE_EXTANTION;
            $filesystem->put($fileName, $this->reportFile);
            $userName = $this->user->name;
            $this->user->notify(new ReportSavedNotification($fileName));
            $logger->info("File $fileName was successfully saved by $userName");
        } catch (\Exception $e) {
            logger()->error("Failed to save file: " . $e->getMessage());
        }
    }
}
