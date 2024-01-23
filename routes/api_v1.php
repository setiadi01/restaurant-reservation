<?php

use App\Http\Controllers\Api\V1\ReservationController;
use App\Http\Controllers\Api\V1\TableController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes v1
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('tables/available-timeslots', [TableController::class, 'getAvailableTimeslots']);
Route::post('reservations', [ReservationController::class, 'store']);
