<?php

declare(strict_types=1);

namespace App\Contracts;

interface CsvWriterInterface
{
    /**
     * Вставляет одну строку данных в CSV.
     */
    public function insertOne(array $row): void;

    /**
     * Вставляет массив строк в CSV.
     */
    public function insertAll(array $rows): void;

    /**
     * Возвращает содержимое CSV в виде строки.
     */
    public function toString(): string;
}
