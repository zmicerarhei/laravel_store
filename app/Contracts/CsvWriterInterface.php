<?php

declare(strict_types=1);

namespace App\Contracts;

interface CsvWriterInterface
{
    /**
     * Inserts one row into the CSV.
     *
     * @param array<string|int, mixed> $row
     * @return void
     */
    public function insertOne(array $row): void;

    /**
     * Inserts multiple rows into the CSV.
     *
     * @param array<array<string|int, mixed>> $rows
     * @return void
     */
    public function insertAll(array $rows): void;

    /**
     * Returns the CSV as a string.
     */
    public function toString(): string;
}
