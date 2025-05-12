<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CanchaController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PagosController;
use App\Http\Controllers\DisponibilidadController;
use Nuwave\Lighthouse\Http\Controllers\GraphQLController;

Route::get('/ping', function () {
    return response()->json(['message' => 'API activa'], 200);
});

Route::middleware(['api'])->group(function () {
    Route::apiResource('canchas', CanchaController::class);
    Route::apiResource('reservas', ReservaController::class);
    Route::apiResource('pagos', PagosController::class);
    Route::apiResource('disponibilidades', DisponibilidadController::class); 
});

Route::post('/graphql', '\Nuwave\Lighthouse\Support\Http\Controllers\GraphQLController@query');

Route::apiResource('usuarios', UsuarioController::class);
