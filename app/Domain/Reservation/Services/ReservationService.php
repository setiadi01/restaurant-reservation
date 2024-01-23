<?php

namespace App\Domain\Reservation\Services;

use App\Domain\Reservation\Interfaces\ReservationRepositoryInterface;
use App\Domain\Reservation\Models\Reservation;
use Illuminate\Database\Eloquent\Collection;

class ReservationService
{
    private ReservationRepositoryInterface $reservationRepository;

    public function __construct(ReservationRepositoryInterface $reservationRepository)
    {
        $this->reservationRepository = $reservationRepository;
    }

    public function getAllReservations(): Collection
    {
        return $this->reservationRepository->allReservations();
    }

    public function getReservationsByDate(string $date): Collection
    {
        return $this->reservationRepository->getByDate($date);
    }

    public function createReservation(array $data): Reservation
    {
        $reservation = new Reservation([
            'table_id' => $data['table_id'],
            'date' => $data['date'],
            'time' => $data['time'],
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'special_request' => $data['special_request'],
        ]);

        return $this->reservationRepository->save($reservation);
    }
}
