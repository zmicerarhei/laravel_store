<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Contracts\CsvWriterInterface;
use App\Contracts\ProductRepositoryInterface;
use App\Models\User;
use Illuminate\Contracts\Queue\Queue as QueueInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ExportAndSendReport implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     *
     * @param User $user
     * @param array<string> $exportFields
     */
    public function __construct(private User $user, private array $exportFields)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(
        ProductRepositoryInterface $productRepository,
        CsvWriterInterface $csvWriter,
        QueueInterface $queue
    ): void {
        $products = $productRepository->getAllProducts($this->exportFields)->toArray();
        $csvWriter->insertOne($this->exportFields);
        $csvWriter->insertAll($products);
        $queue->push(new GetAndProcessReport($csvWriter->toString(), $this->user));
    }
}
