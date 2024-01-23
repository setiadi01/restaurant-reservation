<?php

namespace App\Domain\Restaurant\Services;

use App\Domain\Restaurant\Interfaces\BusinessHourRepositoryInterface;

class BusinessHourService
{
    private BusinessHourRepositoryInterface $businessHourRepository;

    public function __construct(BusinessHourRepositoryInterface $businessHourRepository)
    {
        $this->businessHourRepository = $businessHourRepository;
    }

    public function getTimeslotsByDay($dayOfWeek)
    {
        $businessHour = $this->businessHourRepository->findByDay($dayOfWeek);
        $interval = 30;
        $startTime = $businessHour->opening_time;
        $endTime = $businessHour->closing_time;
        $i = 0;
        $times = [];

        while (strtotime($startTime) <= strtotime($endTime)) {
            $start = $startTime;
            $end = date('H:i:s', strtotime('+'.$interval.' minutes', strtotime($startTime)));
            $startTime = date('H:i:s', strtotime('+'.$interval.' minutes', strtotime($startTime)));
            $i++;
            if (strtotime($startTime) <= strtotime($endTime)) {
                $times[] = [
                    'start_time' => $start,
                    'end_time' => $end,
                ];
            }
        }

        return $times;
    }
}
