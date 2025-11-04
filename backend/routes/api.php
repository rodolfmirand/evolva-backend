<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\UserController;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user(); // retorna os dados do usuário autenticado
    });
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::patch('/users/{user}', [UserController::class, 'update']);
    Route::get('/users/{userId}/journeys', [UserController::class, 'journeys']);

});

Route::post('/register', [UserController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
