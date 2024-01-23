<?php

namespace App\Domain\Reservation\Repositories;

use App\Domain\Reservation\Interfaces\ReservationRepositoryInterface;
use App\Domain\Reservation\Models\Reservation;
use Illuminate\Database\Eloquent\Collection;

class ReservationRepository implements ReservationRepositoryInterface
{
    public function save(Reservation $reservation): Reservation
    {
        $reservation->save();

        return $reservation;
    }

    public function findById(int $reservationId): ?Reservation
    {
        return Reservation::find($reservationId);
    }

    public function getByDate(string $date): Collection
    {
        return Reservation::where('date', $date)->get();
    }

    public function getByDateTime(string $date, $time): Collection
    {
        return Reservation::where('date', $date)->where('time', $time)->get();
    }

    public function allReservations(): Collection
    {
        return Reservation::with('table')->latest()->get();
    }
}
