<?php

namespace App\Http\Controllers;

use App\Domain\Reservation\Services\ReservationService;
use App\Domain\Reservation\Services\TableService;
use App\Http\Requests\StoreReservationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class ReservationController extends Controller
{
    private $reservationService;

    private $tableService;

    public function __construct(ReservationService $reservationService, TableService $tableService)
    {
        $this->reservationService = $reservationService;
        $this->tableService = $tableService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = $this->reservationService->getAllReservations();

        return Inertia::render('Reservation/Index', [
            'reservations' => $reservations,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Reservation/Create');
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
                return redirect()->back()->with('error', 'Table not available');
            }
            $data['table_id'] = $availableTables->first()->id;
            $reservation = $this->reservationService->createReservation($data);

            DB::commit();
            $lock->release();

            return to_route('reservations.index')->with('success', 'Success');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
