<?php

namespace App\Http\Controllers\Api\V1;

use App\Domain\Reservation\Services\TableService;
use App\Http\Controllers\Controller;
use App\Http\Requests\AvailableTimeslotsRequest;
use OpenApi\Annotations as OA;

class TableController extends Controller
{
    private TableService $tableService;

    public function __construct(TableService $tableService)
    {
        $this->tableService = $tableService;
    }

    /**
     * @OA\Get(
     *     path="/api/v1/tables/available-timeslots",
     *     summary="Get available timeslots by date",
     *     tags={"Table"},
     *
     *     @OA\Parameter(
     *         name="date",
     *         in="query",
     *         description="Date e.g. 2024-01-22",
     *         required=false,
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
     *              @OA\Property(property="data", type="object", example={}),
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
     *     @OA\Response(response=500, description="Error", @OA\JsonContent(@OA\Property(property="message", type="string", example="Error message")))
     * )
     */
    public function getAvailableTimeslots(AvailableTimeslotsRequest $request)
    {
        $input = $request->validated();
        $timeslots = $this->tableService->getAvailableTimeslots($input['date']);

        return response()->json([
            'data' => $timeslots,
        ]);
    }
}
