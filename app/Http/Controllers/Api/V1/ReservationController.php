<?php

namespace App\Http\Controllers\Api\V1;

use App\Domain\Reservation\Services\ReservationService;
use App\Domain\Reservation\Services\TableService;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReservationRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
     * Store a newly created resource in storage.
     *
     *
     * @OA\Post(
     *     path="/api/v1/reservations",
     *     summary="Create a reservation",
     *     tags={"Reservation"},
     *
     *     @OA\Parameter(
     *         name="name",
     *         in="query",
     *         description="Customer's name",
     *         required=true,
     *
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\Parameter(
     *         name="email",
     *         in="query",
     *         description="Customer's email",
     *         required=true,
     *
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\Parameter(
     *         name="phone",
     *         in="query",
     *         description="Customer's phone",
     *
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\Parameter(
     *         name="date",
     *         in="query",
     *         description="Reservation date e.g. 2024-01-22",
     *         required=true,
     *
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\Parameter(
     *         name="time",
     *         in="query",
     *         description="Reservation time e.g. 17:00",
     *         required=true,
     *
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\Parameter(
     *         name="special_request",
     *         in="query",
     *         description="Special Request",
     *
     *         @OA\Schema(type="string")
     *     ),
     *
     *     @OA\Response(
     *          response=200,
     *          description="Success",
     *
     *          @OA\JsonContent(
     *
     *              @OA\Property(property="status", type="string", example="success"),
     *          )
     *     ),
     *
     *     @OA\Response(
     *          response=403,
     *          description="Error",
     *
     *          @OA\JsonContent(
     *
     *              @OA\Property(property="status", type="string", example="error"),
     *              @OA\Property(property="message", type="string", example="Error message")
     *          )
     *      ),
     *
     *     @OA\Response(
     *          response=422,
     *          description="Validation error",
     *
     *          @OA\JsonContent(
     *
     *              @OA\Property(property="message", type="string", example="error"),
     *              @OA\Property(
     *                  property="errors", type="object",
     *                  @OA\Property(
     *                      property="property",
     *                      type="array",
     *                      collectionFormat="multi",
     *
     *                      @OA\Items(type="string", example="Validation message")
     *                  ),
     *              ),
     *          )
     *      ),
     *
     *     @OA\Response(
     *          response=500,
     *          description="Error",
     *
     *          @OA\JsonContent(
     *
     *              @OA\Property(property="status", type="string", example="error"),
     *              @OA\Property(property="message", type="string", example="Error message")
     *          )
     *      )
     * )
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
                return response()->json([
                    'status' => 'error',
                    'message' => 'Table not available',
                ], 403);

                return redirect()->back()->with('error', 'Table not available');
            }
            $data['table_id'] = $availableTables->first()->id;
            $reservation = $this->reservationService->createReservation($data);

            DB::commit();
            $lock->release();

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
