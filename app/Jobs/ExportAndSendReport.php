<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use League\Csv\Writer;
use Illuminate\Support\Facades\Queue;

class ExportAndSendReport implements ShouldQueue
{
    use Queueable;

    /**
     * Create a new job instance.
     */
    public function __construct(private $user)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $fields = ['id', 'name', 'description', 'release_date', 'price'];
        $products = Product::all($fields)->toArray();
        $csv = Writer::createFromString();
        $csv->insertOne($fields);
        $csv->insertAll($products);
        Queue::push(new GetAndProcessReport($csv->toString(), $this->user));
    }
}
