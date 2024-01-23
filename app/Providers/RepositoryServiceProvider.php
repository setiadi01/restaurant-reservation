<?php

namespace App\Providers;

use App\Domain\Reservation\Interfaces\ReservationRepositoryInterface;
use App\Domain\Reservation\Interfaces\TableRepositoryInterface;
use App\Domain\Reservation\Repositories\ReservationRepository;
use App\Domain\Reservation\Repositories\TableRepository;
use App\Domain\Restaurant\Interfaces\BusinessHourRepositoryInterface;
use App\Domain\Restaurant\Repositories\BusinessHourRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Registered Repositories
        $this->app->bind(TableRepositoryInterface::class, TableRepository::class);
        $this->app->bind(ReservationRepositoryInterface::class, ReservationRepository::class);
        $this->app->bind(BusinessHourRepositoryInterface::class, BusinessHourRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
