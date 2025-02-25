<?php

declare(strict_types=1);

namespace App\Utils;

use App\Contracts\CsvWriterInterface;
use League\Csv\Writer;

class CsvWriterAdapter implements CsvWriterInterface
{
    private Writer $writer;

    public function __construct(string $content = '')
    {
        $this->writer = Writer::createFromString($content);
    }

    public function insertOne(array $row): void
    {
        $this->writer->insertOne($row);
    }

    public function insertAll(array $rows): void
    {
        $this->writer->insertAll($rows);
    }

    public function toString(): string
    {
        return $this->writer->toString();
    }
}
