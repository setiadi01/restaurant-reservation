<?php

namespace App\Domain\Reservation\Repositories;

use App\Domain\Reservation\Interfaces\TableRepositoryInterface;
use App\Domain\Reservation\Models\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class TableRepository implements TableRepositoryInterface
{
    public function allTables(): Collection
    {
        return Table::orderBy('number', 'asc')->limit(50)->get();
    }

    public function findById(int $tableId): ?Table
    {
        return Table::find($tableId);
    }

    public function countTable(): int
    {
        return Table::count();
    }

    public function getAvailableTables(string $date, string $time): Collection
    {
        $tables = Table::whereDoesntHave('reservations', function (Builder $query) use ($date, $time) {
            $query->where('date', $date)->where('time', $time);
        })->get();

        return $tables;
    }
}
