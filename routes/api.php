<?php

use App\Http\Controllers\Operation\ParksController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/test', function (Request $request) {});
Route::get('/park', [ParksController::class, 'index']);
Route::post('/park', [ParksController::class, 'store']);
Route::put('/park/{id}', [ParksController::class, 'update']);
Route::delete('/park/{id}', [ParksController::class, 'destroy']);