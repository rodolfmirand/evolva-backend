<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\JourneyController;

Route::middleware('auth:sanctum')->group(function () {
    // Rotas de usuários
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::patch('/users/{user}', [AuthController::class, 'update']);

    // Rotas de jornadas
    Route::post('/journeys', [JourneyController::class, 'store']);
    Route::post('/journeys/join', [JourneyController::class, 'join']);
    Route::get('/journeys', [JourneyController::class, 'index']);
    Route::get('/journeys/{id}', [JourneyController::class, 'show']);

});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
