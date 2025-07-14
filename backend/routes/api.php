<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'login']);

Route::get('/ping', function () {
    return response()->json(['pong' => true]);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // User Management (Admin only)
    Route::middleware('admin')->group(function () {
        Route::apiResource('/users', App\Http\Controllers\UserController::class)->except(['show']);
    });
    Route::get('/users/{user}', [App\Http\Controllers\UserController::class, 'show']);

    // Task Management
    Route::apiResource('/tasks', App\Http\Controllers\TaskController::class);
    Route::patch('/tasks/{task}/status', [App\Http\Controllers\TaskController::class, 'updateStatus']);
});

Route::options('{any}', function () {
    return response()->json([], 200);
})->where('any', '.*');