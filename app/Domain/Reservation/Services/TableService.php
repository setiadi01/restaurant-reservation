<?php

namespace App\Domain\Reservation\Services;

use App\Domain\Reservation\Interfaces\ReservationRepositoryInterface;
use App\Domain\Reservation\Interfaces\TableRepositoryInterface;
use App\Domain\Restaurant\Services\BusinessHourService;
use Carbon\Carbon;

class TableService
{
    private TableRepositoryInterface $tableRepository;

    private ReservationRepositoryInterface $reservationRepository;

    private BusinessHourService $businessHourService;

    public function __construct(
        TableRepositoryInterface $tableRepository,
        ReservationRepositoryInterface $reservationRepository,
        BusinessHourService $businessHourService
    ) {
        $this->tableRepository = $tableRepository;
        $this->reservationRepository = $reservationRepository;
        $this->businessHourService = $businessHourService;
    }

    public function getAvailableTimeslots($date)
    {
        $dayOfWeek = Carbon::parse($date)->dayOfWeek;
        $timeslots = $this->businessHourService->getTimeslotsByDay($dayOfWeek);
        $reservations = $this->reservationRepository->getByDate($date);
        $totalTable = $this->tableRepository->countTable();
        $availableTimeslots = collect($timeslots)->map(function ($timeslot) use ($totalTable, $reservations) {
            $totalBookedTable = $reservations->where('time', $timeslot['start_time'])->count();

            return [
                'start_time' => date('H:i', strtotime($timeslot['start_time'])),
                'end_time' => date('H:i', strtotime($timeslot['end_time'])),
                'available' => $totalBookedTable < $totalTable,
            ];
        });

        return $availableTimeslots;
    }

    public function getAvailableTables($date, $time)
    {
        $availableTables = $this->tableRepository->getAvailableTables($date, $time);

        return $availableTables;
    }
}
