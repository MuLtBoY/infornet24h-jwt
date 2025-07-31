<?php

use App\Http\Controllers\AssistanceController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GeocodeController;
use App\Http\Controllers\PurveyorController;
use Illuminate\Support\Facades\Route;

Route::post('cadastrar', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:api')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);

    Route::prefix('servicos')->group(function () {
        Route::post('/criar', [AssistanceController::class, 'store']);
        Route::get('/buscar', [AssistanceController::class, 'show']);
        Route::get('/listar', [AssistanceController::class, 'index']);
        Route::put('/atualizar', [AssistanceController::class, 'update']);
        Route::delete('/excluir', [AssistanceController::class, 'destroy']);
    });

    Route::prefix('prestadores')->group(function () {
        Route::post('/criar', [PurveyorController::class, 'store']);
        Route::get('/buscar', [PurveyorController::class, 'show']);
        Route::put('/atualizar', [PurveyorController::class, 'update']);
        Route::delete('/excluir', [PurveyorController::class, 'destroy']);
        Route::get('/filtrar', [PurveyorController::class, 'search']);
    });

    Route::get('/geolocalizacao', [GeocodeController::class, 'geocodeByAddress']);
});

