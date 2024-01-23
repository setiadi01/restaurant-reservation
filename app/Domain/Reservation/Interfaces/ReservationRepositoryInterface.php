<?php

namespace App\Domain\Reservation\Interfaces;

use App\Domain\Reservation\Models\Reservation;
use Illuminate\Database\Eloquent\Collection;

interface ReservationRepositoryInterface
{
    public function save(Reservation $reservation): Reservation;

    public function findById(int $reservationId): ?Reservation;

    public function getByDate(string $date): Collection;

    public function getByDateTime(string $date, string $time): Collection;

    public function allReservations(): Collection;
}
