<?php

namespace App\Domain\Restaurant\Interfaces;

use App\Domain\Restaurant\Models\BusinessHour;
use Illuminate\Database\Eloquent\Collection;

interface BusinessHourRepositoryInterface
{
    public function getAll(): Collection;

    public function findById(int $id): ?BusinessHour;

    public function findByDay(int $dayOfWeek): ?BusinessHour;
}
