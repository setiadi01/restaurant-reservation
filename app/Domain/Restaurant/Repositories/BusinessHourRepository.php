<?php

namespace App\Domain\Restaurant\Repositories;

use App\Domain\Restaurant\Interfaces\BusinessHourRepositoryInterface;
use App\Domain\Restaurant\Models\BusinessHour;
use Illuminate\Database\Eloquent\Collection;

class BusinessHourRepository implements BusinessHourRepositoryInterface
{
    public function getAll(): Collection
    {
        return BusinessHour::all();
    }

    public function findById(int $id): ?BusinessHour
    {
        return BusinessHour::find($id);
    }

    public function findByDay(int $dayOfWeek): ?BusinessHour
    {
        return BusinessHour::where('day_of_week', $dayOfWeek)->first();
    }
}
