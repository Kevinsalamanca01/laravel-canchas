<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CanchaController;
use App\Http\Controllers\ReservaController;

Route::apiResource('canchas', CanchaController::class);
Route::apiResource('reservas', ReservaController::class);
