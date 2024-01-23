<?php

namespace App\Http\Controllers;

use App\Domain\Reservation\Interfaces\TableRepositoryInterface;
use App\Domain\Reservation\Services\ReservationService;
use App\Domain\Reservation\Services\TableService;
use App\Http\Requests\StoreReservationRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class HomeController extends Controller
{
    private TableRepositoryInterface $tableRepository;

    private ReservationService $reservationService;

    private TableService $tableService;

    public function __construct(
        TableRepositoryInterface $tableRepository,
        ReservationService $reservationService,
        TableService $tableService,
    ) {
        $this->tableRepository = $tableRepository;
        $this->reservationService = $reservationService;
        $this->tableService = $tableService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tables = $this->tableRepository->allTables();

        return Inertia::render('Welcome', [
            'canLogin' => Route::has('login'),
            'canRegister' => Route::has('register'),
            'tables' => $tables,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReservationRequest $request)
    {
        $data = $request->validated();
        try {
            // prevent race condition
            $lock = Cache::lock('reservations', 10);

            DB::beginTransaction();
            $availableTables = $this->tableService->getAvailableTables($data['date'], $data['time']);
            if ($availableTables->count() == 0) {
                return to_route('home')->with('error', 'Table not available');
            }
            $data['table_id'] = $availableTables->first()->id;
            $reservation = $this->reservationService->createReservation($data);

            DB::commit();
            $lock->release();

            return to_route('home')->with('success', 'Success');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);

            return to_route('home')->with('error', $e->getMessage());
        }
    }
}
