<?php

use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Operation\DashboardController;
use App\Http\Controllers\Operation\ParksController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/test', function (Request $request) {});

Route::get('/park', [DashboardController::class, 'countActiveUsers']);
Route::post('/park', [UserController::class, 'store']);
Route::put('/park/{id}', [UserController::class, 'update']);
Route::delete('/park/{id}', [UserController::class, 'destroy']);
