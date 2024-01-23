<?php

namespace App\Domain\Reservation\Interfaces;

use App\Domain\Reservation\Models\Table;
use Illuminate\Database\Eloquent\Collection;

interface TableRepositoryInterface
{
    public function allTables(): Collection;

    public function findById(int $tableId): ?Table;

    public function countTable(): int;

    public function getAvailableTables(string $date, string $time): Collection;
}
